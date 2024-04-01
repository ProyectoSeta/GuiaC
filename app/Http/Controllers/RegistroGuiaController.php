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
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
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
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;

        $html = '';
        $opction_canteras = '';
 
        ///////////// buscar si el usuario a registrado guias anteriormente
        $conteo = DB::table('control_guias')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->get();
        if ($conteo) {
            foreach ($conteo as $c) {
                if ($c->total == 0) {
                    ///////EL USUARIO TODAVI NO HA REGISTRADO NINGUNA GUÍA
                    $talonario = DB::table('talonarios')->where('id_sujeto','=',$id_sp)->first();
                    if ($talonario) {
                        $idTalonario = $talonario->id_talonario;
                        $nro_guia_next = $talonario->desde;
                        $length = 6;
                        $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia_next, - $length);

                        ////////buscar el numero de control correspondiente a este nro guia
                        $control = DB::table('numero_controls')->select('nro_control')->where('nro_guia','=',$nro_guia_next)->first();
                        if ($control) {
                            $nro_control = $control->nro_control;

                            ////////////////buscar las canteras asociadas a este contribuyente
                            $canteras = DB::table('canteras')->select('id_cantera','nombre')
                                                                ->where('id_sujeto','=',$id_sp)
                                                                ->where('status','=','Verificada')->get();
                            if ($canteras) {
                                foreach ($canteras as $cantera) {
                                    $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                                }

                                $html = '<form id="form_registrar_guia" method="post" onsubmit="event.preventDefault(); registrarGuia()">
                                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                                <span class="text-danger">Nro° Guía </span><span>'.$formato_nro_guia.'</span>
                                            </div>
                                            
                                            <input type="hidden" name="id_talonario" value="'.$idTalonario.'" required>
                                            <input type="hidden" name="nro_guia" value="'.$nro_guia_next.'" required>
                                            <input type="hidden" name="nro_control" value="'.$nro_control.'" required>

                                            <div class="row px-3">
                                                <div class="col-sm-4">
                                                    <!-- fecha de emision -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-5">
                                                            <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" required>
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
                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_guia" required>
                                                                <option value="Salida">Salida</option>
                                                                <option value="Entrada">Entrada</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <!-- cantera -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <select class="form-select form-select-sm select_cantera" name="cantera" required>
                                                                <option>...</option>
                                                                '.$opction_canteras.'
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- direccion de la cantera -->
                                            <div class="px-3">
                                                <div class="row g-3 align-items-center mb-2">
                                                    <div class="col-3">
                                                        <label for="" class="col-form-label">Dirección:</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <p class="text-muted fst-italic text-start" id="direccion_cantera"></p>
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
                                                            <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required>
                                                        </div>
                                                    </div>
                    
                                                    <!-- telefono del destinatario  -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required>
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
                                                            <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" required>
                                                        </div>
                                                    </div>
                    
                                                    <!-- destino -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="destino" class="col-form-label">Destino: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="destino" class="form-control form-control-sm" name="destino" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>
                    
                                            <div class="row px-3">
                                                <div class="col-sm-5">
                                                    <!-- mineral no metalico -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-5">
                                                            <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required>
                                                                <option selected>...</option>
                                                                
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <!-- cantidad -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-4">
                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" required>
                                                                <option value="Toneladas">Toneladas</option>
                                                                <option value="Metros cúbicos">Metros Cúbicos</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" id="cantidad" class="form-control form-control-sm" name="cantidad" placeholder="Cantidad" required>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>
                    
                                            <div class="row">
                                                <div class="col-sm-6 px-4">
                                                    <!-- modelo del vehiculo -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required>
                                                        </div>
                                                    </div>
                    
                                                    <!-- Nombre del conductor  -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required>
                                                        </div>
                                                    </div>
                    
                                                    <!-- telefono del conductor  -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required>
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
                                                            <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required>
                                                        </div>
                                                    </div>
                    
                                                    <!-- ci conductor -->
                                                    <div class="row g-3 align-items-center mb-2">
                                                        <div class="col-4">
                                                            <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required>
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
                                                            <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required>
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
                                                            <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required>
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
                                                            <label for="factura" class="col-form-label">Nro° Factura: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" required>
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
                                                                <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si">
                                                                <label class="form-check-label" for="anulado_si">
                                                                    Si
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No" >
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
                                                            <label for="motivo_anulada" class="col-form-label">Motivo: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                                <span class=" text-danger">Nro° Control </span><span>'.$nro_control.'</span>
                                            </div>
                    
                                            <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                                <button type="submit" class="btn btn-primary btn-sm me-3">Guardar</button>
                                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                </form>';
                                
                                return response($html);       
                                
                            }else{
                                return response('Error al traer correlativo.');
                            }
                            
                        }else{
                            return response('Error al traer correlativo.');
                        }
                    }else{
                        return response('Error al traer correlativo.');
                    }

                }else{
                    //////EL USUARIO YA HA HECHO REGISTRO DE GUIAS PREVIAMENTE

                    /////consulta la ultima guia que registro el usuario
                    $consulta = DB::table('control_guias')->where('id_sujeto','=',$id_sp)->latest('correlativo')->first();
                    if ($consulta) {
                        $ultimo_nro_guia = $consulta->nro_guia;
                        $ultimo_id_talonario = $consulta->id_talonario;
                        
                        ////////////comprobar si el ultimo numero de guia registrado es la ultima guia del talonario
                        $comprobar = DB::table('talonarios')->where('id_talonario','=',$ultimo_id_talonario)->first();
                        if ($comprobar) {
                            if ($ultimo_nro_guia < $comprobar->hasta) {
                                //////////////TODAVIA QUEDAN GUIAS EN EL TALONARIO
                                $nro_guia_next = $ultimo_nro_guia + 1 ;
                                $length = 6;
                                $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia_next, - $length);
                                //////////buscar numero de control
                                $control = DB::table('numero_controls')->select('nro_control')->where('nro_guia','=',$nro_guia_next)->first();
                                if ($control){
                                    $nro_control = $control->nro_control;
                                    ////////////////buscar las canteras asociadas a este contribuyente
                                    $canteras = DB::table('canteras')->select('id_cantera','nombre')
                                                                        ->where('id_sujeto','=',$id_sp)
                                                                        ->where('status','=','Verificada')->get();
                                    if ($canteras){
                                        foreach ($canteras as $cantera) {
                                            $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                                        }

                                        $html = '<form id="form_registrar_guia" method="post" onsubmit="event.preventDefault(); registrarGuia()">
                                                    <div class="text-end fs-5 fw-bold text-muted py-2">
                                                        <span class="text-danger">Nro° Guía </span><span>'.$formato_nro_guia.'</span>
                                                    </div>
                                                    
                                                    <input type="hidden" name="id_talonario" value="'.$ultimo_id_talonario.'" required>
                                                    <input type="hidden" name="nro_guia" value="'.$nro_guia_next.'" required>
                                                    <input type="hidden" name="nro_control" value="'.$nro_control.'" required>

                                                    <div class="row px-3">
                                                        <div class="col-sm-4">
                                                            <!-- fecha de emision -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-5">
                                                                    <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" required>
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
                                                                    <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_guia" required>
                                                                        <option value="Salida">Salida</option>
                                                                        <option value="Entrada">Entrada</option>
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <!-- cantera -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <select class="form-select form-select-sm select_cantera" name="cantera" required>
                                                                        <option>...</option>
                                                                        '.$opction_canteras.'
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- direccion de la cantera -->
                                                    <div class="px-3">
                                                        <div class="row g-3 align-items-center mb-2">
                                                            <div class="col-3">
                                                                <label for="" class="col-form-label">Dirección:</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <p class="text-muted fst-italic text-start"  id="direccion_cantera"></p>
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
                                                                    <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required>
                                                                </div>
                                                            </div>
                            
                                                            <!-- telefono del destinatario  -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required>
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
                                                                    <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" required>
                                                                </div>
                                                            </div>
                            
                                                            <!-- destino -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="destino" class="col-form-label">Destino: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="destino" class="form-control form-control-sm" name="destino" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>
                            
                                                    <div class="row px-3">
                                                        <div class="col-sm-5">
                                                            <!-- mineral no metalico -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-5">
                                                                    <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required>
                                                                        <option selected>...</option>
                                                                        
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <!-- cantidad -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" required>
                                                                        <option value="Toneladas">Toneladas</option>
                                                                        <option value="Metros cúbicos">Metros Cúbicos</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4">
                                                                    <input type="text" id="cantidad" class="form-control form-control-sm" name="cantidad" placeholder="Cantidad" required>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>
                            
                                                    <div class="row">
                                                        <div class="col-sm-6 px-4">
                                                            <!-- modelo del vehiculo -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required>
                                                                </div>
                                                            </div>
                            
                                                            <!-- Nombre del conductor  -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required>
                                                                </div>
                                                            </div>
                            
                                                            <!-- telefono del conductor  -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required>
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
                                                                    <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required>
                                                                </div>
                                                            </div>
                            
                                                            <!-- ci conductor -->
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required>
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
                                                                    <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required>
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
                                                                    <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required>
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
                                                                    <label for="factura" class="col-form-label">Nro° Factura: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" required>
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
                                                                        <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si">
                                                                        <label class="form-check-label" for="anulado_si">
                                                                            Si
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No" >
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
                                                                    <label for="motivo_anulada" class="col-form-label">Motivo: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="text-end fs-5 fw-bold text-muted py-2">
                                                        <span class=" text-danger">Nro° Control </span><span>'.$nro_control.'</span>
                                                    </div>
                            
                                                    <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                                                    <div class="d-flex justify-content-center mt-3 mb-3" >
                                                        <button type="submit" class="btn btn-primary btn-sm me-3">Guardar</button>
                                                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                                    </div>
                                        </form>';
                                        
                                        return response($html);

                                    }else{
                                        return response('Error al traer correlativo.');
                                    }
                                }else{
                                    return response('Error al traer correlativo.');
                                }
                            }else{
                                ////////////ULTIMA GUIA DEL TALONARIO

                                ////////////buscar el siguiente talonario correspondiente al sujeto pasivo
                                $buscar = DB::table('talonarios')->where([
                                                                    ['id_talonario','>',$ultimo_id_talonario],
                                                                    ['id_sujeto','=',$id_sp]
                                                                    ])->orderBy('id_talonario','asc')->first();
                                if ($buscar) {
                                    if ($buscar != '') {
                                        ////con resultado: hay un siguiente talonario
                                        $nro_guia_next = $buscar->desde;
                                        $idTalonario = $buscar->id_talonario;
                                        $length = 6;
                                        $formato_nro_guia = substr(str_repeat(0, $length).$nro_guia_next, - $length);
                                        //////////buscar numero de control
                                        $control = DB::table('numero_controls')->select('nro_control')->where('nro_guia','=',$nro_guia_next)->first();
                                        if ($control){
                                            $nro_control = $control->nro_control;
                                            ////////////////buscar las canteras asociadas a este contribuyente
                                            $canteras = DB::table('canteras')->select('id_cantera','nombre')
                                                                                ->where('id_sujeto','=',$id_sp)
                                                                                ->where('status','=','Verificada')->get();
                                            if ($canteras){
                                                foreach ($canteras as $cantera) {
                                                    $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                                                }

                                                $html = '<form id="form_registrar_guia" method="post" onsubmit="event.preventDefault(); registrarGuia()">
                                                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                                                <span class="text-danger">Nro° Guía </span><span>'.$formato_nro_guia.'</span>
                                                            </div>
                                                            
                                                            <input type="hidden" name="id_talonario" value="'.$idTalonario.'" required>
                                                            <input type="hidden" name="nro_guia" value="'.$nro_guia_next.'" required>
                                                            <input type="hidden" name="nro_control" value="'.$nro_control.'" required>

                                                            <div class="row px-3">
                                                                <div class="col-sm-4">
                                                                    <!-- fecha de emision -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-5">
                                                                            <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-7">
                                                                            <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" required>
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
                                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_guia" required>
                                                                                <option value="Salida">Salida</option>
                                                                                <option value="Entrada">Entrada</option>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <!-- cantera -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <select class="form-select form-select-sm select_cantera" name="cantera" required>
                                                                                <option>...</option>
                                                                                '.$opction_canteras.'
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- direccion de la cantera -->
                                                            <div class="px-3">
                                                                <div class="row g-3 align-items-center mb-2">
                                                                    <div class="col-3">
                                                                        <label for="" class="col-form-label">Dirección:</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <p class="text-muted fst-italic text-start"  id="direccion_cantera"></p>
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
                                                                            <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <!-- telefono del destinatario  -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required>
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
                                                                            <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" required>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <!-- destino -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="destino" class="col-form-label">Destino: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="destino" class="form-control form-control-sm" name="destino" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>
                                    
                                                            <div class="row px-3">
                                                                <div class="col-sm-5">
                                                                    <!-- mineral no metalico -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-5">
                                                                            <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-7">
                                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required>
                                                                                <option selected>...</option>
                                                                                
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7">
                                                                    <!-- cantidad -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" required>
                                                                                <option value="Toneladas">Toneladas</option>
                                                                                <option value="Metros cúbicos">Metros Cúbicos</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <input type="text" id="cantidad" class="form-control form-control-sm" name="cantidad" placeholder="Cantidad" required>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>
                                    
                                                            <div class="row">
                                                                <div class="col-sm-6 px-4">
                                                                    <!-- modelo del vehiculo -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <!-- Nombre del conductor  -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <!-- telefono del conductor  -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required>
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
                                                                            <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <!-- ci conductor -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-4">
                                                                            <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required>
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
                                                                            <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required>
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
                                                                            <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required>
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
                                                                            <label for="factura" class="col-form-label">Nro° Factura: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" required>
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
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si">
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
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <!-- motivo de anulacion -->
                                                                    <div class="row g-3 align-items-center mb-2">
                                                                        <div class="col-3">
                                                                            <label for="motivo_anulada" class="col-form-label">Motivo: <span style="color:red">*</span></label>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                                                <span class=" text-danger">Nro° Control </span><span>'.$nro_control.'</span>
                                                            </div>
                                    
                                                            <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                                                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                                                <button type="submit" class="btn btn-primary btn-sm me-3">Guardar</button>
                                                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                                            </div>
                                                </form>';
                                                
                                                return response($html);
                                            }else{
                                                return response('Error al traer correlativo.');
                                            }
                                        }else{
                                            return response('Error al traer correlativo.');
                                        }
 
                                    }else{
                                        ////sin resultado: el usuario no ha solicitado mas talonarios
                                        $html = '<div class="text-center text-muted my-4 pb-4">
                                                    <i class="bx bx-error-circle bx-tada fs-1" ></i>
                                                    <h4>Discupe, debe solicitar una nueva guia.</h4>
                                                </div>';
                                        return response($html);

                                    }
                                }else{
                                    ////sin resultado: el usuario no ha solicitado mas talonarios
                                    $html = '<div class="text-center text-muted my-4 pb-4">
                                    <i class="bx bx-error-circle bx-tada fs-1" ></i>
                                    <h4>Discupe, debe solicitar una nueva guia.</h4>
                                    </div>';
                                    return response($html);

                                }
                            }
                        }else{
                            return response('Error al traer correlativo.');
                        }
                    }else{
                        return response('Error al traer correlativo.');
                    }







                    return response('Hay');

                }
            }
        }else {
            return response('Error al registrar la Guía.');
        }



  

    }




    public function cantera(Request $request){
        $idCantera = $request->post('cantera');
        $minerales = '';
        // $minerales .= '<option>...</option>';

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

        $cantera = DB::table('canteras')->select('direccion')->where('id_cantera','=',$idCantera)->first();
        if ($cantera) {
            $direccion = $cantera->direccion;
        }


        return response()->json(['minerales' => $minerales, 'direccion' => $direccion]);
        // return response($minerales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;

        $id_talonario = $request->post('id_talonario');
        $id_sujeto = $id_sp;
        $nro_guia = $request->post('nro_guia');
        $nro_control = $request->post('nro_control');
        $fecha = $request->post('fecha_emision');
        $tipo_guia = $request->post('tipo_guia');
        $id_cantera = $request->post('cantera');
        $razon_dest = $request->post('razon_dest');
        $ci_dest = $request->post('ci_dest');
        $tlf_dest = $request->post('tlf_dest');
        $destino = $request->post('destino');
        $id_mineral = $request->post('mineral');
        $unidad_medida = $request->post('unidad_medida');
        $cantidad = $request->post('cantidad');
        $modelo_vehiculo = $request->post('modelo');
        $placa = $request->post('placa');
        $nombre_conductor = $request->post('nombre_conductor');
        $ci_conductor = $request->post('ci_conductor');
        $tlf_conductor = $request->post('tlf_conductor');
        $hora_salida = $request->post('hora_salida');
        $hora_llegada = $request->post('hora_llegada');
        $nro_factura = $request->post('nro_factura');
        $anulada = $request->post('anulada');
        $motivo = $request->post('motivo');

        $insert = DB::table('control_guias')->insert(['id_talonario' => $id_talonario, 
                                                    'id_sujeto'=>$id_sujeto,
                                                    'nro_guia' => $nro_guia, 
                                                    'nro_control' => $nro_control,
                                                    'fecha' => $fecha,
                                                    'tipo_guia' => $tipo_guia,
                                                    'id_cantera' => $id_cantera,
                                                    'razon_destinatario' => $razon_dest,
                                                    'ci_destinatario' => $ci_dest,
                                                    'tlf_destinatario' => $tlf_dest,
                                                    'destino' => $destino,
                                                    'id_mineral' => $id_mineral,
                                                    'unidad_medida' => $unidad_medida,
                                                    'cantidad' => $cantidad,
                                                    'modelo_vehiculo' => $modelo_vehiculo,
                                                    'placa' => $placa,
                                                    'nombre_conductor' => $nombre_conductor,
                                                    'ci_conductor' => $ci_conductor,
                                                    'tlf_conductor' => $tlf_conductor,
                                                    'hora_salida' => $hora_salida,
                                                    'hora_llegada' => $hora_llegada,
                                                    'nro_factura' => $nro_factura,
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
// return response($nro_guia);
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
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

                /////////////////info cantera(s)
                $opction_canteras = '';
                $canteras = DB::table('canteras')->select('id_cantera','nombre')->where('id_sujeto','=',$id_sp)->where('status','=','Verificada')->get();
                if ($canteras) {
                    $opction_canteras .= '<option  value="'.$guia->id_cantera.'">'.$guia->nombre.'</option>';
                    
                    foreach ($canteras as $cantera) {
                        if ($cantera->id_cantera != $guia->id_cantera) {
                            $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                        }
                    }
                }else{
                    return response('Error al editar la guía.');
                }
                
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
                
                $cantera_dir = DB::table('canteras')->select('direccion')->where('id_cantera','=',$id_cantera)->first();
                if ($cantera_dir) {
                    $direccion = $cantera_dir->direccion;
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


                /////////////////info tipo de guia
                $html_tipo = '';
                if ($guia->tipo_guia == 'Entrada') {
                    $html_tipo = '<option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>';
                }else{
                    $html_tipo = '<option value="Salida">Salida</option>
                                <option value="Entrada">Entrada</option>';
                }


                $html = '<form id="form_editar_guia" method="post" onsubmit="event.preventDefault(); editarGuia()">
                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                <span class="text-danger">Nro° Guía </span><span>'.$formato_nro_guia.'</span>
                            </div>
                            
                            <input type="hidden" name="id_talonario" value="'.$guia->id_talonario.'" required>
                            <input type="hidden" name="nro_guia" value="'.$guia->nro_guia.'" required>
                            <input type="hidden" name="nro_control" value="'.$guia->nro_control.'" required>

                            <div class="row px-3">
                                <div class="col-sm-4">
                                    <!-- fecha de emision -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-5">
                                            <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-7">
                                            <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" value="'.$guia->fecha.'" required>
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
                                            <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_guia" required>
                                                '.$html_tipo.'
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- cantera -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-select form-select-sm select_cantera" name="cantera" required>
                                                '.$opction_canteras.'
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- direccion de la cantera -->
                            <div class="px-3">
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-3">
                                        <label for="" class="col-form-label">Dirección:</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="text-muted fst-italic text-start"  id="direccion_cantera">'.$direccion.'</p>
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
                                            <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." value="'.$guia->razon_destinatario.'" required>
                                        </div>
                                    </div>

                                    <!-- telefono del destinatario  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" value="'.$guia->tlf_destinatario.'" required>
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
                                            <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: J00000000" value="'.$guia->ci_destinatario.'" required>
                                        </div>
                                    </div>

                                    <!-- destino -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="destino" class="col-form-label">Destino: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="destino" class="form-control form-control-sm" name="destino" value="'.$guia->destino.'" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>

                            <div class="row px-3">
                                <div class="col-sm-5">
                                    <!-- mineral no metalico -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-5">
                                            <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-7">
                                            <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" id="select_minerales" required>
                                                '.$minerales_options.'                                            
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <!-- cantidad -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-select form-select-sm" aria-label="Small select example" name="unidad_medida" required>
                                                '.$unidad_medida.'
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" id="cantidad" class="form-control form-control-sm" name="cantidad" placeholder="Cantidad" value="'.$guia->cantidad.'" required>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>

                            <div class="row">
                                <div class="col-sm-6 px-4">
                                    <!-- modelo del vehiculo -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" value="'.$guia->modelo_vehiculo.'" required>
                                        </div>
                                    </div>

                                    <!-- Nombre del conductor  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" value="'.$guia->nombre_conductor.'" required>
                                        </div>
                                    </div>

                                    <!-- telefono del conductor  -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" value="'.$guia->tlf_conductor.'" required>
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
                                            <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" value="'.$guia->placa.'" required>
                                        </div>
                                    </div>

                                    <!-- ci conductor -->
                                    <div class="row g-3 align-items-center mb-2">
                                        <div class="col-4">
                                            <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" value="'.$guia->ci_conductor.'" required>
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
                                            <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" value="'.$guia->hora_salida.'" required>
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
                                            <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" value="'.$guia->hora_llegada.'" required>
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
                                            <label for="factura" class="col-form-label">Nro° Factura: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" value="'.$guia->nro_factura.'" required>
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
                                            <label for="motivo_anulada" class="col-form-label">Motivo: <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            '.$html_motivo.'
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end fs-5 fw-bold text-muted py-2">
                                <span class=" text-danger">Nro° Control </span><span>'.$guia->nro_control.'</span>
                            </div>

                            <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                <button type="submit" class="btn btn-primary btn-sm me-3">Guardar</button>
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
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
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;

        $id_talonario = $request->post('id_talonario');
        $id_sujeto = $id_sp;
        $nro_guia = $request->post('nro_guia');
        $nro_control = $request->post('nro_control');
        $fecha = $request->post('fecha_emision');
        $tipo_guia = $request->post('tipo_guia');
        $id_cantera = $request->post('cantera');
        $razon_dest = $request->post('razon_dest');
        $ci_dest = $request->post('ci_dest');
        $tlf_dest = $request->post('tlf_dest');
        $destino = $request->post('destino');
        $id_mineral = $request->post('mineral');
        $unidad_medida = $request->post('unidad_medida');
        $cantidad = $request->post('cantidad');
        $modelo_vehiculo = $request->post('modelo');
        $placa = $request->post('placa');
        $nombre_conductor = $request->post('nombre_conductor');
        $ci_conductor = $request->post('ci_conductor');
        $tlf_conductor = $request->post('tlf_conductor');
        $hora_salida = $request->post('hora_salida');
        $hora_llegada = $request->post('hora_llegada');
        $nro_factura = $request->post('nro_factura');
        $anulada = $request->post('anulada');
        $motivo = $request->post('motivo');

        $update = DB::table('control_guias')->where('nro_guia','=',$nro_guia)
                                            ->update(['id_talonario' => $id_talonario, 
                                                    'id_sujeto'=>$id_sujeto,
                                                    'fecha' => $fecha,
                                                    'tipo_guia' => $tipo_guia,
                                                    'id_cantera' => $id_cantera,
                                                    'razon_destinatario' => $razon_dest,
                                                    'ci_destinatario' => $ci_dest,
                                                    'tlf_destinatario' => $tlf_dest,
                                                    'destino' => $destino,
                                                    'id_mineral' => $id_mineral,
                                                    'unidad_medida' => $unidad_medida,
                                                    'cantidad' => $cantidad,
                                                    'modelo_vehiculo' => $modelo_vehiculo,
                                                    'placa' => $placa,
                                                    'nombre_conductor' => $nombre_conductor,
                                                    'ci_conductor' => $ci_conductor,
                                                    'tlf_conductor' => $tlf_conductor,
                                                    'hora_salida' => $hora_salida,
                                                    'hora_llegada' => $hora_llegada,
                                                    'nro_factura' => $nro_factura,
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
