<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SujetoPasivo;
use App\Models\Solicitud;
use DB;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;

        $solicitudes = DB::table('solicituds')->where('id_sujeto', $id_sp)->get();

        // var_dump($solicitudes);
        return view('solicitud',compact('solicitudes'));

    }

    public function calcular(Request $request)
    {
        $tipo = $request->post('tipo');
        $cant = $request->post('cantidad');
        $otroC = $request->post('otro_campo');

        ///////si el sj ingreso dos tipos de talonarios
        if ($otroC == 'true') {
            $tipo2 = $request->post('tipo2');
            $cant2 = $request->post('cantidad2');

            $monto_1 = 0;
            $monto_2 = 0;

            if (($tipo == 25) || ($tipo == 50)) {
                $ucds = ($tipo * 5)*$cant; 
                $id_max = DB::table('ucds')->max('id');
                $valor = DB::table('ucds')->select('valor')->where('id','=',$id_max)->get();
                foreach ($valor as $v) {
                    $ucd_valor = $v->valor;
                    $monto_1 = $ucds * $ucd_valor;
                }
            }else{
                $monto_1 = 0;
            }
            /////////////  OTRO TIPO DE TALONARIO   /////////////
            if (($tipo2 == 25) || ($tipo2 == 50)) {
                $ucds_2 = ($tipo2 * 5)*$cant2; 
                $id_max = DB::table('ucds')->max('id');
                $valor = DB::table('ucds')->select('valor')->where('id','=',$id_max)->get();
                foreach ($valor as $v) {
                    $ucd_valor = $v->valor;
                    $monto_2 = $ucds_2 * $ucd_valor;
                }
            }else{
                $monto_2 = 0;
            }
            
            //////resultado
            $subtotal = $monto_1 + $monto_2;
            $total = number_format($subtotal, 2, ',', '.');
            return response($total);

        }else{ ////// si el sj solo ingreso un tipo de talonario
            $monto_1 = 0;

            if (($tipo == 25) || ($tipo == 50)) {
                $ucds = ($tipo * 5)*$cant; 
                $id_max = DB::table('ucds')->max('id');
                $valor = DB::table('ucds')->select('valor')->where('id','=',$id_max)->get();
                foreach ($valor as $v) {
                    $ucd_valor = $v->valor;
                    $monto_1 = $ucds * $ucd_valor;
                }
            }else{
                $monto_1 = 0;
            }

            //////resultado
            $total = number_format($monto_1, 2, ',', '.');
            return response($total);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;

        $tipo = $request->post('tipo');
        $cant = $request->post('cantidad');
        $monto = $request->post('monto_talonario');

        $year = date("Y");
        $mes = date("F");
        
        ///////////CREAR CARPETA PARA REFERENCIAS SI NO EXISTE
        if (!is_dir('../public/assets/dd/'.$year)){   ////no existe la carpeta del año
            if(mkdir('../public/assets/dd/'.$year, 0777)){
                mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
            }
        }
        else{   /////si existe la carpeta del año
            if (!is_dir('../public/assets/dd/'.$year.'/'.$mes)) {
                mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
            }
        }

        $otroC = $request->post('status_otro_tipo');

        if ($otroC == 'true') {     ///////DOS (2) TIPOS DE TALONARIOS
            $tipo2 = $request->post('tipo2');
            $cant2 = $request->post('cantidad2');

            if ($request->hasFile('ref_pago')) {
                $photo         =   $request->file('ref_pago');
                $nombreimagen  =   $photo->getClientOriginalName();
                $ruta          =   public_path('assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
                $ruta_n        = 'assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen;
                if(copy($photo->getRealPath(),$ruta)){
                    
                    $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'monto'=>$monto, 'referencia' => $ruta_n, 'estado' => 'Verificando']);
                    
                    if($query_solicitud){
                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                      
                        $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
                        $query_detalle_2 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 'cantidad' => $cant2, 'id_solicitud' => $id_solicitud]);
                        
                        if($query_detalle_1 && $query_detalle_2){
                            return response()->json(['success' => true]);
                        }
                    }
                }
            }else{   
                return response()->json(['success' => false]);
            }

        }else{      ///////UN (1) TIPO DE TALONARIO
            
            if ($request->hasFile('ref_pago')) {
                $photo         =   $request->file('ref_pago');
                $nombreimagen  =   $photo->getClientOriginalName();
                $ruta          =   public_path('assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
                $ruta_n        = 'assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen;
                if(copy($photo->getRealPath(),$ruta)){
                    
                    $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'monto'=>$monto, 'referencia' => $ruta_n, 'estado' => 'Verificando']);

                    if($query_solicitud){
                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                        $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
                        
                        if($query_detalle_1){
                            return response()->json(['success' => true]);
                        }
                    }
                }
            }else{   
                return response()->json(['success' => false]);
            }

        }

    }

    public function talonarios(Request $request){

        $idSolicitud = $request->post('id');

        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;
        $razon = $sp->razon_social;
        $rif = $sp->rif;

        $tr = '';

        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
        if($detalles){
            foreach ($detalles as $solicitud) {
                $tr .= '<tr>
                            <td>'.$solicitud->tipo_talonario.'</td>
                            <td>'.$solicitud->cantidad.'</td>
                        </tr>';
            }
        }
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-beetwen">
                    <div class="ps-3">
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff">'.$razon.'</h1>
                        <span class="text-muted">'.$rif.'</span>
                    </div>
                    <button type="button" class="btn-close pe-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:14px;">
                    <h6 class="text-center mb-3">Solicitud de Talonario(s) Realizada</h6>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Tipo de talonario</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tr.'
                        </tbody>
                    </table>
                    <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                    </span> El <span class="fw-bold">Tipo de talonario </span>
                    es definido por el número de guías que contenga este. 
                </p>
                </div>';

        return response($html);
       
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $query = DB::table('solicituds')->select('referencia')->where('id_solicitud', '=', $idSolicitud)->get();
        foreach ($query as $r) {
            $ruta = $r->referencia;
        }

        $delete_ref = unlink('../public/'.$ruta);
        $delete = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->delete();
        
        if($delete && $delete_ref){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
