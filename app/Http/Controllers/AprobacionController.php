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
            ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
            ->where('solicituds.estado','=','Verificando')
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
                                <i class="bx bx-user-circle fs-1" style="color:#0072ff"></i>
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
                                <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
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
                                        <td><a target="_blank" href="'.asset($solicitud->referencia).'">Ver</a></td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm me-4 aprobar_correlativo" id_solicitud="'.$idSolicitud.'" id_sujeto="'.$solicitud->id_sujeto.'" fecha="'.$date_sol.'" >Aprobar</button>
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

                    for ($i=1; $i <= $cant; $i++) {                        
                        $c = $c + 1; 
                        
                        if ($c == 1) {
                           $desde = 1;
                           $hasta = $tipo;

                        }else{
                            $id_max= DB::table('talonarios')->max('id_talonario');
                            $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                            foreach ($query_hasta as $hasta) {
                                $prev_hasta = $hasta->hasta;
                            }
                            $desde = $prev_hasta +1;
                            $hasta = ($desde + $tipo)-1;
                        }
                        
                        $contador_guia = $desde;
//                         ////////////////INSERTAR CORRELATIVO DE LOS NUMEROS DE CONTROL
//                         for ($i=1; $i<=$tipo; $i++) {
                            
//                             $nro_control = '';
//                             do {
//                                 $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//                                 $nro_control_relativo = substr(str_shuffle($caracteres), 0, 8); 
//                                 $search_control = DB::table('numero_controls')->selectRaw("count(*) as total")->where('nro_control','=',$nro_control_relativo)->get();
                                
//                                 foreach ($search_control as $search) {
//                                     if ($search->total != 0) {
//                                         ///////hay un registro con ese numero de control
//                                         $seguir = true;
//                                     }else{
//                                         //////no hay registros con ese numero de control
//                                         $nro_control = $nro_control_relativo;
//                                         $seguir = false;
//                                     }
//                                 }
// echo ('a');
//                             } while ($ == );

//                             $insert_control = DB::table('numero_controls')->insert(['id_solicitud' => $idSolicitud, 'nro_guia'=>$contador_guia, 'nro_control' => $nro_control]);
//                             if ($insert_control) {
//                                 $contador_guia = $contador_guia + 1;
//                             }
                            
//                         }
                        ////////////////////////////////////////

                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'fecha_emision' => $fecha]);
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

                    for ($i=1; $i <= $cant; $i++) {  
                        $id_max= DB::table('talonarios')->max('id_talonario');
                        $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                        foreach ($query_hasta as $hasta) {
                            $prev_hasta = $hasta->hasta;
                        }
                        $desde = $prev_hasta +1;
                        $hasta = ($desde + $tipo)-1;
                        
                        // $length = 6;
                        // $string_1 = substr(str_repeat(0, $length).$desde, - $length);
                        // $string_2 = substr(str_repeat(0, $length).$hasta, - $length);

                        // $desde_co = 'AB'.$string_1;
                        // $hasta_co = 'AB'.$string_2;

                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'fecha_emision' => $fecha]);
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

    public function denegarInfo(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.fecha','solicituds.id_sujeto', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
        ->where('id_solicitud','=',$idSolicitud)
        ->get();
        foreach ($solicitudes as $s) {
            $razon = $s->razon_social;
            $rif = $s->rif;
            $fecha = $s->fecha;
        }

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

        $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>                  
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Denegar la solicitud</h1>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:14px">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <table class="table table-borderless table-sm me-3">
                            <tr>
                                <th>Solicitud Nro.:</th>
                                <td>'.$idSolicitud.'</td>
                            </tr>
                            <tr>
                                <th>Fecha de emisión:</th>
                                <td>'.$fecha.'</td>
                            </tr>
                        </table>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th>Razon social.:</th>
                                <td>'.$razon.'</td>
                            </tr>
                            <tr>
                                <th>R.I.F.:</th>
                                <td>'.$rif.'</td>
                            </tr>
                        </table>
                    </div>

                    
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
                    <form id="form_denegar_solicitud" method="post" onsubmit="event.preventDefault(); denegarSolicitud()">
                        
                        <div class="ms-2 me-2">
                            <label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span>
                            <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                            <input type="hidden" name="id_solicitud" value="'.$idSolicitud.'">
                        </div>
                        <div class="text-muted text-end" style="font-size:13px">
                            <span class="text-danger">*</span> Campos Obligatorios
                        </div>
                    
                        <div class="mt-3 mb-2">
                            <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                </span>Las <span class="fw-bold">Observaciones </span>
                                cumplen la función de notificar al <span class="fw-bold">Contribuyente</span>
                                del porque la solicitud ha sido negada. Para que así, puedan rectificar y cumplir con el deber formal.
                            </p>
                        </div>

                        <div class="d-flex justify-content-center m-3">
                            <button type="submit" class="btn btn-danger btn-sm me-4">Denegar</button>
                            <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>';

            return response($html);
    }

    public function denegar(Request $request)
    {
        $idSolicitud = $request->post('id_solicitud');
        $observacion = $request->post('observacion');

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
        
        ////////////////CAMBIAR ESTADO DE SOLICITUD A DENEGADA
        $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 'Negada', 'observaciones' => $observacion]);
        
        if ($updates && $update_limite) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
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
