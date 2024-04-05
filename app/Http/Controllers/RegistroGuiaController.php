<?php

namespace App\Http\Controllers;
use App\Models\SujetoPasivo;
use DB;

use Illuminate\Http\Request;

class RegistroGuiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $registros = DB::table('control_guias')
                                ->join('canteras', 'control_guias.id_cantera', '=', 'canteras.id_cantera')
                                ->join('minerals', 'control_guias.id_mineral', '=', 'minerals.id_mineral')
                                ->select('control_guias.*', 'canteras.nombre', 'minerals.mineral')
                                ->where('control_guias.id_sujeto', $id_sp)->get();

        return view('registro_guia', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function modal_registro(){
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $html = '';
        $opction_canteras = '';

        $canteras = DB::table('canteras')->select('id_cantera','nombre')->where('id_sujeto','=',$id_sp)
                                                                        ->where('status','=','Verificada')->get();
            if ($canteras) {
                foreach ($canteras as $cantera) {
                    $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                }

                $html = '<form id="form_registrar_guia" method="post" onsubmit="event.preventDefault(); registrarGuia()">
                <p class="px-3 fw-semibold fs-6 text-body-secondary">IMPORTANTE: Debe seleccionar la Cantera de la cual proviene la Guía y el Talonario, para así poder ingresar los demás datos.</p>
                            <div class="row d-flex justify-content-between  px-3">
                                <div class="col-sm-5">
                                    <!-- cantera -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-select form-select-sm" id="select_cantera" name="cantera" required>
                                                <option>...</option>
                                                '.$opction_canteras.'
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 text-end fs-5 fw-bold text-muted">
                                    <span class="text-danger">Nro° Guía </span><span id="nro_guia_view"></span>
                                </div>
                            </div>

                            
                            
                            <input type="hidden" id="id_talonario" name="id_talonario" value="" required>
                            <input type="hidden" id="nro_guia" name="nro_guia" value="" required>
                            <input type="hidden" id="nro_control" name="nro_control" value="" required>

                            <div class="row px-3 d-flex justify-content-between">
                                <div class="col-sm-4">
                                    <!-- fecha de emision -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-5">
                                            <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-7">
                                            <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" required disabled>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- tipo de guia -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="" class="col-form-label">Tipo Guía: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_guia" id="venta" value="Venta" disabled>
                                                <label class="form-check-label" for="venta">Venta</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_guia" id="donacion" value="Donación" disabled>
                                                <label class="form-check-label" for="donacion">Donación</label>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                            </div>

                            <!-- direccion de la cantera
                            <div class="row">
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-3">
                                        <label for="" class="col-form-label">Dirección:</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="text-muted fst-italic text-start" id="direccion_cantera"></p>
                                    </div>
                                </div>
                            </div> -->

                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>

                            <div class="row">
                                <div class="col-sm-6 px-4">
                                    <!-- razon social -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="razon" class="col-form-label">Razon social: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required disabled>
                                        </div>
                                    </div>

                                    <!-- telefono del destinatario  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6 px-4">
                                    <!-- ci del destinatario -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="ci" class="col-form-label">R.I.F: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" required disabled>
                                        </div>
                                    </div>

                                    <!-- destino -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="municipio" class="col-form-label">Municipio/Parroqui: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="municipio" class="form-control form-control-sm" name="municipio" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="col-sm-12">
                                <div class="row align-items-center mb-2">
                                        <div class="col-2">
                                            <label for="destino" class="col-form-label">Lugar de destino: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="destino" class="form-control form-control-sm" name="destino" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>

                            <div class="row px-3 d-flex align-items-center">
                                <div class="col-sm-4">
                                    <!-- mineral no metalico -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required disabled>
                                                <option selected>...</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <!-- cantidad -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="cantidad" class="col-form-label">Cantidad Facturada: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" id="unidad_medida" required disabled>
                                                <option value="Toneladas">Toneladas</option>
                                                <option value="Metros cúbicos">Metros Cúbicos</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input type="number" step="0.01" id="cantidad" class="form-control form-control-sm" name="cantidad_facturada" placeholder="Cantidad" required disabled>
                                        </div> 
                                    </div>
                                </div>
                                <!-- fecha facturacion -->
                                <div class="col-sm-3">
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="fecha_facturacion" class="col-form-label">Fecha de facturación: </label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" id="fecha_facturacion" class="form-control form-control-sm" name="fecha_facturacion" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3 d-flex align-items-center">
                                <!-- saldo anterior -->
                                <div class="col-sm-4">
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="saldo_anterior" class="col-form-label">Saldo anterior: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" step="0.01" id="saldo_anterior" class="form-control form-control-sm" name="saldo_anterior" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cantidad Despachada -->
                                <div class="col-sm-4">
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="cantidad_despachada" class="col-form-label">Cantidad Despachada: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" step="0.01" id="cantidad_despachada" class="form-control form-control-sm" name="cantidad_despachada" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saldo Restante -->
                                <div class="col-sm-4">
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="saldo_restante" class="col-form-label">Saldo Restante: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" step="0.01" id="saldo_restante" class="form-control form-control-sm" name="saldo_restante" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>

                            <div class="row d-flex align-items-center">
                                <div class="col-sm-6 px-4">
                                    <!-- modelo del vehiculo -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required disabled>
                                        </div>
                                    </div>

                                    <!-- Nombre del conductor  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required disabled>
                                        </div>
                                    </div>

                                    <!-- telefono del conductor  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 px-4">
                                    <!-- placa -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="placa" class="col-form-label">Placa: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required disabled>
                                        </div>
                                    </div>

                                    <!-- ci conductor -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required disabled>
                                        </div>
                                    </div>

                                    <!-- capacidad del vehiculo -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="capacidad_vehiculo" class="col-form-label">Capacidad del Vehículo: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="capacidad_vehiculo" class="form-control form-control-sm" name="capacidad_vehiculo" placeholder="" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de Circulación</p>
                            
                            <div class="row">
                                <div class="col-sm-6 px-4">
                                    <!-- hora de Salida -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="hora_salida" class="col-form-label">Hora de Salida: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 px-4">
                                    <!-- hora de llegada -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="hora_llegada" class="col-form-label">Hora de Llegada: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- otros datos -->
                            <div class="row px-2">
                                <div class="col-sm-3">
                                    <!-- nro factura -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-6">
                                            <label for="factura" class="col-form-label">Nro° Factura: </label>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" disabled>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- anulada -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-5">
                                            <label for="" class="col-form-label">¿Anulada?: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-check form-check-inline ">
                                                <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si" disabled>
                                                <label class="form-check-label" for="anulado_si">
                                                    Si
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No"  disabled>
                                                <label class="form-check-label" for="anulado_no">
                                                    No
                                                </label>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- motivo de anulacion -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-3">
                                            <label for="motivo_anulada" class="col-form-label">Motivo: </label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                <span class=" text-danger">Nro° Control </span><span id="nro_control_view"></span>
                            </div>

                            <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary btn-sm me-3" id="btn_guardar_guia" disabled>Guardar</button>
                            </div>
                        </form>';

                        return response($html);
            }

        
    }




    public function cantera(Request $request){
        $idCantera = $request->post('cantera'); 
        $minerales = '';
        $nro_guia = '';
        $nro_control = '';
        $formato_nro_guia = '';
        $idTalonario = '';

        
        ///////////// buscar si el usuario a registrado guias anteriormente
        $conteo = DB::table('control_guias')->selectRaw("count(*) as total")->where('id_cantera','=',$idCantera)->get();
        if ($conteo) {
            foreach ($conteo as $c){
                if ($c->total == 0){
                    ///////EL USUARIO TODAVI NO HA REGISTRADO NINGUNA GUÍA DE ESTA CANTERA
                    $talonario = DB::table('talonarios')->where('id_cantera',$idCantera)->first(); 
                    
                    if ($talonario) {
                        $idTalonario = $talonario->id_talonario;
                        $nro_guia = $talonario->desde;
                        $length = 6;
                        $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia, - $length);

                        ////////buscar el numero de control correspondiente a este nro guia
                        $control = DB::table('nro_controls')->select('nro_control')->where('nro_guia','=',$nro_guia)->first();
                        if ($control){  
                            $nro_control = $control->nro_control;
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    ///////EL USUARIO HA REGISTRADO GUÍAS DE ESTA CANTERA
                    /////consulta la ultima guia que registro el usuario
                    $consulta = DB::table('control_guias')->where('id_cantera','=',$idCantera)->latest('correlativo')->first();
                    if ($consulta) {
                        $ultimo_nro_guia = $consulta->nro_guia;
                        $ultimo_id_talonario = $consulta->id_talonario;
                        
                        ////////////comprobar si el ultimo numero de guia registrado es la ultima guia del talonario
                        $comprobar = DB::table('talonarios')->where('id_talonario','=',$ultimo_id_talonario)->first();
                        if ($comprobar) {
                            if ($ultimo_nro_guia < $comprobar->hasta){
                                //////////////TODAVIA QUEDAN GUIAS EN EL TALONARIO
                                $nro_guia = $ultimo_nro_guia + 1 ;
                                $length = 6;
                                $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia, - $length);

                                ////////buscar el numero de control correspondiente a este nro guia
                                $control = DB::table('nro_controls')->select('nro_control')->where('nro_guia','=',$nro_guia)->first();
                                if ($control){
                                    $nro_control = $control->nro_control;
                                    $idTalonario = $ultimo_id_talonario;
                                }
                            }else{
                                //////////////YA NO QUEDAN GUIAS EN EL TALONARIO
                                ////////////buscar el siguiente talonario correspondiente al sujeto pasivo
                                $buscar = DB::table('talonarios')->where([
                                                                        ['id_talonario','>',$ultimo_id_talonario],
                                                                        ['id_cantera','=',$idCantera]
                                                                    ])->orderBy('id_talonario','asc')->first();
                                if ($buscar) {
                                    if ($buscar != ''){
                                        ///////HAY UN SIGUIENTE TALONARIO
                                        $nro_guia = $buscar->desde;
                                        $idTalonario = $buscar->id_talonario;
                                        $length = 6;
                                        $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia, - $length);

                                        ////////buscar el numero de control correspondiente a este nro guia
                                        $control = DB::table('nro_controls')->select('nro_control')->where('nro_guia','=',$nro_guia)->first();
                                        if ($control){
                                            $nro_control = $control->nro_control;
                                        }
                                    }else{
                                        ////// EL USUARIO NO HA SOLICITADO MAS TLONARIOS
                                        $html = '<div class="text-center text-muted my-4 pb-4">
                                                    <i class="bx bx-error-circle bx-tada fs-1" ></i>
                                                    <h4>Discupe, debe solicitar una nueva guia.</h4>
                                                </div>';
                                        return response($html);
                                    }
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }

                        }
                    }else{
                        return response()->json(['success' => false]);
                    }
                }
            }
        }else{
            return response()->json(['success' => false]);
        }


        $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
        foreach ($minerales as $id_min) {
            $id = $id_min->id_mineral;
            $query_min = DB::table('minerals')->select('id_mineral','mineral')->where('id_mineral','=',$id)->get();
            if($query_min){ 
                foreach ($query_min as $mineral) {
                    $minerales .= '<option value="'.$mineral->id_mineral.'">'.$mineral->mineral.'</option>';
                }
            } 
        }

        return response()->json(['success' => true, 'minerales' => $minerales, 'talonario' => $idTalonario, 'nro_guia' => $nro_guia, 'formato_nro_guia' => $formato_nro_guia, 'nro_control' => $nro_control]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $id_talonario = $request->post('id_talonario');
        $id_sujeto = $id_sp;
        $nro_guia = $request->post('nro_guia');
        $nro_control = $request->post('nro_control');
        $id_cantera = $request->post('cantera');

        $fecha = $request->post('fecha_emision');
        $tipo_guia = $request->post('tipo_guia');
        $razon_dest = $request->post('razon_dest');
        $ci_dest = $request->post('ci_dest');
        $tlf_dest = $request->post('tlf_dest');
        $municipio = $request->post('municipio');
        $destino = $request->post('destino');

        $id_mineral = $request->post('mineral');
        $unidad_medida = $request->post('unidad_medida');
        $cantidad = $request->post('cantidad_facturada');
        $fecha_facturacion = $request->post('fecha_facturacion');
        $saldo_anterior = $request->post('saldo_anterior');
        $cantidad_despachada = $request->post('cantidad_despachada');
        $saldo_restante = $request->post('saldo_restante');

        $modelo_vehiculo = $request->post('modelo');
        $placa = $request->post('placa');
        $nombre_conductor = $request->post('nombre_conductor');
        $ci_conductor = $request->post('ci_conductor');
        $tlf_conductor = $request->post('tlf_conductor');
        $capacidad_vehiculo = $request->post('capacidad_vehiculo');

        $hora_salida = $request->post('hora_salida');
        $hora_llegada = $request->post('hora_llegada');
        $nro_factura = $request->post('nro_factura');
        $anulada = $request->post('anulada');
        $motivo = $request->post('motivo');

        $insert = DB::table('control_guias')->insert(['id_talonario' => $id_talonario, 
                                                    'id_sujeto'=>$id_sujeto,
                                                    'id_cantera' => $id_cantera,
                                                    'nro_guia' => $nro_guia, 
                                                    'nro_control' => $nro_control,
                                                    'fecha' => $fecha,
                                                    'tipo_guia' => $tipo_guia,
                                                    'razon_destinatario' => $razon_dest,
                                                    'ci_destinatario' => $ci_dest,
                                                    'tlf_destinatario' => $tlf_dest,
                                                    'municipio_parroquia_destino' => $municipio,
                                                    'destino' => $destino,
                                                    'nro_factura' => $nro_factura,
                                                    'fecha_facturacion' => $fecha_facturacion,
                                                    'id_mineral' => $id_mineral,
                                                    'unidad_medida' => $unidad_medida,
                                                    'cantidad_facturada' => $cantidad,
                                                    'saldo_anterior' => $saldo_anterior,
                                                    'cantidad_despachada' => $cantidad_despachada,
                                                    'saldo_restante' => $saldo_restante,
                                                    'modelo_vehiculo' => $modelo_vehiculo,
                                                    'placa' => $placa,
                                                    'nombre_conductor' => $nombre_conductor,
                                                    'ci_conductor' => $ci_conductor,
                                                    'tlf_conductor' => $tlf_conductor,
                                                    'capacidad_vehiculo' => $capacidad_vehiculo,
                                                    'hora_salida' => $hora_salida,
                                                    'hora_llegada' => $hora_llegada,
                                                    'anulada' => $anulada,
                                                    'motivo' => $motivo
                                                    ]);

        if ($insert) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }


    }

    public function editar(Request $request)
    {
        $nro_guia = $request->post('guia');
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $html = '';
       

        ///////////////////buscar la guía
        $guias = DB::table('control_guias')
                            ->join('canteras', 'control_guias.id_cantera', '=', 'canteras.id_cantera')
                            ->join('minerals', 'control_guias.id_mineral', '=', 'minerals.id_mineral')
                            ->select('control_guias.*', 'canteras.nombre', 'minerals.mineral')
                            ->where('nro_guia','=',$nro_guia)->get();
       
        if ($guias) {
            /////////////////formato: nro guia
            
            foreach ($guias as $guia) {

                
                $length = 6;
                $formato_nro_guia = substr(str_repeat(0, $length).$guia->nro_guia, - $length);
                
                /////////////////info minerales de la cantera
                $id_cantera = $guia->id_cantera;
                $minerales_options = '';
                $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$id_cantera)->get();
                $minerales_options .= '<option value="'.$guia->id_mineral.'">'.$guia->mineral.'</option>';
                foreach ($minerales as $id_min) {
                    $id = $id_min->id_mineral;
                    $query_min = DB::table('minerals')->select('id_mineral','mineral')->where('id_mineral','=',$id)->get();
                    if($query_min){ 
                       
                        foreach ($query_min as $mineral) {
                            if ($mineral->id_mineral != $guia->id_mineral) {
                                $minerales_options .= '<option value="'.$mineral->id_mineral.'">'.$mineral->mineral.'</option>';
                            }
                        }
                    } 
                }
                

                /////////////////info unidad de medida
                $unidad_medida = '';
                if ($guia->unidad_medida == 'Toneladas') {
                    $unidad_medida = '<option value="Toneladas">Toneladas</option>
                                <option value="Metros cúbicos">Metros Cúbicos</option>';
                }else{
                    $unidad_medida = '<option value="Metros cúbicos">Metros Cúbicos</option>
                                <option value="Toneladas">Toneladas</option>';
                }
                
                /////////////////info guia anulada?
                $html_anulada = '';
                $html_motivo = '';
                if ($guia->anulada == 'No') {
                    $html_anulada = '<div class="col-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si">
                                            <label class="form-check-label" for="anulado_si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No" checked>
                                            <label class="form-check-label" for="anulado_no">
                                                No
                                            </label>
                                        </div>
                                    </div>';
                    $html_motivo = '<input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>';
                }else{
                    $html_anulada = '<div class="col-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si" checked>
                                            <label class="form-check-label" for="anulado_si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No">
                                            <label class="form-check-label" for="anulado_no">
                                                No
                                            </label>
                                        </div>
                                    </div>';
                    $html_motivo = '<input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" value="'.$guia->motivo.'">';
                }


                // /////////////////info tipo de guia
                $html_tipo = '';
                if ($guia->tipo_guia == 'Venta') {
                    $html_tipo = '<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_guia" id="venta" value="Venta" checked>
                                    <label class="form-check-label" for="venta">Venta</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_guia" id="donacion" value="Donación">
                                    <label class="form-check-label" for="donacion">Donación</label>
                                </div>';
                }else{
                    $html_tipo = '<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_guia" id="venta" value="Venta">
                                    <label class="form-check-label" for="venta">Venta</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_guia" id="donacion" value="Donación" checked>
                                    <label class="form-check-label" for="donacion">Donación</label>
                                </div>';
                }


                $html = '<form id="form_editar_guia" method="post" onsubmit="event.preventDefault(); editarGuia()">
                <div class="row d-flex justify-content-between  px-3">
                    <div class="col-sm-5">
                        <!-- cantera -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-3">
                                <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-9">
                                <select class="form-select form-select-sm" id="select_cantera" name="cantera" disabled required>
                                    <option>'.$guia->nombre.'</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-end fs-5 fw-bold text-muted">
                        <span class="text-danger">Nro° Guía </span><span id="nro_guia_view">'.$formato_nro_guia.'</span>
                    </div>
                </div>

                <input type="hidden" name="nro_guia" value="'.$guia->nro_guia.'" required>

                <div class="row px-3 d-flex justify-content-between">
                    <div class="col-sm-4">
                        <!-- fecha de emision -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-5">
                                <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-7">
                                <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" value="'.$guia->fecha.'">
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- tipo de guia -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="" class="col-form-label">Tipo Guía: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                '.$html_tipo.'
                            </div> 
                        </div>
                    </div>
                    
                </div>

                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>

                <div class="row">
                    <div class="col-sm-6 px-4">
                        <!-- razon social -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="razon" class="col-form-label">Razon social: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required value="'.$guia->razon_destinatario.'">
                            </div>
                        </div>

                        <!-- telefono del destinatario  -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required value="'.$guia->tlf_destinatario.'">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6 px-4">
                        <!-- ci del destinatario -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="ci" class="col-form-label">R.I.F: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" required value="'.$guia->ci_destinatario.'">
                            </div>
                        </div>

                        <!-- destino -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="municipio" class="col-form-label">Municipio/Parroqui: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="municipio" class="form-control form-control-sm" name="municipio" required value="'.$guia->municipio_parroquia_destino.'">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-sm-12">
                    <div class="row align-items-center mb-2">
                            <div class="col-2">
                                <label for="destino" class="col-form-label">Lugar de destino: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="destino" class="form-control form-control-sm" name="destino" required value="'.$guia->destino.'">
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>

                <div class="row px-3 d-flex align-items-center">
                    <div class="col-sm-4">
                        <!-- mineral no metalico -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required>
                                    '.$minerales_options.'
                                </select>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <!-- cantidad -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="cantidad" class="col-form-label">Cantidad Facturada: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-4">
                                <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" id="unidad_medida" required>
                                    '.$unidad_medida.'
                                </select>
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" id="cantidad" class="form-control form-control-sm" name="cantidad_facturada" placeholder="Cantidad" required value="'.$guia->cantidad_facturada.'">
                            </div> 
                        </div>
                    </div>
                    <!-- fecha facturacion -->
                    <div class="col-sm-3">
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="fecha_facturacion" class="col-form-label">Fecha de facturación: </label>
                            </div>
                            <div class="col-8">
                                <input type="date" id="fecha_facturacion" class="form-control form-control-sm" name="fecha_facturacion" value="'.$guia->fecha_facturacion.'">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3 d-flex align-items-center">
                    <!-- saldo anterior -->
                    <div class="col-sm-4">
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="saldo_anterior" class="col-form-label">Saldo anterior: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="number" step="0.01" id="saldo_anterior" class="form-control form-control-sm" name="saldo_anterior" placeholder="" value="'.$guia->saldo_anterior.'">
                            </div>
                        </div>
                    </div>

                    <!-- Cantidad Despachada -->
                    <div class="col-sm-4">
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="cantidad_despachada" class="col-form-label">Cantidad Despachada: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="number" step="0.01" id="cantidad_despachada" class="form-control form-control-sm" name="cantidad_despachada" placeholder="" value="'.$guia->cantidad_despachada.'">
                            </div>
                        </div>
                    </div>

                    <!-- Saldo Restante -->
                    <div class="col-sm-4">
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="saldo_restante" class="col-form-label">Saldo Restante: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="number" step="0.01" id="saldo_restante" class="form-control form-control-sm" name="saldo_restante" placeholder="" value="'.$guia->saldo_restante.'">
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>

                <div class="row d-flex align-items-center">
                    <div class="col-sm-6 px-4">
                        <!-- modelo del vehiculo -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required value="'.$guia->modelo_vehiculo.'">
                            </div>
                        </div>

                        <!-- Nombre del conductor  -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required value="'.$guia->nombre_conductor.'">
                            </div>
                        </div>

                        <!-- telefono del conductor  -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required value="'.$guia->tlf_conductor.'">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 px-4">
                        <!-- placa -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="placa" class="col-form-label">Placa: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required value="'.$guia->placa.'">
                            </div>
                        </div>

                        <!-- ci conductor -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required value="'.$guia->ci_conductor.'">
                            </div>
                        </div>

                        <!-- capacidad del vehiculo -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="capacidad_vehiculo" class="col-form-label">Capacidad del Vehículo: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="capacidad_vehiculo" class="form-control form-control-sm" name="capacidad_vehiculo" placeholder="" required value="'.$guia->capacidad_vehiculo.'">
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de Circulación</p>
                
                <div class="row">
                    <div class="col-sm-6 px-4">
                        <!-- hora de Salida -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="hora_salida" class="col-form-label">Hora de Salida: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required value="'.$guia->hora_salida.'">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 px-4">
                        <!-- hora de llegada -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-4">
                                <label for="hora_llegada" class="col-form-label">Hora de Llegada: <span style="color:red">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required value="'.$guia->hora_llegada.'">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- otros datos -->
                <div class="row px-2">
                    <div class="col-sm-3">
                        <!-- nro factura -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-6">
                                <label for="factura" class="col-form-label">Nro° Factura: </label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" value="'.$guia->nro_factura.'">
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- anulada -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-5">
                                <label for="" class="col-form-label">¿Anulada?: <span style="color:red">*</span></label>
                            </div>
                            '.$html_anulada.'
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- motivo de anulacion -->
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-3">
                                <label for="motivo_anulada" class="col-form-label">Motivo: </label>
                            </div>
                            <div class="col-9">
                                <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" value="'.$guia->motivo.'">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end fs-5 fw-bold text-muted py-2">
                    <span class=" text-danger">Nro° Control </span><span id="nro_control_view">'.$guia->nro_control.'</span>
                </div>

                <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                <div class="d-flex justify-content-center mt-3 mb-3" >
                    <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm me-3" id="btn_guardar_guia">Guardar</button>
                </div>
            </form>';

                return response($html);
            }


        }else{
            return response('Error al editar la guía.');
        }
    }


    public function editar_guia(Request $request){

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
        $nro_guia = $request->post('nro_guia');
        $fecha = $request->post('fecha_emision');
        $tipo_guia = $request->post('tipo_guia');
        $razon_dest = $request->post('razon_dest');
        $ci_dest = $request->post('ci_dest');
        $tlf_dest = $request->post('tlf_dest');
        $municipio = $request->post('municipio');
        $destino = $request->post('destino');

        $id_mineral = $request->post('mineral');
        $unidad_medida = $request->post('unidad_medida');
        $cantidad = $request->post('cantidad_facturada');
        $fecha_facturacion = $request->post('fecha_facturacion');
        $saldo_anterior = $request->post('saldo_anterior');
        $cantidad_despachada = $request->post('cantidad_despachada');
        $saldo_restante = $request->post('saldo_restante');

        $modelo_vehiculo = $request->post('modelo');
        $placa = $request->post('placa');
        $nombre_conductor = $request->post('nombre_conductor');
        $ci_conductor = $request->post('ci_conductor');
        $tlf_conductor = $request->post('tlf_conductor');
        $capacidad_vehiculo = $request->post('capacidad_vehiculo');

        $hora_salida = $request->post('hora_salida');
        $hora_llegada = $request->post('hora_llegada');
        $nro_factura = $request->post('nro_factura');
        $anulada = $request->post('anulada');
        $motivo = $request->post('motivo');


        $update = DB::table('control_guias')->where('nro_guia','=',$nro_guia)
                                            ->update(['fecha' => $fecha,
                                                    'tipo_guia' => $tipo_guia,
                                                    'razon_destinatario' => $razon_dest,
                                                    'ci_destinatario' => $ci_dest,
                                                    'tlf_destinatario' => $tlf_dest,
                                                    'municipio_parroquia_destino' => $municipio,
                                                    'destino' => $destino,
                                                    'nro_factura' => $nro_factura,
                                                    'fecha_facturacion' => $fecha_facturacion,
                                                    'id_mineral' => $id_mineral,
                                                    'unidad_medida' => $unidad_medida,
                                                    'cantidad_facturada' => $cantidad,
                                                    'saldo_anterior' => $saldo_anterior,
                                                    'cantidad_despachada' => $cantidad_despachada,
                                                    'saldo_restante' => $saldo_restante,
                                                    'modelo_vehiculo' => $modelo_vehiculo,
                                                    'placa' => $placa,
                                                    'nombre_conductor' => $nombre_conductor,
                                                    'ci_conductor' => $ci_conductor,
                                                    'tlf_conductor' => $tlf_conductor,
                                                    'capacidad_vehiculo' => $capacidad_vehiculo,
                                                    'hora_salida' => $hora_salida,
                                                    'hora_llegada' => $hora_llegada,
                                                    'anulada' => $anulada,
                                                    'motivo' => $motivo
                                                    ]);

        if ($update) {
            return response()->json(['success' => true]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $nro_guia = $request->post('guia');

        $delete = DB::table('control_guias')->where('nro_guia', '=', $nro_guia)->delete();
        if($delete){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
