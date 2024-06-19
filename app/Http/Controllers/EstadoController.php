<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $t_enviar = [];
        $t_enviados = [];
        $t_recibidos = [];


        //////////////TALONARIOS POR ENVIAR
        $consulta_enviar = DB::table('talonarios')->where('estado','=',20)->get();
        foreach ($consulta_enviar as $c) {
            $detalle = DB::table('detalle_talonarios')
                        ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                        ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
                        ->select('detalle_talonarios.id_sujeto', 'detalle_talonarios.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                        ->where('detalle_talonarios.id_talonario','=',$c->id_talonario)->first();
            if ($detalle) {
                $array = array(
                    'id_talonario' => $c->id_talonario,
                    'id_solicitud' => $c->id_solicitud,
                    'id_cantera' => $detalle->id_cantera,
                    'id_sujeto' => $detalle->id_sujeto,
                    'nombre_cantera' => $detalle->nombre,
                    'razon_social' => $detalle->razon_social,
                    'rif_condicion' => $detalle->rif_condicion,
                    'rif_nro' => $detalle->rif_nro,
                    'tipo' => $c->tipo_talonario,
                    'desde' => $c->desde,
                    'hasta' => $c->hasta,
                    );

                $a = (object) $array;
                array_push($t_enviar, $a);
            }
        }


        //////////////TALONARIOS ENVIADOS
        $consulta_enviados = DB::table('talonarios')->where('estado','=',21)->get();
        foreach ($consulta_enviados as $c) {
            $detalle = DB::table('detalle_talonarios')
                        ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                        ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
                        ->select('detalle_talonarios.id_sujeto', 'detalle_talonarios.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                        ->where('detalle_talonarios.id_talonario','=',$c->id_talonario)->first();
            if ($detalle) {
                $array = array(
                    'id_talonario' => $c->id_talonario,
                    'id_solicitud' => $c->id_solicitud,
                    'id_cantera' => $detalle->id_cantera,
                    'id_sujeto' => $detalle->id_sujeto,
                    'nombre_cantera' => $detalle->nombre,
                    'razon_social' => $detalle->razon_social,
                    'rif_condicion' => $detalle->rif_condicion,
                    'rif_nro' => $detalle->rif_nro,
                    'tipo' => $c->tipo_talonario,
                    'desde' => $c->desde,
                    'hasta' => $c->hasta,
                    );

                $a = (object) $array;
                array_push($t_enviados, $a);
            }
        }



        //////////////TALONARIOS RECIBIDOS
        $consulta_recibidos = DB::table('talonarios')->where('estado','=',22)->get();
        foreach ($consulta_recibidos as $c) {
             $detalle = DB::table('detalle_talonarios')
                         ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                         ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
                         ->select('detalle_talonarios.id_sujeto', 'detalle_talonarios.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                         ->where('detalle_talonarios.id_talonario','=',$c->id_talonario)->first();
             if ($detalle) {
                 $array = array(
                     'id_talonario' => $c->id_talonario,
                     'id_solicitud' => $c->id_solicitud,
                     'id_cantera' => $detalle->id_cantera,
                     'id_sujeto' => $detalle->id_sujeto,
                     'nombre_cantera' => $detalle->nombre,
                     'razon_social' => $detalle->razon_social,
                     'rif_condicion' => $detalle->rif_condicion,
                     'rif_nro' => $detalle->rif_nro,
                     'tipo' => $c->tipo_talonario,
                     'desde' => $c->desde,
                     'hasta' => $c->hasta,
                     );
 
                 $a = (object) $array;
                 array_push($t_recibidos, $a);
             }
         }









        
        
            
        $count_proceso = DB::table('solicituds')->selectRaw("count(*) as total")->where('estado','=',17)->first();
        $count_retirar = DB::table('solicituds')->selectRaw("count(*) as total")->where('estado','=',18)->first();

        $count = DB::table('solicituds')->selectRaw("count(*) as total")
                                        ->where('estado','!=','Verificando')
                                        ->where('estado','!=','Negada')
                                        ->where('estado','!=','Retirado')->first();

        if ($count->total == 0) {
            $porcentaje_proceso = 0;
            $porcentaje_retirar = 0;
        }else{
            $porcentaje_proceso = ($count_proceso->total/$count->total)*100;
            $porcentaje_retirar = ($count_retirar->total/$count->total)*100;
        }

       

        return view('estado', compact('t_enviar','t_enviados','t_recibidos','count_proceso','count_retirar','count','porcentaje_proceso','porcentaje_retirar'));
    }



    

    public function solicitud(Request $request)
    {
        $idSolicitud = $request->post('solicitud'); 
        $solicitud = DB::table('solicituds')
                        ->join('detalle_solicituds', 'solicituds.id_solicitud','=', 'detalle_solicituds.id_solicitud')
                        ->select('solicituds.*', 'detalle_solicituds.cantidad')
                        ->where('solicituds.id_solicitud','=',$idSolicitud)
                        ->first();
       if ($solicitud) {
            $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-layer fs-1 text-navy"  ></i>                    
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de la Solicitud</h1>
                            </div>
                    </div>
                    <div class="modal-body" style="font-size:14px;">
                        <div class="row mx-3">
                            <div class="col-sm-6">
                                <span class="fw-bold">Nro. Solicitud: </span>
                                <span class="text-muted">'.$solicitud->id_solicitud.'</span>
                            </div>
                            <div class="col-sm-6 text-end">
                                <span class="fw-bold">Fecha:  </span>
                                <span class="text-muted">'.$solicitud->fecha.'</span>
                            </div>
                        </div>

                        <p class="text-navy text-center mt-2 mb-3 fw-bold">TALONARIO(S)</p>

                        <div class="d-flex justify-content-center">
                            <table class="table w-75 text-center">
                                <tr>
                                    <th>Tipo Talonario</th>
                                    <th>Cant.</th>
                                </tr>
                                <tr class="table-warning">
                                    <td>50 Guías</td>
                                    <td>'.$solicitud->cantidad.'</td>
                                </tr>
                            </table>
                        </div>

                        <div class="text-end fs-6 mx-4 mb-3">
                            <span class="fw-bold">TOTAL UCD </span>
                            <span class="text-muted">'.$solicitud->total_ucd.' UCD</span>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                            <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                        
                    </div>';
            return response($html);
       }
        

        

                
            

        

    }



    public function info_denegada(Request $request){
        $idSolicitud = $request->post('solicitud');
        $query = DB::table('solicituds')->select('observaciones')->where('id_solicitud','=',$idSolicitud)->get();

        if ($query) {
            $html='';
            foreach ($query as $c) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>
                                <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted text-center">OBSERVACIONES DE LA DENEGACIÓN</p>
                            <p class="mx-3 mt-1">'.$c->observaciones.'</p>

                            <div class="mt-3 mb-2">
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span>Las <span class="fw-bold">Observaciones </span>
                                    realizadas cumplen con el objetivo de notificarle
                                    del porque la Cantera no fue verificada. Para que así, pueda rectificar y cumplir con el deber formal.
                                </p>
                            </div>
                        </div>';

            }

            return response($html);
        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function actualizar(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
        ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
        ->where('id_solicitud','=',$idSolicitud)
        ->get();
       
        $tr = '';
        $tr_historial = '';

        $cantera = '';
        $contribuyente = '';
        $select = '';

        if ($solicitudes) {
            foreach ($solicitudes as $solicitud) {
                $cantera = $solicitud->nombre;
                $contribuyente = $solicitud->razon_social;

                switch ($solicitud->estado) {
                    case 'En proceso':
                        $select = ' <option value="En proceso">En proceso</option>
                                    <option value="Retirar">Por Retirar</option>';
                        break;
                    case 'Retirar':
                        $select = ' <option value="Retirar">Por Retirar</option>
                                    <option value="Retirado">Retirado</option>
                                    <option value="En proceso">En proceso</option>';
                        break;
                    case 'Retirado':
                        $select = ' <option value="Retirado">Retirado</option>
                                    <option value="Retirar">Por Retirar</option>';
                        break;

                }

                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
                if($detalles){ 
                    $contador = 0;
                    foreach ($detalles as $i) {
                        $tr .= '<tr>
                                    <td>'.$i->tipo_talonario.' Guías</td>
                                    <td>'.$i->cantidad.' und.</td>
                                </tr>';

                        $contador = $contador + ($i->tipo_talonario * $i->cantidad);

                    }
                }else{
                    return response('ERROR AL ACTUALIZAR ESTADO');
                }
            }

            $talonarios = DB::table('talonarios')->select('fecha_emision','fecha_recibido','fecha_retiro')->where('id_solicitud','=',$idSolicitud)->get(); 
            if ($talonarios) {

                foreach ($talonarios as $talonario) {
                    $fecha_recibido = '';
                    if ($talonario->fecha_recibido != '') {
                        $fecha_recibido = $talonario->fecha_recibido;
                    }else{
                        $fecha_recibido = '----------';
                    }

                    $fecha_retiro = '';
                    if ($talonario->fecha_retiro != '') {
                        $fecha_retiro = $talonario->fecha_retiro;
                    }else{
                        $fecha_retiro = '----------';
                    }

                    $tr_historial = '<tr>
                                        <th>Emisión</th>
                                        <td class="text-success fw-bold">'.$talonario->fecha_emision.'</td>
                                    </tr>
                                    <tr>
                                        <th>Recepción</th>
                                        <td class="text-success fw-bold">'.$fecha_recibido.'</td>
                                    </tr>
                                    <tr>
                                        <th>Entrega</th>
                                        <td class="text-success fw-bold">'.$fecha_retiro.'</td>
                                    </tr>';
                }
            }else{
                return response('ERROR AL ACTUALIZAR ESTADO');
            }
            // return response($select);
            $html = '<div class="d-flex justify-content-end">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th>Cantera:</th>
                                <td class="text-navy fw-bold fs-6">'.$cantera.'</td>
                            </tr>
                            <tr>
                                <th>Contribuyente:</th>
                                <td>'.$contribuyente.'</td>
                            </tr>
                        </table>  
                    </div>

                    <h6 class="text-center mb-3 text-navy fw-bold">Datos de la Solicitud</h6>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Contenido del Talonario</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tr.'
                        </tbody>
                    </table>
                    <h6 class="text-center mb-3  text-navy fw-bold">Historial de Estados</h6>
                    <div class="d-flex justify-content-end">
                        <table class="table text-center mx-5 px-5">
                            '.$tr_historial.'
                        </table>
                    </div>
                    <form id="form_actualizar_estado" method="post" onsubmit="event.preventDefault(); actualizarEstado()">
                        <div class="row px-5 my-3">
                            <div class="col-sm-4">
                                <label for="estado" class="fw-bold fs-6">Estado Actual</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="estado" aria-label="Small select" name="estado_actual" required >
                                    '.$select.'
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id_solicitud" value="'.$idSolicitud.'">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-sm" data-bs-dismiss="modal">Actualizar</button>
                        </div>
                    </form>';
            return response($html);

        }else{
            return response('ERROR AL ACTUALIZAR ESTADO');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request)
    {
        $idSolicitud = $request->post('id_solicitud');
        $estado = $request->post('estado_actual');
        $update_solicitud = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => $estado]);
        $fecha = date('Y-m-d');

        if ($update_solicitud) {
            switch ($estado) {
                case 'En proceso':
                    $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_recibido' => NULL, 'fecha_retiro' => NULL]);
                    break;
                case 'Retirar':
                    $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_recibido' => $fecha]);
                    break;
                case 'Retirado':
                    $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_retiro' => $fecha]);
                    break;
                
                default:
                    # code...
                    break;
            }
            if ($update_talonario) {
                $user = auth()->id();
                $accion = 'ESTADO DE LA SOLICITUD NRO.'.$idSolicitud.' ACTUALIZADO A: '.$estado;
                $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 8, 'accion'=> $accion]);

                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
           
        }else{
            return response()->json(['success' => false]);
        }
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
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
