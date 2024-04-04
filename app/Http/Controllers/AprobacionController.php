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
            ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
            ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro','canteras.nombre')
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
        $idCantera = $request->post('cantera');
       
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro')
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
                // $ucds = $total_guias * 5;

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
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$solicitud->rif_condicion.'-'.$solicitud->rif_nro.'</h5>
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
                                        <th>Total UCD</th>
                                        <td>'.$solicitud->ucd_pagar.'</td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm me-4 aprobar_correlativo" id_cantera="'.$idCantera.'" id_solicitud="'.$idSolicitud.'" id_sujeto="'.$solicitud->id_sujeto.'" fecha="'.$date_sol.'" >Aprobar</button>
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </div>';

                        return response($html);
            }

        }

    }

    private function generarToken($longitud = 10)
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $token = '';
        for ($i = 0; $i < $longitud; $i++) {
            $token .= $caracteres[mt_rand(0, strlen($caracteres) - 1)];
        }
        return $token;
    }

    // Función para verificar si un token ya existe en la base de datos
    private function tokenExiste($token)
    {
        return DB::table('nro_controls')->where('nro_control', $token)->exists();
    }

    public function correlativo(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $idCantera = $request->post('cantera');
        $idSujeto = $request->post('sujeto');
        $fecha = $request->post('fecha');
      

        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->get();   
        if ($query_count) {
            foreach ($query_count as $c) {
                $count = $c->total;
            }
            if($count == 0){ //////////No hay ningun registro en la tabla Talonarios
                $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get(); 
                $c = 0; return response($detalles);
                foreach ($detalles as $detalle) { ////////talonarios que el contribuyente solicito
                    $tipo = $detalle->tipo_talonario;
                    $cant = $detalle->cantidad;
                    // return response($cant); 
                    for ($i=0; $i < $cant; $i++) {                        
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
                        ////////////////INSERTAR CORRELATIVO DE LOS NUMEROS DE CONTROL
                        // $nuevoToken = '';
                        for ($t=0; $t < $tipo; $t++) {
                            do {
                                $nuevoToken = $this->generarToken();
                            } while ($this->tokenExiste($nuevoToken));

                            // Guarda el nuevo token en la base de datos
                            $insert_control = DB::table('nro_controls')->insert(['id_solicitud' =>$idSolicitud,'nro_guia' =>$contador_guia, 'nro_control' => $nuevoToken]);
                            
                            if ($insert_control) {
                                $contador_guia = $contador_guia + 1;
                            }
                        }
                        ////////////////////////////////////////

                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_cantera'=>$idCantera, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'fecha_emision' => $fecha]);
                        
                    } ////cierra for    
                 
                }/////cierra foreach

                $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 'En proceso']);
                return response()->json(['success' => true]);
                
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

                        $contador_guia = $desde;
                        ////////////////INSERTAR CORRELATIVO DE LOS NUMEROS DE CONTROL
                        for ($t=0; $t < $tipo; $t++) {
                            do {
                                $nuevoToken = $this->generarToken();
                            } while ($this->tokenExiste($nuevoToken));
                            
                            // Guarda el nuevo token en la base de datos
                            $insert_control = DB::table('nro_controls')->insert(['id_solicitud' =>$idSolicitud,'nro_guia' =>$contador_guia, 'nro_control' => $nuevoToken]);
                            
                            if ($insert_control) {
                                $contador_guia = $contador_guia + 1;
                            }
                        }
                        ////////////////////////////////////////
    
                        $insert = DB::table('talonarios')->insert(['id_solicitud' => $idSolicitud, 'id_cantera'=>$idCantera, 'id_sujeto'=>$idSujeto, 'tipo_talonario' => $tipo, 
                                            'desde' => $desde, 'hasta' => $hasta, 'fecha_emision' => $fecha]);
                    } ////cierra for                
                } ////cierra foreach

                $updates = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 'En proceso']);
                return response()->json(['success' => true]);
            }
           
        }else{
            return response()->json(['success' => false]);
        }
    }

    public function info(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $tables = '';
        $talonarios = DB::table('talonarios')
        ->join('sujeto_pasivos', 'talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('talonarios.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro')
        ->where('id_solicitud','=',$idSolicitud)
        ->get();

        if ($talonarios) {
            $i=0;
            foreach ($talonarios as $talonario) {
                $i = $i + 1;
                $desde = $talonario->desde;
                $hasta = $talonario->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                $tables .= ' <span class="ms-3">Talonario Nro. '.$i.'</span>
                                <table class="table mt-2 mb-3">
                                    <tr>
                                        <th>Tipo:</th>
                                        <td>'.$talonario->tipo_talonario.'</td>
                                        <th>Desde:</th>
                                        <td>'.$formato_desde.'</td>
                                        <th>Hasta:</th>
                                        <td>'.$formato_hasta.'</td>
                                    </tr>
                                </table>';
            }

            $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¡La solicitud a sido Aprobada!</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$talonario->razon_social.'</h1>
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$talonario->rif_condicion.'-'.$talonario->rif_nro.'</h5>
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
        ->select('solicituds.fecha','solicituds.id_sujeto','solicituds.id_cantera', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
        ->where('solicituds.id_solicitud','=',$idSolicitud)
        ->get();
        foreach ($solicitudes as $s) {
            $razon = $s->razon_social;
            $rif = $s->rif_condicion.'-'.$s->rif_nro;
            $fecha = $s->fecha;
            $cantera = $s->nombre;
            $id_cantera = $s->id_cantera;
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
                                <th>Cantera:</th>
                                <td class="text-primary fw-bold">'.$cantera.'</td>
                            </tr>
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
                            <input type="hidden" name="id_cantera" value="'.$id_cantera.'">
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
        $observacion = $request->post('observacion');

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

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
