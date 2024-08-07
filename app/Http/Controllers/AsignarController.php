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
        $asignaciones = [];
        $consulta = DB::table('asignacion_reservas')
                                    ->join('clasificacions', 'asignacion_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                    ->select('asignacion_reservas.*','clasificacions.nombre_clf')
                                    ->where('asignacion_reservas.estado','=',17)
                                    ->orWhere('asignacion_reservas.estado','=',29)
                                    ->get();

        foreach($consulta as $c) {
            $tipo_sujeto = $c->contribuyente;
            $rif_nro = '';
            $rif_condicion = '';

            if ($tipo_sujeto == 27) { ///registrado
                $sujeto = DB::table('sujeto_pasivos')->select('rif_nro','rif_condicion')->where('id_sujeto','=',$c->id_sujeto)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
            }else{  //////no registrado
                $sujeto = DB::table('sujeto_notusers')->select('rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$c->id_sujeto_notuser)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
            }

            $array = array(
                'id_asignacion' => $c->id_asignacion,
                'contribuyente' => $c->contribuyente,
                'id_sujeto' => $c->id_sujeto,
                'rif_nro' => $rif_nro,
                'rif_condicion' => $rif_condicion,
                'cantidad_guias' => $c->cantidad_guias,
                'fecha_emision' => $c->fecha_emision,
                'soporte' => $c->soporte,
                'estado' => $c->estado
            );

            $a = (object) $array;
            array_push($asignaciones, $a);
        }


        return view('asignar', compact('asignaciones'));
    }

    public function sujeto(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $tipo = $request->post('tipo');
        if ($tipo == 27) { 
            /////REGISTRADO
            $sujeto = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->first();
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                            <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$sujeto->razon_social.'</h1>
                            <h5 class="modal-title text-muted" id="" style="font-size:14px">Contribuyente</h5>
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

        }else{
            ///// NO REGISTRADO
            $sujeto = DB::table('sujeto_notusers')->where('id_sujeto_notuser','=',$idSujeto)->first();
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
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado en Asignaciones</p>
                            <a href="#" class="asignar" tipo="notuser" id_sujeto="'.$consulta->id_sujeto_notuser.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
            }
        }else{
            $consulta =  DB::table('sujeto_pasivos')->select('id_sujeto','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado en la Plataforma</p>
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
                      
                $html = '<div class="modal-header">
                         <h1 class="modal-title fs-5 text-navy fw-bold d-flex align-items-center" id="exampleModalLabel" ><i class="bx bx-customize me-2 text-muted fs-2"></i>Asignación de Guías</h1>
                    </div>
                    <div class="modal-body " style="font-size:13px">
                        <form id="form_asignar_guias_register" method="post" onsubmit="event.preventDefault(); asignarGuiasRegister();">
                            <div class="row px-4">
                                <div class="col-sm-6">
                                    <div class="text-center text-navy fw-bold mb-3">
                                        <span class="">Datos del Contribuyente</span><br>
                                        <span class="text-secondary">Registrado en la Plataforma</span>
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

                                    <div class=" mb-2">
                                        <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" type="number" id="cantidad" name="cantidad" required>
                                    </div>
                                    <div class=" mb-2">
                                        <label class="form-label" for="motivo">Motivo</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" type="text" id="motivo" name="motivo" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                        <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                        <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                    </div>
                                    <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>


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
                    
                
            }else{
                return response()->json(['success' => false]);
            }

        }else{
            $sp = DB::table('sujeto_notusers')->where('id_sujeto_notuser','=',$sujeto)->first();
            if ($sp) {
                    
                $html = '<div class="modal-header">
                             <h1 class="modal-title fs-5 text-navy fw-bold d-flex align-items-center" id="exampleModalLabel" ><i class="bx bx-customize me-2 text-muted fs-2"></i>Asignación de Guías</h1>
                        </div>
                        <div class="modal-body " style="font-size:13px">
                            <form id="form_asignar_guias_register" method="post" onsubmit="event.preventDefault(); asignarGuiasRegister();">
                                <div class="row px-4">
                                    <div class="col-sm-6">
                                        <div class="text-center text-navy fw-bold mb-3">
                                            <span class="">Datos del Contribuyente</span><br>
                                            <span class="text-secondary">Registrado en Asignaciones</span>
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
                                            <span class="fw-bold">Representante legal</span>
                                            <p class="text-muted mb-2">'.$sp->name_repr.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">C.I. del Representante</span>
                                            <p class="text-muted mb-2">'.$sp->ci_condicion_repr.'-'.$sp->ci_nro_repr.'</p>
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

                                        <div class=" mb-2">
                                            <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" type="number" name="cantidad" required>
                                        </div>
                                        <div class=" mb-2">
                                            <label class="form-label" for="motivo">Motivo</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" type="text" id="motivo" name="motivo" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                            <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                            <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                        </div>

                                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

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
                    
                
            }else{
                return response()->json(['success' => false]);
            }
        }


    }


    public function asignar_notuser(Request $request)
    {   
        $rif_condicion = $request->post('rif_condicion');
        $rif_nro = $request->post('rif_nro');
        $razon_social = $request->post('razon_social');
        $direccion = $request->post('direccion');
        $tlf_movil = $request->post('tlf_movil');
        $ci_condicion_repr = $request->post('ci_condicion_repr');
        $ci_nro_repr = $request->post('ci_nro_repr');
        $name_repr = $request->post('name_repr');
        $tlf_repr = $request->post('tlf_repr');
        $cantidad = $request->post('cantidad');
        $motivo = $request->post('motivo');
        $oficio = $request->file('oficio');

        $user = auth()->id();
        $year = date("Y");

        ///////////CREAR CARPETA PARA LOS OFICIOS SI NO EXISTE
        if (!is_dir('../public/assets/oficiosReservas/'.$year)){   ////no existe la carpeta del año
            mkdir('../public/assets/oficiosReservas/'.$year, 0777);
        }

        /////////////////////////////////////// (1) REGISTRAR SUJETO NOT USER
        $insert_sujeto = DB::table('sujeto_notusers')->insert(['rif_condicion' => $rif_condicion,
                                                        'rif_nro' => $rif_nro, 
                                                        'razon_social' => $razon_social,
                                                        'direccion' => $direccion,
                                                        'tlf_movil' => $tlf_movil,
                                                        'ci_condicion_repr' => $ci_condicion_repr,
                                                        'ci_nro_repr' => $ci_nro_repr,
                                                        'name_repr' => $name_repr,
                                                        'tlf_repr' => $tlf_repr
                                                    ]);
        if ($insert_sujeto) {

            $id_sujeto = DB::table('sujeto_notusers')->max('id_sujeto_notuser');
            $desde = '';
            $hasta = '';


            /////////////////////////////////// (2) REGISTRAR LA ASIGNACIÓN
            $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 28,
                                                                'id_sujeto_notuser' => $id_sujeto, 
                                                                'cantidad_guias'=>$cantidad,
                                                                'motivo'=>$motivo,
                                                                'estado' => 17,
                                                                'id_user' => $user]);
            if ($insert_asignacion) {
                $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
                $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
                $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
                $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

                if(copy($oficio->getRealPath(),$ruta)){
                    $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                    if ($update_oficio) {
                        //////////////////////////// TRUE RESPONSE
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                return response()->json(['success' => false]);
            }



            /////////////////////////////////// (3) ASIGNACION DE GUÍAS
            $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
            if ($query_count) {
                if ($query_count->total != 0) {
                    $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                    if ($cantidad <= $consulta->total){
                        ////// SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                        $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first();
                        if ($c){
                            $asignado = $c->asignado;
                            $guias_restantes = 50 - $asignado;

                            if ($cantidad <= $guias_restantes) {
                                /////hay guías suficientes en el talonario para la solicitud
                                if ($c->asignado == 0) {
                                    ////// todavia no se han asignado guías del talonario
                                    $desde = $c->desde;
                                    $hasta = ($c->desde + $cantidad)-1;
                                }else{
                                    ////// ya se han asignado guías del talonario
                                    $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                    
                                    if ($detalle) {
                                        
                                        $desde = $detalle->hasta + 1;
                                        $hasta = ($desde + $cantidad) - 1;
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                }
                                
                                
                                $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                'id_talonario' => $c->id_talonario,
                                                                'id_asignacion_reserva' => $id_asignacion,
                                                                'desde' => $desde, 
                                                                'hasta' => $hasta]);
                                
                                
                                if ($detalle_talonario) {
                                    $asignado = $asignado + $cantidad;
                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
    
                                    // $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                                    
                                    // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));
                                    // $update_qr = DB::table('detalle_talonario_reserva')->where('id_talonario','=', $c->id_talonario)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                                    if ($update_asignado) {
                                    
                                        $user = auth()->id();
                                        $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                        $accion = 'ASIGNACIÓN DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.', ID TALONARIO: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                        
                                        
                                        $total_guias_reserva = $consulta->total - $cantidad;
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
                                    
                                    
                                    $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                    'id_talonario' => $c->id_talonario,
                                                                    'id_asignacion_reserva' => $id_asignacion,
                                                                    'desde' => $desde, 
                                                                    'hasta' => $hasta]);
                                    

                                    if ($detalle_talonario) {
                                        $i = 50;
                                        $asignado = $c->asignado + $i;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                    
                                }else{
                                    ////// ya se han asignado guías del talonario
                                    $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                    if ($detalle) {
                                        $desde = $detalle->hasta + 1;
                                        $hasta = $c->hasta;
                                        
                                        $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                    'id_talonario' => $c->id_talonario,
                                                                    'id_asignacion_reserva' => $id_asignacion,
                                                                    'desde' => $desde, 
                                                                    'hasta' => $hasta]);
                                        
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
                                // $url_talonarios = 'T'.$c->id_talonario;
    
    
                                do {
                                    // $cant -> cantidad de guías solicitadas
                                    // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo
    
                                    $guias_faltantes = $cantidad - $i;
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
    
                                        $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                            'id_talonario' => $c->id_talonario,
                                                            'id_asignacion_reserva' => $id_asignacion,
                                                            'desde' => $desde, 
                                                            'hasta' => $hasta]);
                                        
                                        if ($detalle_talonario) {
                                            $i = $i + (($hasta - $desde) + 1);  
                                            $asignado = $c2->asignado + $i;
                                            array_push($talonarios,$c2->id_talonario);
                                            // $url_talonarios .= '-'.$c2->id_talonario;
                                            $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                        }else{
                                            return response()->json(['success' => false]); 
                                        }                             
                                    }else{
                                        return response()->json(['success' => false]); 
                                    }
                                    // $x++;
                                } while ($i == $cantidad);
    
                                //////GENERAR QR PARA EL(LOS) TALONARIO(S)
                                // $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                                // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));
    
                                // $url = route('qr.qrReserva', ['idTalonario' => $talonarios ,'idSujeto' => $id_sujeto,'idSolicitud' => $idSolicitud]);
                                // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_'.$url_talonarios.'_SR'.$idSolicitud.'.svg'));
                                
                                // foreach ($talonarios as $key => $v) {
                                //     $update_qr = DB::table('detalle_talonario_reserva')->where('id_talonario', '=', $v)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                                // }
    
                                    
                                $user = auth()->id();
                                $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                                $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
    
                                $total_guias_reserva = $consulta->total - $cantidad;
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
                        ////// NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                        return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Guías de Reserva disponible.']);
                    }
                }else{
                    ////// NO HAY TALONARIOS DE RESERVA
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
                }
            }else{
                return response()->json(['success' => false]);
            }
            

        }else{
            return response()->json(['success' => false]);
        } 
      
    }




    public function asignar_user(Request $request){
        $id_sujeto = $request->post('id_sujeto');
        $tipo_sujeto = $request->post('tipo_sujeto');

        $cantidad = $request->post('cantidad');
        $motivo = $request->post('motivo');
        $oficio = $request->file('oficio');

        $user = auth()->id();
        $year = date("Y");

        ///////////CREAR CARPETA PARA LOS OFICIOS SI NO EXISTE
        if (!is_dir('../public/assets/oficiosReservas/'.$year)){   ////no existe la carpeta del año
            mkdir('../public/assets/oficiosReservas/'.$year, 0777);
        }

        if ($tipo_sujeto == 'user') {
            /////////////////////////////////// (1) REGISTRAR LA ASIGNACIÓN
            $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 27,
                                                                'id_sujeto' => $id_sujeto, 
                                                                'cantidad_guias'=>$cantidad,
                                                                'motivo'=>$motivo,
                                                                'estado' => 17,
                                                                'id_user' => $user]);
            
        }else{
            /////////////////////////////////// (1) REGISTRAR LA ASIGNACIÓN
            $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 28,
                                                                'id_sujeto_notuser' => $id_sujeto, 
                                                                'cantidad_guias'=>$cantidad,
                                                                'motivo'=>$motivo,
                                                                'estado' => 17,
                                                                'id_user' => $user]);
        }

        if ($insert_asignacion) {
            $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
            $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
            $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
            $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

            if(copy($oficio->getRealPath(),$ruta)){
                $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                if ($update_oficio) {
                    //////////////////////////// TRUE RESPONSE
                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            return response()->json(['success' => false]);
        }



        /////////////////////////////////// (3) ASIGNACION DE GUÍAS
        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
        if ($query_count) {
            if ($query_count->total != 0) {
                $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                if ($cantidad <= $consulta->total){
                    ////// SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                    $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first();
                    if ($c){
                        $asignado = $c->asignado;
                        $guias_restantes = 50 - $asignado;

                        if ($cantidad <= $guias_restantes) {
                            /////hay guías suficientes en el talonario para la solicitud
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = ($c->desde + $cantidad)-1;
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                
                                if ($detalle) {
                                    
                                    $desde = $detalle->hasta + 1;
                                    $hasta = ($desde + $cantidad) - 1;
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }
                            
                            
                            $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                            'id_talonario' => $c->id_talonario,
                                                            'id_asignacion_reserva' => $id_asignacion,
                                                            'desde' => $desde, 
                                                            'hasta' => $hasta]);
                            
                            
                            if ($detalle_talonario) {
                                $asignado = $asignado + $cantidad;
                                $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);

                                if ($update_asignado) {
                                
                                    $user = auth()->id();
                                    if ($tipo_sujeto == 'user') {
                                        $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                                    }else{
                                        $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                    }
                                    
                                    $accion = 'ASIGNACIÓN DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.', ID TALONARIO: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                    $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                    
                                    
                                    $total_guias_reserva = $consulta->total - $cantidad;
                                    $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                                    if ($update_total_reserva) {
                                        return response()->json(['success' => true, 'asignacion' => $id_asignacion, 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
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
                                
                                
                                $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                'id_talonario' => $c->id_talonario,
                                                                'id_asignacion_reserva' => $id_asignacion,
                                                                'desde' => $desde, 
                                                                'hasta' => $hasta]);
                                

                                if ($detalle_talonario) {
                                    $i = 50;
                                    $asignado = $c->asignado + $i;
                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                }else{
                                    return response()->json(['success' => false]);
                                }
                                
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = $c->hasta;
                                    
                                    $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                'id_talonario' => $c->id_talonario,
                                                                'id_asignacion_reserva' => $id_asignacion,
                                                                'desde' => $desde, 
                                                                'hasta' => $hasta]);
                                    
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
                            // $url_talonarios = 'T'.$c->id_talonario;


                            do {
                                // $cant -> cantidad de guías solicitadas
                                // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo

                                $guias_faltantes = $cantidad - $i;
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

                                    $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                        'id_talonario' => $c->id_talonario,
                                                        'id_asignacion_reserva' => $id_asignacion,
                                                        'desde' => $desde, 
                                                        'hasta' => $hasta]);
                                    
                                    if ($detalle_talonario) {
                                        $i = $i + (($hasta - $desde) + 1);  
                                        $asignado = $c2->asignado + $i;
                                        array_push($talonarios,$c2->id_talonario);
                                        // $url_talonarios .= '-'.$c2->id_talonario;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]); 
                                    }                             
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                                // $x++;
                            } while ($i == $cantidad);


                                
                            $user = auth()->id();
                            if ($tipo_sujeto == 'user') {
                                $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                            }else{
                                $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                            }
                            $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

                            $total_guias_reserva = $consulta->total - $cantidad;
                            $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                            if ($update_total_reserva) {
                                return response()->json(['success' => true, 'asignacion' => $id_asignacion, 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
                            }else{
                                return response()->json(['success' => false]);
                            }
        

                        }
                    }else{
                        return response()->json(['success' => false]);
                    }

                }else{
                    ////// NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Guías de Reserva disponible.']);
                }
            }else{
                ////// NO HAY TALONARIOS DE RESERVA
                return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
            }
        }else{
            return response()->json(['success' => false]);
        }


    }


    


    public function guias(Request $request) {
        $id_asignacion = $request->post('asignacion');
        $id_sujeto = $request->post('sujeto');
        $tipo_sujeto = $request->post('tipo');

        $li = '';
        $tab_pane = '';

        $consulta = DB::table('asignacion_reservas')->select('cantidad_guias')->where('id_asignacion','=',$id_asignacion)->first();
        if ($consulta) {
            $cantidad = $consulta->cantidad_guias;

            // for ($i=1; $i <= $cantidad ; $i++) { 
            //     $ul;
            // }
        }else{
            return response()->json(['success' => false]);
        }

        $correlativo = DB::table('detalle_talonario_reservas')->where('id_asignacion_reserva','=',$id_asignacion)->get();
        if ($correlativo) {
            $contador = 0;
            foreach ($correlativo as $c) {
                $desde = $c->desde;
                $hasta = $c->hasta;

                for ($i=$desde; $i <= $hasta ; $i++) { 
                    $contador++;

                    $li .= '<li class="nav-item" role="presentation">
                                <button class="nav-link active d-flex align-items-center" id="'.$i.'-tab" data-bs-toggle="pill" data-bs-target="#g'.$i.'-tab-pane" type="button" role="tab" aria-controls="'.$i.'-tab-pane" aria-selected="true">
                                    <i class="bx bx-tag bx-flip-horizontal me-2 fs-6" ></i>
                                    Guía '.$contador.'
                                </button>
                            </li>';
                    
                }
            }
        }else{
            return response()->json(['success' => false]);
        }
    }




    public function add_cantera(Request $request){
        $id_sujeto = $request->post('sujeto');
        $nombre = $request->post('nombre');
        $direccion = $request->post('direccion');
        $municipio = $request->post('municipio');
        $parroquia = $request->post('parroquia');
        
        if (empty($nombre) || empty($direccion) || empty($municipio) || empty($parroquia)) {
            return response()->json(['success' => false,'i' => 'empty']);
        }else{
            $insert = DB::table('canteras_notusers')->insert(['id_sujeto_notuser' => $id_sujeto,
                                                            'nombre' => $nombre, 
                                                            'municipio_cantera' => $municipio,
                                                            'parroquia_cantera' => $parroquia,
                                                            'lugar_aprovechamiento' => $direccion
                                                        ]);

            
            if ($insert) {
                $id_cantera = DB::table('canteras_notusers')->max('id_cantera_notuser');
                return response()->json(['success' => true, 'cantera' => $id_cantera, 'nombre' => $nombre]);
            }else{
                return response()->json(['success' => false, 'i' => 'error']);
            }
        }

    }











    // public function canteras(Request $request)  
    // {
    //     $sujeto = $request->post('sujeto');

    //     $opction_canteras = '';
    //     $canteras = DB::table('canteras_notusers')->select('id_cantera_notuser','nombre')->where('id_sujeto_notuser','=',$sujeto)->get();

    //     if ($canteras) {
    //         foreach ($canteras as $cantera) {
    //             $opction_canteras .= '<option  value="'.$cantera->id_cantera_notuser.'">'.$cantera->nombre.'</option>';
    //         }
    //         $select = '<label class="form-label" for="cantera">Cantera y/o Desazolve</label><span class="text-danger">*</span>
    //                     <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
    //                         '.$opction_canteras.'
    //                     </select>';
    //         return response($select);
    //     }

    // }



    


    public function correlativo(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
       

        $detalle = DB::table('detalle_talonarios')->select('desde','hasta')->where('id_solicitud_reserva','=',$id_asignacion)->first();
       
        if ($detalle) {
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

     $asignacion = DB::table('asignacion_reservas')->select('cantidad_guias')->where('id_asignacion','=',$id_asignacion)->first();
            $cantidad = $asignacion->cantidad_guias;
        
       

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title text-navy fs-5" id="exampleModalLabel">CORRELATIVO</h1>
                                <span class="fs-6 text-muted">Guía(s) Asignadas</span>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px">
                            <p class="text-center" style="font-size:14px">El correlativo correspondiente a la asignación de Guías es el siguiente:</p>
                                <div class="row d-flex align-items-center px-5">
                                    <div class="col-sm-12">
                                        <table class="table mt-2 mb-3">
                                            <tr>
                                                <th>No. de Guías:</th>
                                                <td>'.$cantidad.' Guías</td>
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
                                </div>
                            <div class="d-flex justify-content-center">
                                <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo_reserva" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>';
            return response($html);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function detalle(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
        $tipo = $request->post('tipo');

        $razon_social = '';
        $rif = '';
        $nombre_cantera = '';
        $direccion_cantera = '';
        $registro = '';
        
        $query = DB::table('asignacion_reservas')->where('id_asignacion','=',$id_asignacion)->first();
        if ($query) {
            $emision = $query->fecha_emision;
            $guias = $query->cantidad_guias;
            $ucd = $query->total_ucd;
            $soporte = $query->soporte;
            $entrega = $query->fecha_entrega;
            $tr_entrega = '';

            if ($entrega == null) {
                $tr_entrega = '';
            }else{
               $tr_entrega = '<tr>
                                <th>Fecha de entrega</th>
                                <td></td>
                            </tr>';
            }

            $correlativo = DB::table('detalle_talonarios')->select('desde','hasta')->where('id_solicitud_reserva','=',$id_asignacion)->first();
            $desde = $correlativo->desde;
            $hasta = $correlativo->hasta;
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            if ($tipo == 27) {
                ///REGISTRADO
                $sujeto = DB::table('sujeto_pasivos')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto','=',$query->id_sujeto)->first();
                $razon_social = $sujeto->razon_social;
                $rif = $sujeto->rif_condicion.'-'.$sujeto->rif_nro;

                $cantera = DB::table('canteras')->select('nombre','lugar_aprovechamiento')->where('id_cantera','=',$query->id_cantera)->first();
                $nombre_cantera = $cantera->nombre;
                $direccion_cantera = $cantera->lugar_aprovechamiento;
                $registro = '<span class="badge bg-primary-subtle text-primary-emphasis ms-2">Registrado</span>';
            }else{
                /// NO REGISTRADO
                $sujeto = DB::table('sujeto_notusers')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto_notuser','=',$query->id_sujeto_notuser)->first();
                $razon_social = $sujeto->razon_social;
                $rif = $sujeto->rif_condicion.'-'.$sujeto->rif_nro;

                $cantera = DB::table('canteras_notusers')->select('nombre','lugar_aprovechamiento')->where('id_cantera_notuser','=',$query->id_cantera_notuser)->first();
                $nombre_cantera = $cantera->nombre;
                $direccion_cantera = $cantera->lugar_aprovechamiento;
                $registro = '<span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">No Registrado</span>';
            }

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-detail fs-1 text-secondary"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy" id="" >Detalles de la Asignación</h1>
                        </div>
                    </div>
                    <div class="modal-body" style="font-size:13px;">
                        <div class="d-flex justify-content-center mt-2">
                            <table class="table w-75 ">
                                <tr>
                                    <th>ID</th>
                                    <td class="text-secondary">'.$query->id_asignacion.'</td>
                                </tr>
                                <tr>
                                    <th>Emisión</th>
                                    <td>'.$emision.'</td>
                                </tr>
                                <tr>
                                    <th>Contribuyente</th>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-navy fw-bold">'.$razon_social.'
                                                '.$registro.'
                                            </span>
                                            <span class="text-secondary">'.$rif.'</span>  
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cantera o Desazolve</th>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-navy fw-bold">'.$nombre_cantera.'</span>
                                            <span>'.$direccion_cantera.'</span>  
                                        </div> 
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th>Guías solicitadas</th>
                                    <td class="text-navy fw-bold">'.$guias.' Guías</td>
                                </tr>
                                <tr class="table-primary">
                                    <th>Correlativo</th>
                                    <td class="text-navy fw-bold">'.$formato_desde.' - '.$formato_hasta.'</td>
                                </tr>
                                <tr class="table-primary">
                                    <th>Total UCD</th>
                                    <td class="text-navy fw-bold">'.$ucd.' UCD</td>
                                </tr>
                                <tr>
                                    <th>Oficio</th>
                                    <td>
                                        <a target="_blank" class="ver_pago" href="'.asset($soporte).'">Ver</a>
                                    </td>
                                </tr>
                                '.$tr_entrega.'
                            </table>
                        </div>

                        <div class="d-flex justify-content-center my-2">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                        </div>
                    </div>';

            return response($html);
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
