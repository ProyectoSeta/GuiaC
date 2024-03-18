<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $solicitudes = DB::table('solicituds')
            ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
            ->select('solicituds.*', 'sujeto_pasivos.razon_social')
            ->where('estado','=','Verificando')
            ->get();

        return view('aprobacion_solicitud', compact('solicitudes'));
    }

    public function sujeto(Request $request)
    {   
        $idSujeto = $request->post('sujeto');
        $query = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->get();
        if ($query) {
            foreach ($query as $sujeto) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <!-- <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i> -->
                                <i class="bx bx-user-circle fs-1"></i>
                                <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$sujeto->razon_social.'</h1>
                                <h5 class="modal-title" id="" style="font-size:14px">Contribuyente</h5>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:15px;">
                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                            <table class="table" style="font-size:14px">
                                <tr>
                                    <th>Tipo de Contribuyente</th>
                                    <td>'.$sujeto->tipo_sujeto.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F.</th>
                                    <td>'.$sujeto->rif.'</td>
                                </tr>
                                <tr>
                                    <th>Razon Social</th>
                                    <td>'.$sujeto->razon_social.'</td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>'.$sujeto->direccion.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono móvil</th>
                                    <td>'.$sujeto->tlf_movil.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono fijo</th>
                                    <td>'.$sujeto->tlf_fijo.'</td>
                                </tr>
                            </table>

                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Representante</h6>
                            <table class="table"  style="font-size:14px">
                                <tr>
                                    <th>C.I. del representante</th>
                                    <td>'.$sujeto->ci_repr.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F. del representante</th>
                                    <td>'.$sujeto->rif_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Nombre y Apellido</th>
                                    <td>'.$sujeto->name_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono movil</th>
                                    <td>'.$sujeto->tlf_repr.'</td>
                                </tr>
                            </table>
                        </div>';

                return response($html);
            }
        }
    }

    public function aprobar(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
       
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
        ->where('id_solicitud','=',$idSolicitud)
        ->get();
       
        $tr = '';

        if ($solicitudes) {
            foreach ($solicitudes as $solicitud) {
                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
                if($detalles){ 
                    // return response($solicitudes);
                    $contador = 0;
                    foreach ($detalles as $i) {
                        $tr .= '<tr>
                                    <td>'.$i->tipo_talonario.'</td>
                                    <td>'.$i->cantidad.'</td>
                                </tr>';

                        $contador = $contador + ($i->tipo_talonario * $i->cantidad);

                    }
                }

                $total_guias = $contador;
                $ucds = $total_guias * 5;

                ////////////////fecha de la solicitud
                $sol_date = DB::table('solicituds')
                        ->selectRaw('DATE(fecha) AS fecha')
                        ->where('id_solicitud','=',$idSolicitud)->get();
                foreach ($sol_date as $d){
                    $date_sol = $d->fecha;
                }

                //////////////valor del ucd el dia de la solicitud
                $query_ucd = DB::table('ucds')
                        ->select('valor')
                        ->where('fecha','=', $date_sol)->get();
                foreach ($query_ucd as $u){
                    $val_ucd = $u->valor;
                }

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2"></i>                       
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar la siguiente solicitud?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$solicitud->razon_social.'</h1>
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$solicitud->rif.'</h5>
                                </div>
                            </div>
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
                            <div class="d-flex justify-content-center mt-3">
                                <table class="table table-sm w-75">
                                    <tr>
                                        <th>Total de Guías a emitir</th>
                                        <td>'.$total_guias.'</td>
                                    </tr>
                                    <tr>
                                        <th>UCD a pagar</th>
                                        <td>'.$ucds.'</td>
                                    </tr>
                                    <tr>
                                        <th>Precio del UCD (al día)</th>
                                        <td>'.$val_ucd.'</td>
                                    </tr>
                                    <tr>
                                        <th>Monto total</th>
                                        <td>'.$solicitud->monto.'</td>
                                    </tr>
                                    <tr>
                                        <th>Referencia</th>
                                        <td><a target="_blank" href="{{asset('.$solicitud->referencia.')}}">Ver</a></td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm me-4 aprobar_correlativo" id_solicitud="'.$idSolicitud.'" id_sujeto="'.$solicitud->id_sujeto.'" fecha="'.$date_sol.'" >Aprobar</button>
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </div>';

                        return response($html);
            }

        }






    }

    public function correlativo(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $idSujeto = $request->post('sujeto');
        $fecha = $request->post('fecha');

        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->get(); 
        if ($query_count) {
            foreach ($query_count as $c) {
                $count = $c->total;
            }
            if($count == 0){ //////////No hay ningun registro en la tabla Talonarios
                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
                $c = 0;
                foreach ($detalles as $detalle) { ////////talonarios que el contribuyente solicito
                    $tipo = $detalle->tipo_talonario;
                    $cant = $detalle->cantidad;

                    for ($i=1; $i <=$cant; $i++) {                        
                        $c = $c + 1; 
                        
                        if ($c == 1) {
                           $desde = 1;
                        }else{
                            $id_max= DB::table('talonarios')->max('id_talonario');
                            $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                            foreach ($query_hasta as $hasta) {
                                $prev_hasta = $hasta->hasta;
                            }
                            $desde = $prev_hasta + 1;
                        }
                        
                        $hasta = $desde + $tipo;

                        $length = 6;
                        $string_1 = substr(str_repeat(0, $length).$desde, - $length);
                        $string_2 = substr(str_repeat(0, $length).$hasta, - $length);

                        $desde_co = 'AB'.$string_1;
                        $hasta_co = 'AB'.$string_2;

                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'desde_co' => $desde_co,
                                            'hasta_co' => $hasta_co, 'fecha_emision' => $fecha]);
                        if ($insert) {
                            $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 'En proceso']);
                        }
                    } ////cierra for    
                }/////cierra foreach
            }else{   //////////Hay registros en la tabla Talonarios
                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
                foreach ($detalles as $detalle){
                    $tipo = $detalle->tipo_talonario;
                    $cant = $detalle->cantidad;

                    for ($i=1; $i <=$cant; $i++) {  
                        $id_max= DB::table('talonarios')->max('id_talonario');
                        $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                        foreach ($query_hasta as $hasta) {
                            $prev_hasta = $hasta->hasta;
                        }
                        $desde = $prev_hasta + 1;
                        $hasta = $desde + $tipo;
                        
                        $length = 6;
                        $string_1 = substr(str_repeat(0, $length).$desde, - $length);
                        $string_2 = substr(str_repeat(0, $length).$hasta, - $length);

                        $desde_co = 'AB'.$string_1;
                        $hasta_co = 'AB'.$string_2;

                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'desde_co' => $desde_co,
                                            'hasta_co' => $hasta_co, 'fecha_emision' => $fecha]);
                        if ($insert) {
                            $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 'En proceso']);
                        }
    
                    } ////cierra for
                } ////cierra foreach
            }
           
            return response()->json(['success' => true]);
        }
    }

    public function info(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $tables = '';
        $talonarios = DB::table('talonarios')
        ->join('sujeto_pasivos', 'talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('talonarios.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
        ->where('id_solicitud','=',$idSolicitud)
        ->get();

        if ($talonarios) {
            $i=0;
            foreach ($talonarios as $talonario) {
                $i = $i + 1;
                $tables .= ' <span class="ms-3">Talonario Nro. '.$i.'</span>
                                <table class="table mt-2 mb-3">
                                    <tr>
                                        <th>Tipo:</th>
                                        <td>'.$talonario->tipo_talonario.'</td>
                                        <th>Desde:</th>
                                        <td>'.$talonario->desde_co.'</td>
                                        <th>Hasta:</th>
                                        <td>'.$talonario->hasta_co.'</td>
                                    </tr>
                                </table>';
            }

            $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¡La solicitud a sido Aprobada!</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$talonario->razon_social.'</h1>
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$talonario->rif.'</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px">
                            <p class="text-center" style="font-size:14px">El correlativo correspondiente a la solicitud generada es el siguiente:</p>
                                '.$tables.'
                            <div class="d-flex justify-content-center">
                                <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>';
            return response($html);
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
