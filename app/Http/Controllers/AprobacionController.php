<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
            ->join('clasificacions', 'solicituds.estado', '=', 'clasificacions.id_clasificacion')
            ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro','canteras.nombre','clasificacions.nombre_clf')
            ->where('solicituds.estado','=',4)
            ->get();

        $count_aprobar = DB::table('solicituds')->selectRaw("count(*) as total")->where('estado','=',4)->first();

        return view('aprobacion_solicitud', compact('solicitudes','count_aprobar'));
    }

    public function sujeto(Request $request)
    {   
        $idSujeto = $request->post('sujeto');
        $query = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->get();
        if ($query) {
            foreach ($query as $sujeto) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-user-circle fs-1 text-navy" ></i>
                                <h1 class="modal-title fs-5 text-navy" id="" >'.$sujeto->razon_social.'</h1>
                                <h5 class="modal-title" id="" style="font-size:14px">Contribuyente</h5>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:15px;">
                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                            <table class="table" style="font-size:14px">
                                <tr>
                                    <th>R.I.F.</th>
                                    <td>'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</td>
                                </tr>
                                <tr>
                                    <th>Razon Social</th>
                                    <td>'.$sujeto->razon_social.'</td>
                                </tr>
                                <tr>
                                    <th>¿Empresa Artesanal?</th>
                                    <td>'.$sujeto->artesanal.'</td>
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
                                    <td>'.$sujeto->ci_condicion_repr.'-'.$sujeto->ci_nro_repr.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F. del representante</th>
                                    <td>'.$sujeto->rif_condicion_repr.'-'.$sujeto->rif_nro_repr.'</td>
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
        $idCantera = $request->post('cantera');
       
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro')
        ->where('solicituds.id_solicitud','=',$idSolicitud)
        ->get();
       
        $tr = '';

        if ($solicitudes) {
            foreach ($solicitudes as $solicitud) {
                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->first();
                if($detalles){ 
                    $reserva = DB::table('detalle_talonarios')->selectRaw("count(*) as total")
                                                ->where('id_sujeto','=',$solicitud->id_sujeto)
                                                ->where('id_cantera','=',$solicitud->id_cantera)
                                                ->where('asignacion_talonario','=',25)
                                                ->first();
                                                
                    // $contador = 0;
                    $tr_emitir = '';
                    $disabled = '';
                    if ($detalles->cantidad <= $reserva->total) {
                        ///////SI hay suficiente guías en reserva de esta cantera para cubrir la solicitud 
                        $tr_emitir = '<input class="" type="hidden" value="0" id="emitir_talonarios" name="emitir_talonarios">';
                    }else{
                        ///////NO hay suficiente guías en reserva de esta cantera para cubrir la solicitud 
                        $tr_emitir = '<tr>
                                        <th>Emitir</th>
                                        <td>
                                            <div class="row d-flex align-items-center">
                                                <div class="col-sm-6">
                                                    <input class="form-control form-control-sm" type="number" min="10" id="emitir_talonarios" name="emitir_talonarios">
                                                </div>
                                                <div class="col-sm-6 text-start">
                                                    Talonarios
                                                </div>
                                            </div>
                                        </td>
                                    </tr>';
                        $disabled = 'disabled';
                    }
                    
                    $tr_asignacion =   '<tr class="table-warning">
                                            <th>Solicitados</th>
                                            <td>'.$detalles->cantidad.'</td>
                                        </tr>
                                        <tr>
                                            <th>Reserva</th>
                                            <td>'.$reserva->total.'</td>
                                        </tr>
                                        '.$tr_emitir.'';

                    $contador = $detalles->tipo_talonario * $detalles->cantidad;                    
                }

                $total_guias = $contador;
                // return response($total_guias);

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar la siguiente solicitud?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$solicitud->razon_social.'</h1>
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$solicitud->rif_condicion.'-'.$solicitud->rif_nro.'</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <h6 class="text-center mb-3">Solicitud de Talonario(s) Realizada</h6>
                            <div class="d-flex justify-content-center  mb-4">
                                <table class="table w-75 text-center">
                                    <thead>
                                        <tr>
                                            <th>Talonarios</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$tr_asignacion.'
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="text-center mb-3 text-secondary">Detalle de la Solicitud a Aprobar</h6>
                            <div class="d-flex justify-content-center mt-3">
                                <table class="table table-sm w-75">
                                    <tbody><tr>
                                        <th>Total de Guías a Asignar</th>
                                        <td class="text-secondary">'.$total_guias.' Guías</td>
                                    </tr>
                                    <tr>
                                        <th>Total UCD</th>
                                        <td class="text-secondary">'.$solicitud->total_ucd.' UCD</td>
                                    </tr>
                                </tbody></table>
                            </div>

                            <p class="text-muted mb-3  mt-2 mx-3"><span class="text-danger">*</span> Cada Talonario tiene un contenido de 50 Guías de Circulación en total.</p>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm me-4 aprobar_correlativo" '.$disabled.' id_cantera="'.$idCantera.'" id_solicitud="'.$idSolicitud.'" id_sujeto="'.$solicitud->id_sujeto.'">Aprobar</button>
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </div>';

                        return response($html);
            }

        }

    }

    // private function generarToken($longitud = 10)
    // {
    //     $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    //     $token = '';
    //     for ($i = 0; $i < $longitud; $i++) {
    //         $token .= $caracteres[mt_rand(0, strlen($caracteres) - 1)];
    //     }
    //     return $token;
    // }

    // // Función para verificar si un token ya existe en la base de datos
    // private function tokenExiste($token)
    // {
    //     return DB::table('nro_controls')->where('nro_control', $token)->exists();
    // }

    ////////////////INSERTAR CORRELATIVO DE LOS NUMEROS DE CONTROL
    // for ($t=0; $t < $tipo; $t++) {
    //     do {
    //         $nuevoToken = $this->generarToken();
    //     } while ($this->tokenExiste($nuevoToken));
        
    //     // Guarda el nuevo token en la base de datos
    //     $insert_control = DB::table('nro_controls')->insert(['id_solicitud' =>$idSolicitud,'nro_guia' =>$contador_guia, 'nro_control' => $nuevoToken]);
        
    //     if ($insert_control) {
    //         $contador_guia = $contador_guia + 1;
    //     }
    // }
    ////////////////////////////////////////

    public function correlativo(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $idCantera = $request->post('cantera');
        $idSujeto = $request->post('sujeto');
        $talonarios_emitir = $request->post('emitir');

        $user = auth()->id();
        $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$idSujeto)->first(); 

        $nro_talonarios = 0;

        $consulta_cantidad = DB::table('detalle_solicituds')->select('cantidad')->where('id_solicitud','=',$idSolicitud)->first(); 
        $consulta_reserva = DB::table('detalle_talonarios')->selectRaw("count(*) as total")
                                                            ->where('id_sujeto','=',$idSujeto)
                                                            ->where('id_cantera','=',$idCantera)
                                                            ->where('asignacion_talonario','=',25)->first();
        
        if ($consulta_cantidad && $consulta_reserva) {
            if ($consulta_reserva->total == 0) {
                ////no hay talonarios de reserva para esta cantera
                if ($talonarios_emitir != 0) {
                    $insert_emision_talonarios = DB::table('emision_talonarios')->insert(['id_solicitud' => $idSolicitud,
                                                                                    'tipo_talonario' => '50', 
                                                                                    'cantidad' => $talonarios_emitir, 
                                                                                    'id_user' => $user]);

                    /////////////////////////////////////////////////////////////////////////////////////////////
                    $count_ciclo = 0; ////////contador para los ciclos de asignación de los talonarios

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
                                $cant_solicitada = $detalle->cantidad;
                                $nro_talonarios = $nro_talonarios + $cant_solicitada;
                                // return response($cant); 
                                for ($i=0; $i < $talonarios_emitir; $i++) { 
                                    //////////////////////////////////////////////////////////////////////////////////////         
                                    $count_ciclo = $count_ciclo + 1; 
                                    $asignacion_talonario = '';
                                    if ($count_ciclo <= $cant_solicitada) {
                                        ///////no se han completado los ciclos correspondientes a los talonarios solicitados
                                        $asignacion_talonario = 26;  /////Asignado
                                    }else{
                                        //////ya se completaron los ciclos correspondientes a los talonarios solicitados, por lo tanto los demás son de reserva para la proxima solicitud
                                        $asignacion_talonario = 25;  /////En reserva
                                    }     
                                    ///////////////////////////////////////////////////////////////////////////////////////
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
                                
                                    $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud,
                                                                                'id_reserva' => NULL, 
                                                                                'tipo_talonario' => $tipo, 
                                                                                'desde' => $desde, 
                                                                                'hasta' => $hasta,
                                                                                'clase' => 5,
                                                                                'asignado' => $tipo,
                                                                                'estado' => 20]);
                                    if ($insert) {
                                        $id_talonario= DB::table('talonarios')->max('id_talonario');
                                        $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                'id_talonario' => $id_talonario,
                                                                                'id_cantera'=>$idCantera, 
                                                                                'id_sujeto'=>$idSujeto, 
                                                                                'desde' => $desde, 
                                                                                'hasta' => $hasta,
                                                                                'clase' => 5,
                                                                                'asignacion_talonario' => $asignacion_talonario,
                                                                                'id_solicitud_reserva' => null]);

                                        $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qr/?id='.$id_talonario;
                                        QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_T'.$id_talonario.'.svg'));
                                        $update_qr = DB::table('detalle_talonarios')->where('id_talonario', '=', $id_talonario)->update(['qr' => 'assets/qr/qrcode_T'.$id_talonario.'.svg']);
                
                                    }else{
                                        return response('Error al generar el QR');
                                    }
                                    
                                } ////cierra for    
                            
                            }/////cierra foreach


                            $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 17]);

                            $accion = 'SOLICITUD NRO.'.$idSolicitud.' APROBADA, Talonarios: '.$nro_talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 7, 'accion'=> $accion]);
                        
                            return response()->json(['success' => true]);
                            
                        }else{   //////////Hay registros en la tabla Talonarios
                            $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
                            foreach ($detalles as $detalle){
                                $tipo = $detalle->tipo_talonario;
                                $cant_solicitada = $detalle->cantidad;
                                $nro_talonarios = $nro_talonarios + $cant_solicitada;

                                for ($i=1; $i <= $talonarios_emitir; $i++) {  
                                    //////////////////////////////////////////////////////////////////////////////////////         
                                    $count_ciclo = $count_ciclo + 1; 
                                    $asignacion_talonario = '';
                                    if ($count_ciclo <= $cant_solicitada) {
                                        ///////no se han completado los ciclos correspondientes a los talonarios solicitados
                                        $asignacion_talonario = 26;  /////Asignado
                                    }else{
                                        //////ya se completaron los ciclos correspondientes a los talonarios solicitados, por lo tanto los demás son de reserva para la proxima solicitud
                                        $asignacion_talonario = 25;  /////En reserva
                                    }     
                                    ///////////////////////////////////////////////////////////////////////////////////////

                                    $id_max= DB::table('talonarios')->max('id_talonario');
                                    $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                                    foreach ($query_hasta as $hasta) {
                                        $prev_hasta = $hasta->hasta;
                                    }
                                    $desde = $prev_hasta +1;
                                    $hasta = ($desde + $tipo)-1;

                                    $contador_guia = $desde;
                
                                    $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud,
                                                                                'id_reserva' => NULL, 
                                                                                'tipo_talonario' => $tipo, 
                                                                                'desde' => $desde, 
                                                                                'hasta' => $hasta,
                                                                                'clase' => 5,
                                                                                'asignado' => $tipo,
                                                                                'estado' => 20]);
                                    if ($insert) {
                                        $id_talonario= DB::table('talonarios')->max('id_talonario');
                                        $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                'id_talonario' => $id_talonario,
                                                                                'id_cantera'=>$idCantera, 
                                                                                'id_sujeto'=>$idSujeto, 
                                                                                'desde' => $desde, 
                                                                                'hasta' => $hasta,
                                                                                'clase' => 5,
                                                                                'asignacion_talonario' => $asignacion_talonario,
                                                                                'id_solicitud_reserva' => null]);
                                                                                
                                        // $url = route('qr.qr', ['id' => $id_talonario]);
                                        $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qr/?id='.$id_talonario;
                                        QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_T'.$id_talonario.'.svg'));
                                        $update_qr = DB::table('detalle_talonarios')->where('id_talonario', '=', $id_talonario)->update(['qr' => 'assets/qr/qrcode_T'.$id_talonario.'.svg']);
                        
                                    }else{
                                        return response('Error al generar el QR');
                                    }
                                } ////cierra for                
                            } ////cierra foreach

                            $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 17]);

                            $accion = 'SOLICITUD NRO.'.$idSolicitud.' APROBADA, Talonarios: '.$nro_talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 7, 'accion'=> $accion]);

                            return response()->json(['success' => true]);
                        }
                    
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    return response()->json(['success' => false, 'nota' => 'Por favor, ingrese el número de talonarios a emitir para poder procesar la Solicitud.']);
                }
            }else{
                ////si hay talonarios de reserva para esta cantera
                if ($consulta_cantidad->cantidad <= $consulta_reserva->total) {
                    ////////////hay suficientes talonarios de reserva para atender la solicitud
                    $consulta_tln_reserva = DB::table('detalle_talonarios')->select('id_talonario')
                                            ->where('id_sujeto','=',$idSujeto)
                                            ->where('id_cantera','=',$idCantera)
                                            ->where('asignacion_talonario','=',25)->get();
                    foreach ($consulta_tln_reserva as $c3) {
                        for ($i=0; $i < $consulta_cantidad->cantidad; $i++) { 
                            $update_asignacion = DB::table('talonarios')
                                                ->where('id_talonario', '=', $c3->id_talonario)
                                                ->update(['id_solicitud' => $idSolicitud]);
                            if ($update_asignacion) {
                                return response()->json(['success' => true]);
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }
                    }

                }else{
                    ////////////no hay suficientes talonarios de reserva para atender la solicitud
                }
















            }
        }else{
            return response()->json(['success' => false]);
        }

       
    }

    public function info(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        // $consulta = DB::table('talonarios')->select('id_talonario')->where('id_solicitud', '=', $idSolicitud)->first();

        $tables = '';
        $talonarios = DB::table('talonarios')->select('id_talonario','tipo_talonario','desde','hasta')->where('id_solicitud','=',$idSolicitud)->get();

        $razon_social = '';
        $rif = '';
        $cantera = '';

        if ($talonarios) {
            $i=0;
            foreach ($talonarios as $talonario) {
                $i = $i + 1;
                $desde = $talonario->desde;
                $hasta = $talonario->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);


                $detalle = DB::table('detalle_talonarios')
                    ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
                    ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->select('detalle_talonarios.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro','canteras.nombre')
                    ->where('id_talonario','=', $talonario->id_talonario)
                    ->first();

                if ($detalle) {
                    $qr = $detalle->qr;
                    $razon_social = $detalle->razon_social;
                    $rif = $detalle->rif_condicion.'-'.$detalle->rif_nro;
                    $cantera = $detalle->nombre;

                    $tables .= ' <span class="ms-3">Talonario Nro. '.$i.'</span>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-7">
                                    <table class="table mt-2 mb-3">
                                        <tr>
                                            <th>Contenido:</th>
                                            <td>'.$talonario->tipo_talonario.' Guías</td>
                                        </tr>
                                        <tr>
                                            <th>Desde:</th>
                                            <td>'.$formato_desde.'</td>
                                        </tr>
                                        <tr>
                                            <th>Hasta:</th>
                                            <td>'.$formato_hasta.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-5">
                                    <div class="title text-center">
                                        <img width="140px" src="'.asset($qr).'" alt="">
                                    </div>
                                </div>
                            </div>';
                }

                    
            }

            $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¡La solicitud a sido Aprobada!</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5 text-navy" id="">'.$cantera.'</h1>
                                    <h5 class="modal-title text-muted" id="" style="font-size:14px">'.$razon_social.'</h5>
                                    <h5 class="modal-title text-muted" id="" style="font-size:14px">'.$rif.'</h5>
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
        $solicitudes = DB::table('solicituds')->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
        ->where('solicituds.id_solicitud','=',$idSolicitud)
        ->get();
        foreach ($solicitudes as $s) {
            $razon = $s->razon_social;
            $rif = $s->rif_condicion.'-'.$s->rif_nro;
            $fecha = $s->fecha;
            $cantera = $s->nombre;
            $id_cantera = $s->id_cantera;
            $sujeto = $s->id_sujeto;
            $total_ucd = $s->total_ucd;
            $total_ucd = $s->total_ucd;

            $ucd = DB::table('ucds')->select('valor')->where('id','=',$s->id_ucd)->first();
            $valor_ucd = $ucd->valor;
            $formato_monto_total = number_format($s->monto_total, 2, ',', '.');

        }

        $tr = '';
        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
        if($detalles){
            foreach ($detalles as $solicitud) {
                $tr .= '<tr>
                            <td colspan="2">'.$solicitud->tipo_talonario.' Guías</td>
                            <td >'.$solicitud->cantidad.'</td>
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

                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Cantera:</th>
                            <td class="text-navy fw-bold">'.$cantera.'</td>
                        </tr>
                        <tr>
                            <th>Razon social:</th>
                            <td>'.$razon.'</td>
                        </tr>
                        <tr>
                            <th>R.I.F.:</th>
                            <td>'.$rif.'</td>
                        </tr>
                    </table>

                    <table class="table table-borderless">
                        <tr>
                            <th>Cod. Solicitud:</th>
                            <td class="text-muted">'.$idSolicitud.'</td>
                            <th>Fecha de emisión:</th>
                            <td class="text-muted">'.$fecha.'</td>
                        </tr>
                    </table>
                    
                    <table class="table text-center">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col" colspan="2">Contenido del talonario</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tr.'
                            <tr class="table-primary">
                                <th>Total UCD</th>
                                <th>UCD del día</th>
                                <th>Monto a Pagar</th>
                            </tr>
                            <tr>
                                <td>'.$total_ucd.' UCD</td>
                                <td>'.$valor_ucd.' Bs.</td>
                                <td>'.$formato_monto_total.' Bs.</td>
                            </tr>
                        </tbody>
                    </table>

                    
                    <form id="form_denegar_solicitud" method="post" onsubmit="event.preventDefault(); denegarSolicitud()">
                        
                        <div class="ms-2 me-2">
                            <label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span>
                            <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                            <input type="hidden" name="id_solicitud" value="'.$idSolicitud.'">
                            <input type="hidden" name="id_cantera" value="'.$id_cantera.'">
                            <input type="hidden" name="id_sujeto" value="'.$sujeto.'">
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
        $idCantera = $request->post('id_cantera'); 
        $idSujeto = $request->post('id_sujeto'); 
        $observacion = $request->post('observacion');

        ////////////ELIMINAR NUMERO DE GUIAS, EN GUIAS SOLICITADAS (LIMTE_GUIAS)/////
        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get(); 
        $guias = 0;
        
        if($detalles){
            foreach ($detalles as $solicitud) {
            $guias = $guias + ($solicitud->tipo_talonario * $solicitud->cantidad);
            }
        }
        $limites = DB::table('limite_guias')->select('total_guias_solicitadas_periodo')->where('id_cantera','=',$idCantera)->get();
        foreach ($limites as $limite) {
            $new_total_guias = $limite->total_guias_solicitadas_periodo - $guias;
        }
        $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => $new_total_guias]);
        
        ////////////////CAMBIAR ESTADO DE SOLICITUD A DENEGADA
        $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 6, 'observaciones' => $observacion]);
        
        if ($updates && $update_limite) {
            $user = auth()->id();
            $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$idSujeto)->first(); 
            $accion = 'SOLICITUD NRO. '.$idSolicitud.' RECHAZADA, Contribuyente: '.$sp->razon_social;
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 7, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function qr(Request $request)
    // {
    //     $idTalonario = $request->get('id');
    //     $talonario = DB::table('detalle_talonarios')
    //                     ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
    //                     ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
    //                     ->join('talonarios', 'detalle_talonarios.id_talonario', '=', 'talonarios.id_talonario')
    //                     ->select('detalle_talonarios.*','talonarios.id_solicitud', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre', 'canteras.municipio_cantera', 'canteras.parroquia_cantera', 'canteras.lugar_aprovechamiento')
    //                     ->where('detalle_talonarios.id_talonario','=', $idTalonario)
    //                     ->first();

    //    return view('qr', compact('talonario'));
    // }

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
