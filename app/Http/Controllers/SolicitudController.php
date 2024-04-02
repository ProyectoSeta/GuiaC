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
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $solicitudes = DB::table('solicituds')->where('id_sujeto', $id_sp)->get();

        // var_dump($solicitudes);
        return view('solicitud',compact('solicitudes'));

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
    // public function store(Request $request)
    // {   
    //     $user = auth()->id();
    //     $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
    //     $id_sp = $sp->id_sujeto;


    //     ////////VALIDACION DE CANTERAS
    //     $query_count_canteras = DB::table('canteras')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->get(); 
    //     if ($query_count_canteras) {
    //         foreach ($query_count_canteras as $key => $c) {
    //             $count = $c->total;
    //         }
    //         ///////VERIFICACION DE CANTERAS REGISTRADAS
    //         if ($count != 0) {
    //             //////existen canteras registras para este sujeto
    //             $query_canteras = DB::table('canteras')->select('status')->where('id_sujeto','=',$id_sp)->get();
    //             $contador = 0;
    //             foreach ($query_canteras as $cantera) {
    //                 ////////VERIFICACION SI HAY CANTERAS VERIFICADAS
    //                 if ($cantera->status == 'Verificada') {
    //                     $contador = $contador + 1;
    //                 }else{
    //                     $contador = $contador;
    //                 }
    //             }
    //             if ($contador != 0) {
    //                 /////hay cantera(s) verificadas
                    
    //                 $tipo = $request->post('tipo');
    //                 $cant = $request->post('cantidad');
    //                 // $monto = $request->post('monto_talonario');

    //                 $year = date("Y");
    //                 $mes = date("F");
                  

    //                 $total_guias_solicitadas = $tipo * $cant;
    //                 $limites = DB::table('limite_guias')->where('id_sujeto','=',$id_sp)->get();
    //                 $total_guias = '';
    //                 foreach ($limites as $limite) {
    //                     $total_guias_periodo = $limite->total_guias_periodo;
    //                     $total_guias_solicitadas_periodo = $limite->total_guias_solicitadas_periodo;
    //                     $mes_limite = $limite->fin_periodo;
    //                 }
    //                 $total_guias = $total_guias_solicitadas_periodo +  $total_guias_solicitadas;

    //                 $otroC = $request->post('status_otro_tipo');

    //                 /////////////////////VERIFICACION DEL LIMITE DE GUIAS POR MES
    //                 if ($total_guias <= $total_guias_periodo) { //////el numero de guias a solicitar no sobrepasa el limite del mes
    //                     if ($otroC == 'true') {     ///////DOS (2) TIPOS DE TALONARIOS
    //                         $tipo2 = $request->post('tipo2');
    //                         $cant2 = $request->post('cantidad2');
                                    
    //                         $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'monto'=>$monto, 'referencia' => $ruta_n, 'estado' => 'Verificando']);
                            
    //                         if($query_solicitud){
    //                             $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                            
    //                             $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
    //                             $query_detalle_2 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 'cantidad' => $cant2, 'id_solicitud' => $id_solicitud]);

    //                             //////////////////ACTUALIZACIÓN DEL LIMITE DE GUIAS
    //                             if ($mes_limite == $mes) {
    //                                 $update_limite = DB::table('limite_guias')->where('id_sujeto', '=', $id_sp)->update(['total_guias_solicitadas_mes' => $total_guias]);
    //                             }else {
    //                                 $total_guias =  $total_guias_solicitadas;
    //                                 $update_limite = DB::table('limite_guias')->where('id_sujeto', '=', $id_sp)->update(['total_guias_solicitadas_mes' => $total_guias]);
    //                             }

    //                             if($query_detalle_1 && $query_detalle_2){
    //                                 return response()->json(['success' => true]);
    //                             }
    //                         }
                          
    //                     }
    //                     else{      ///////UN (1) TIPO DE TALONARIO
                            
    //                         if ($request->hasFile('ref_pago')) {
    //                             $photo         =   $request->file('ref_pago');
    //                             $nombreimagen  =   $photo->getClientOriginalName();
    //                             $ruta          =   public_path('assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
    //                             $ruta_n        = 'assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen;
    //                             if(copy($photo->getRealPath(),$ruta)){
                                    
    //                                 $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'monto'=>$monto, 'referencia' => $ruta_n, 'estado' => 'Verificando']);

    //                                 if($query_solicitud){
    //                                     $id_solicitud = DB::table('solicituds')->max('id_solicitud');
    //                                     $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
                                        
    //                                     //////////////////ACTUALIZACIÓN DEL LIMITE DE GUIAS
    //                                     if ($mes_limite == $mes) {
    //                                         $update_limite = DB::table('limite_guias')->where('id_sujeto', '=', $id_sp)->update(['total_guias_solicitadas_mes' => $total_guias]);
    //                                     }else {
    //                                         $total_guias =  $total_guias_solicitadas;
    //                                         $update_limite = DB::table('limite_guias')->where('id_sujeto', '=', $id_sp)->update(['total_guias_solicitadas_mes' => $total_guias]);
    //                                     }

    //                                     if($query_detalle_1){
    //                                         return response()->json(['success' => true]);
    //                                     }
    //                                 }
    //                             }
    //                         }else{   
    //                             return response()->json(['success' => false]);
    //                         }

    //                     }////cierra else
    //                     // return response('no ha excedido');

    //                 }else{  //////el numero de guias a solicitar no sobrepasa el limite del mes
    //                     return response()->json(['success' => false, 'nota' => 'HA EXCEDIDO EL NÚMERO DE GUÍAS A SOLICITAR POR MES']);
    //                 } 

    //             }else{
    //                 //////////no hay canteras verificadas todavia
    //                 return response()->json(['success' => false, 'nota' => 'DISCULPE, DEBE TENER AL MENOS UNA (1) CANTERA VERIFICADA PARA QUE PUEDA REALIZAR LA SOLICITUD']);   
    //             }
    //         }else{
    //             ///////no hay canteras registradas para esta sujeto
    //             return response()->json(['success' => false, 'nota' => 'NO TIENE CANTERAS REGISTRADAS. POR FAVOR, REGISTRE LA CANTERA PARA REALIZAR LA SOLICITUD']);
    //         }
    //     }else{
    //         /////no se hizo la consulta count de las canteras
    //         return response()->json(['success' => false]);
    //     }


    // }

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

        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;


        ////////////ELIMINAR NUMERO DE GUIAS, EN GUIAS SOLICITADAS (LIMTE_GUIAS)/////
        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get(); 
        $guias = 0;
        
        if($detalles){
            foreach ($detalles as $solicitud) {
               $guias = $guias + ($solicitud->tipo_talonario * $solicitud->cantidad);
            }
        }
        $limites = DB::table('limite_guias')->select('total_guias_solicitadas_mes')->where('id_sujeto','=',$id_sp)->get();
        foreach ($limites as $limite) {
            $new_total_guias = $limite->total_guias_solicitadas_mes - $guias;
        }
        $update_limite = DB::table('limite_guias')->where('id_sujeto', '=', $id_sp)->update(['total_guias_solicitadas_mes' => $new_total_guias]);

         ///////////////ELIMNAR REFERENCIA//////////////////////
         $query = DB::table('solicituds')->select('referencia')->where('id_solicitud', '=', $idSolicitud)->get();
         foreach ($query as $r) {
             $ruta = $r->referencia;
         }
         $delete_ref = unlink('../public/'.$ruta);

        ///////////////ELIMINAR SOLICITUD//////////////////////////
        $delete = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->delete();
        
        if($delete && $delete_ref && $update_limite){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
