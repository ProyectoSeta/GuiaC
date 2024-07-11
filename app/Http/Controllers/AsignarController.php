<?php

namespace App\Http\Controllers;
use App\Models\SujetoPasivo;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('asignar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $rif_nro = $request->post('rif_nro'); 
        $rif_condicion = $request->post('rif_condicion');
        $html = '';

        $query =  DB::table('sujeto_pasivos')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
        if ($query->total == 0) {
            $query2 =  DB::table('sujeto_notusers')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            if ($query2->total == 0) {
                $html = '<div class="text-center">
                            <p class="fw-bold text-muted mb-2">Contribuyente No Registrado</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_no_registrado">Registrar</a>
                        </div>';
            }else{
                $consulta =  DB::table('sujeto_notusers')->select('id_sujeto_notuser','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
                $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado</p>
                            <a href="#" class="asignar" tipo="notuser" id_sujeto="'.$consulta->id_sujeto_notuser.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
            }
        }else{
            $consulta =  DB::table('sujeto_pasivos')->select('id_sujeto','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado</p>
                            <a href="#" class="asignar" tipo="user" id_sujeto="'.$consulta->id_sujeto.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
        }

        return response($html);
    }


    public function modal(Request $request)   ////MODAL ASIGNACIÓN DE GUIAS - CONTRIBUYENTE RESGISTRADO
    {
        $tipo = $request->post('tipo'); 
        $sujeto = $request->post('sujeto');

        if ($tipo == 'user') {
            $sp = DB::table('sujeto_pasivos')->where('id_sujeto','=',$sujeto)->first();
            if ($sp) {
                $opction_canteras = '';
                $canteras = DB::table('canteras')->select('id_cantera','nombre')->where('id_sujeto','=',$sujeto)->where('status','=','Verificada')->get();

                if ($canteras) {
                    foreach ($canteras as $c) {
                        $opction_canteras .= '<option value="'.$c->id_cantera.'">'.$c->nombre.'</option>';
                    }
                    
                    $html = '<div class="modal-header">
                                <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel" >Asignación de Guías</h1>
                            </div>
                            <div class="modal-body " style="font-size:13px">
                                <form id="form_asignar_guias" method="post" onsubmit="event.preventDefault(); asignarGuias();">
                                    <div class="row px-4">
                                        <div class="col-sm-6">
                                            <div class="text-center text-navy fw-bold mb-3">
                                                <span class="">Datos del Contribuyente</span>
                                            </div>

                                            <div class="mb-0">
                                                <span class="fw-bold">R.I.F.</span>
                                                <p class="text-navy fw-bold mb-2">'.$sp->rif_condicion.'-'.$sp->rif_nro.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Razon Social</span>
                                                <p class="text-navy fw-bold mb-2">'.$sp->razon_social.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Dirección</span>
                                                <p class="text-muted mb-2">'.$sp->direccion.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono Móvil</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_movil.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono Fijo</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_fijo.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Representante legal</span>
                                                <p class="text-muted mb-2">'.$sp->name_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">C.I. del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->ci_condicion_repr.'-'.$sp->ci_nro_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">R.I.F. del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->rif_condicion_repr.'-'.$sp->rif_nro_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_repr.'</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-center text-navy fw-bold mb-3">
                                                <span class="">Correspondiente a la Asignación</span>
                                            </div>

                                            <div class="mb-2" id="select_cantera_asignacion">
                                                <label class="form-label" for="cantera">Cantera y/o Desazolve</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                                    '.$opction_canteras.'
                                                </select>
                                            </div>

                                            <div class=" mb-2">
                                                <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                                <input class="form-control form-control-sm" type="number" id="cantidad" name="cantidad" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                                <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                                <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                            </div>
                                            <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                                            <div class="d-flex justify-content-end align-items-center me-2 fs-6 mb-2 mt-4">
                                                <span class="fw-bold me-4">Total: </span>
                                                <span id="total_ucd" class="fs-5">0 UCD</span>
                                            </div>

                                            <input type="hidden" name="id_sujeto" value="'.$sp->id_sujeto.'" required>
                                            <input type="hidden" name="tipo_sujeto" value="'.$tipo.'" required>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar">Cancelar</button>
                                        <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion">Asignar</button>
                                    </div>
                                </form>
                            </div>';

                    return response($html);
                    
                }
            }else{
                return response()->json(['success' => false]);
            }

        }else{
            $sp = DB::table('sujeto_notusers')->where('id_sujeto_notuser','=',$sujeto)->first();
            if ($sp) {
                $opction_canteras = '';
                $canteras = DB::table('canteras_notusers')->select('id_cantera_notuser','nombre')->where('id_sujeto_notuser','=',$sujeto)->where('status','=','Verificada')->get();

                if ($canteras) {
                    foreach ($canteras as $c) {
                        $opction_canteras .= '<option value="'.$c->id_cantera_notuser.'">'.$c->nombre.'</option>';
                    }
                    
                    $html = '<div class="modal-header">
                                <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel" >Asignación de Guías</h1>
                            </div>
                            <div class="modal-body " style="font-size:13px">
                                <form id="form_asignar_guias" method="post" onsubmit="event.preventDefault(); asignarGuias();">
                                    <div class="row px-4">
                                        <div class="col-sm-6">
                                            <div class="text-center text-navy fw-bold mb-3">
                                                <span class="">Datos del Contribuyente</span>
                                            </div>

                                            <div class="mb-0">
                                                <span class="fw-bold">R.I.F.</span>
                                                <p class="text-navy fw-bold mb-2">'.$sp->rif_condicion.'-'.$sp->rif_nro.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Razon Social</span>
                                                <p class="text-navy fw-bold mb-2">'.$sp->razon_social.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Dirección</span>
                                                <p class="text-muted mb-2">'.$sp->direccion.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono Móvil</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_movil.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono Fijo</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_fijo.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Representante legal</span>
                                                <p class="text-muted mb-2">'.$sp->name_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">C.I. del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->ci_condicion_repr.'-'.$sp->ci_nro_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">R.I.F. del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->rif_condicion_repr.'-'.$sp->rif_nro_repr.'</p>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-bold">Teléfono del Representante</span>
                                                <p class="text-muted mb-2">'.$sp->tlf_repr.'</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-center text-navy fw-bold mb-3">
                                                <span class="">Correspondiente a la Asignación</span>
                                            </div>

                                            <div class="mb-2" id="select_cantera_asignacion">
                                                <label class="form-label" for="cantera">Cantera y/o Desazolve</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                                    '.$opction_canteras.'
                                                </select>
                                            </div>

                                            <div class="text-center" id="content_btn_add">
                                                <a href="#" id="add_cantera_notuser" id_sujeto="'.$sujeto.'">Agregar Cantera o Desazolve</a>
                                            </div>

                                            <div class=" mb-2">
                                                <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                                <input class="form-control form-control-sm" type="number" name="cantidad" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                                <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                                <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                            </div>
                                            <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                                            <div class="d-flex justify-content-end align-items-center me-2 fs-6 mb-2 mt-4">
                                                <span class="fw-bold me-4">Total: </span>
                                                <span id="total_ucd" class="fs-5">0 UCD</span>
                                            </div>

                                            <input type="hidden" name="id_sujeto" value="'.$sp->id_sujeto_notuser.'" required>
                                            <input type="hidden" name="tipo_sujeto" value="'.$tipo.'" required>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar" disabled="">Cancelar</button>
                                        <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion" disabled="">Asignar</button>
                                    </div>
                                </form>
                            </div>';

                    return response($html);
                    
                }
            }else{
                return response()->json(['success' => false]);
            }
        }


    }


    public function canteras(Request $request)  
    {
        $sujeto = $request->post('sujeto');

        $opction_canteras = '';
        $canteras = DB::table('canteras_notusers')->select('id_cantera_notuser','nombre')->where('id_sujeto_notuser','=',$sujeto)->get();

        if ($canteras) {
            foreach ($canteras as $cantera) {
                $opction_canteras .= '<option  value="'.$cantera->id_cantera_notuser.'">'.$cantera->nombre.'</option>';
            }
            $select = '<label class="form-label" for="cantera">Cantera y/o Desazolve</label><span class="text-danger">*</span>
                        <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                            '.$opction_canteras.'
                        </select>';
            return response($select);
        }

    }


    public function calcular(Request $request)
    {
        $cantidad = $request->post('cant');
        $ucd = $cantidad * 5;
        
        return response()->json(['ucd' => $ucd]);
    }


    public function asignar(Request $request)
    {   
        $user = auth()->id();
        $id_sujeto = $request->post('id_sujeto');
        $tipo = $request->post('tipo_sujeto');

        $id_cantera = $request->post('cantera');
        $cant = $request->post('cantidad');
        $oficio = $request->file('oficio');
        $total_ucd = $cant * 5;
        $year = date("Y");

        $campo_cantera = ""; 
        $campo_sujeto = ""; 

        ///////////CREAR CARPETA PARA LOS OFICIOS SI NO EXISTE
        if (!is_dir('../public/assets/oficiosReservas/'.$year)){   ////no existe la carpeta del año
            mkdir('../public/assets/oficiosReservas/'.$year, 0777);
        }
        
        /////////////REGISTRO DE LA ASIGNACIÓN DE RESERVAS
        if ($tipo == 'notuser') {
            $campo_cantera = "'id_cantera_notuser'"; 
            $campo_sujeto = "'id_sujeto_notuser'";

            $insert = DB::table('asignacion_reservas')->insert(['contribuyente' => 28,
                                                        'id_sujeto_not_user' => $id_sujeto, 
                                                        'id_cantera_notuser'=>$id_cantera,
                                                        'cantidad_guias'=>$cant,
                                                        'total_ucd'=>$total_ucd, 
                                                        'estado' => 17,
                                                        'id_user' => $user]);
            if ($insert) {
                $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
                $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
                $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
                $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

                if(copy($oficio->getRealPath(),$ruta)){
                    $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                }else{
                    return response()->json(['success' => false, 'nota' => 'ERROR AL GENERAR LA ASIGNACIÓN']);
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'ERROR AL GENERAR LA ASIGNACIÓN']);
            }
        }else{
            $campo_cantera = "'id_cantera'"; 
            $campo_sujeto = "'id_sujeto'";

            $insert = DB::table('asignacion_reservas')->insert(['contribuyente' => 27,
                                                        'id_sujeto' => $id_sujeto, 
                                                        'id_cantera'=>$id_cantera,
                                                        'cantidad_guias'=>$cant,
                                                        'total_ucd'=>$total_ucd, 
                                                        'estado' => 17,
                                                        'id_user' => $user]);
            if ($insert) {
                $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
                $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
                $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
                $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

                if(copy($oficio->getRealPath(),$ruta)){
                    $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                }else{
                    return response()->json(['success' => false, 'nota' => 'ERROR AL GENERAR LA ASIGNACIÓN']);
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'ERROR AL GENERAR LA ASIGNACIÓN']);
            }
        }

    //    return response($id_asignacion);
        // $cant = $query->cantidad_guias;
        // $id_cantera = $query->id_cantera; 
        // $id_sujeto = $query->id_sujeto;

        /////////////////ASIGNACIÓN DE GUÍAS: CORRELATIVO Y QR
        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
        if ($query_count) {
            if ($query_count->total != 0) {
                $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                if ($cant <= $consulta->total) {
                    ///SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                    $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                    if ($c) {
                        $asignado = $c->asignado;
                        $guias_restantes = 50 - $asignado;
                        
                        if ($cant <= $guias_restantes) {
                            /////hay guías suficientes en el talonario para la solicitud
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = ($c->desde + $cant)-1;
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonarios')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = ($desde + $cant) - 1;
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }
                            
                            ///////insert detalle
                            $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                    'id_talonario' => $c->id_talonario,
                                                                    'id_cantera' => $id_cantera, 
                                                                    'id_sujeto' => $id_sujeto, 
                                                                    'desde' => $desde, 
                                                                    'hasta' => $hasta,
                                                                    'clase' => 6,
                                                                    'id_solicitud_reserva' => $id_asignacion]);
                            if ($detalle_talonario) {
                                $asignado = $asignado + $cant;
                                $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);

                                $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                                
                                QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));
                                $update_qr = DB::table('detalle_talonarios')->where('id_talonario','=', $c->id_talonario)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                                if ($update_qr) {
                                
                                    $user = auth()->id();
                                    $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                                    $accion = 'ASIGNACIÓN DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.', ID TALONARIO: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                    $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                    
                                    
                                    $total_guias_reserva = $consulta->total - $cant;
                                    $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                                    if ($update_total_reserva) {
                                        return response()->json(['success' => true, 'asignacion' => $id_asignacion]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }


                                }
                            }else{
                                return response()->json(['success' => false]);
                            }

                        }else{
                            /////no hay guias suficientes en el talonario para la solicitud
                            $i = 0; //////cuenta las guías asignadas 
                            $talonarios = [];
                            $url_talonarios = '';
                            // $x = 0; //////cuenta las iteraciones del bucle

                            ////////////SE HACE EL PRIMER REGISTRO DE LAS GUIAS PARA DESPUES PASAR AL BUCLE  
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = $c->hasta;

                                $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                        'id_talonario' => $c->id_talonario,
                                                                                        $campo_cantera => $id_cantera, 
                                                                                        $campo_sujeto => $id_sujeto, 
                                                                                        'desde' => $desde, 
                                                                                        'hasta' => $hasta,
                                                                                        'clase' => 6,
                                                                                        'id_solicitud_reserva' => $id_asignacion]);
                                if ($detalle_talonario) {
                                    $i = 50;
                                    $asignado = $c->asignado + $i;
                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                }else{
                                    return response()->json(['success' => false]);
                                }
                                
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonarios')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = $c->hasta;
                                    
                                    $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                        'id_talonario' => $c->id_talonario,
                                                                                        $campo_cantera => $id_cantera, 
                                                                                        $campo_sujeto => $id_sujeto, 
                                                                                        'desde' => $desde, 
                                                                                        'hasta' => $hasta,
                                                                                        'clase' => 6,
                                                                                        'id_solicitud_reserva' => $id_asignacion]);
                                    if ($detalle_talonario) {
                                        $i = ($hasta - $desde) + 1;
                                        $asignado = $c->asignado + $i;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }

                            array_push($talonarios,$c->id_talonario);
                            $url_talonarios = 'T'.$c->id_talonario;


                            do {
                                // $cant -> cantidad de guías solicitadas
                                // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo

                                $guias_faltantes = $cant - $i;
                                $c2 = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                                if ($c2) {
                                    ////// todavia no se han asignado guías del talonario
                                    $desde = $c2->desde;
                                    $hasta = 0;
                                    if ($guias_faltantes <= 50) {
                                        $hasta = ($desde + $guias_faltantes) - 1;
                                    }else{
                                        $hasta = $c2->hasta;
                                    }

                                    $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                    'id_talonario' => $c2->id_talonario,
                                                                                    $campo_cantera => $id_cantera, 
                                                                                    $campo_sujeto => $id_sujeto, 
                                                                                    'desde' => $desde, 
                                                                                    'hasta' => $hasta,
                                                                                    'clase' => 6,
                                                                                    'id_solicitud_reserva' => $id_asignacion]);
                                    if ($detalle_talonario) {
                                        $i = $i + (($hasta - $desde) + 1);  
                                        $asignado = $c2->asignado + $i;
                                        array_push($talonarios,$c2->id_talonario);
                                        $url_talonarios .= '-'.$c2->id_talonario;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]); 
                                    }                             
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                                // $x++;
                            } while ($i == $cant);

                            //////GENERAR QR PARA EL(LOS) TALONARIO(S)
                            $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                            QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));

                            // $url = route('qr.qrReserva', ['idTalonario' => $talonarios ,'idSujeto' => $id_sujeto,'idSolicitud' => $idSolicitud]);
                            // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_'.$url_talonarios.'_SR'.$idSolicitud.'.svg'));
                            
                            foreach ($talonarios as $key => $v) {
                                $update_qr = DB::table('detalle_talonarios')->where('id_talonario', '=', $v)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                            }

                                
                            $user = auth()->id();
                            $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                            $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

                            $total_guias_reserva = $consulta->total - $cant;
                            $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                            if ($update_total_reserva) {
                                return response()->json(['success' => true, 'asignacion' => $id_asignacion]);
                            }else{
                                return response()->json(['success' => false]);
                            }
       

                        }

                    }else{
                        return response()->json(['success' => false]);
                    }
                    
                }else{
                    ///NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Guías de Reserva disponible.']);
                }                
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
            }
        }else{
            return response()->json(['success' => false]);
        }

      
    }



    public function correlativo(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
        $tables = '';
        return response('lo hizo');
        // $talonarios = DB::table('talonarios')->select('id_talonario','tipo_talonario','desde','hasta')->where('id_reserva','=',$id_reserva)->get();

        // if ($talonarios) {
        //     $i=0;
        //     foreach ($talonarios as $talonario) {
        //         $i = $i + 1;
        //         $desde = $talonario->desde;
        //         $hasta = $talonario->hasta;
        //         $length = 6;
        //         $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        //         $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);


            

        //         $tables .= ' <span class="ms-3 text-muted">Talonario Nro. '.$i.'</span>
        //                 <div class="row d-flex align-items-center px-5">
        //                     <div class="col-sm-12">
        //                         <table class="table mt-2 mb-3">
        //                             <tr>
        //                                 <th>Contenido:</th>
        //                                 <td>'.$talonario->tipo_talonario.' Guías</td>
        //                             </tr>
        //                             <tr>
        //                                 <th>Desde:</th>
        //                                 <td>'.$formato_desde.'</td>
        //                             </tr>
        //                             <tr>
        //                                 <th>Hasta:</th>
        //                                 <td>'.$formato_hasta.'</td>
        //                             </tr>
        //                         </table>
        //                     </div>
        //                 </div>';
        
                    
        //     }

        //     $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
        //                     <div class="text-center">
        //                     <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
        //                         <h1 class="modal-title text-navy fs-5" id="exampleModalLabel">CORRELATIVO</h1>
        //                         <span class="fs-6 text-muted">Talonario(s) Emitidos</span>
        //                     </div>
        //                 </div>
        //                 <div class="modal-body" style="font-size:14px">
        //                     <p class="text-center" style="font-size:14px">El correlativo correspondiente a la reserva es el siguiente:</p>
        //                         '.$tables.'
        //                     <div class="d-flex justify-content-center">
        //                         <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo_reserva" data-bs-dismiss="modal">Salir</button>
        //                     </div>
        //                 </div>';
        //     return response($html);
        // }

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
