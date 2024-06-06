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

        $solicitudes = DB::table('solicituds')->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('clasificacions', 'solicituds.estado', '=', 'clasificacions.id_clasificacion')
                                            ->select('solicituds.*','canteras.nombre','clasificacions.nombre_clf')
                                            ->where('solicituds.id_sujeto', $id_sp)->get();

        // var_dump($solicitudes);
        return view('solicitud',compact('solicitudes'));

    }

  

    /**
     * Show the form for creating a new resource.
     */
    public function new_solicitud()
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $opction_canteras = '';
        $canteras = DB::table('canteras')->select('id_cantera','nombre')->where('id_sujeto','=',$id_sp)
                                                                        ->where('status','=','Verificada')->get();
        if ($canteras) {
            foreach ($canteras as $cantera) {
                $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
            }
            $fecha_actual = date('Y-m-d');
            $html = '<div class="text-center mb-2">
                        <span class="fs-6 fw-bold text-navy">DATOS DE LA SOLICITUD</span>
                    </div>
                    <form id="form_generar_solicitud" method="post" onsubmit="event.preventDefault(); generarSolicitud();">
                        
                        <div class="row mb-2">
                            <div class="col-5">
                                <label class="form-label" for="rif">Cantera a la que va dirigido el Talonario</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-7">
                                <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                    '.$opction_canteras.'
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="tipo">Contenido del Talonario</label>
                                <input type="text" class="form-control form-control-sm mb-3 text-center" name="tipo" id="tipo" value="50 guías" readonly>
                            </div>
                            <div class="col-6">
                                <label for="cant_talonario">Cantidad <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-3" type="number" name="cantidad" id="cantidad" min="1" required>
                            </div>
                        </div> 
                        
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary btn-sm" id="calcular">Calular</button>
                        </div>

                        <p class="fs-6 fw-bold text-navy text-center mt-4 mb-2">DATOS DEL PAGO</p>

                        <p class="text-justify mb-3 text-muted" style="font-size:13px"><span class="fw-bold">IMPORTANTE: </span>Amigo contribuyente, 
                        recuerde que debe hacer el pago de los talonarios el mismo día que este generando la solicitud, ya que 
                        el monto total a pagar puede oscilar debido a la naturaleza cambiante del precio del UCD.</p>

                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body d-flex flex-column text-center">
                                    <h5 class="card-title fw-bold">Cuenta Bancaria</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Receptora del Pago de Impuestos</h6>

                                    <div class="card-text text-center mt-3">
                                        <p class="mb-1 text-navy fw-bold">BANCO NACIONAL DE CRÉDITO</p>
                                        <p class="mb-1 fw-bold">0191-0080-45-2180064618</p>
                                        <p class="mb-1">El pago debe efectuarse a nombre de:</p>
                                        <p class="mb-1 fw-bold">Gobierno Bolivariano de Aragua</p>
                                        <p class="mb-1 fw-bold">R.I.F.: G-20000149-6</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <table class="table d-flex justify-content-center table-borderless table-sm">
                            <tr class="table-warning fs-6">
                                <th>TOTAL A PAGAR</th> 
                                <td class="total_pagar" class="text-end ps-3">0 Bs.</td>
                            </tr>
                        </table>

                        <input id="id_ucd" name="id_ucd" type="hidden" value="" required>

                        <label for="banco_emisor">Banco emisor <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm mb-3" id="banco_emisor" aria-label="Default select example" name="banco_emisor" disabled required>
                            <option value="BANCO DE VENEZUELA">BANCO DE VENEZUELA</option>
                            <option value="100% BANCO">100% BANCO</option>
                            <option value="BANCAMIGA BANCO MICROFINANCIERO">BANCAMIGA BANCO MICROFINANCIERO</option>
                            <option value="BANCARIBE">BANCARIBE</option>
                            <option value="BANCO ACTIVO">BANCO ACTIVO</option>
                            <option value="BANCO AGRICOLA DE VENEZUELA">BANCO AGRICOLA DE VENEZUELA</option>
                            <option value="BANCO BICENTENARIO DEL PUEBLO">BANCO BICENTENARIO DEL PUEBLO</option>
                            <option value="BANCO CARONI">BANCO CARONI</option>
                            <option value="BANCO DEL TESORO">BANCO DEL TESORO</option>
                            <option value="BANCO EXTERIOR">BANCO EXTERIOR</option>
                            <option value="BANCO FONDO COMUN">BANCO FONDO COMUN</option>
                            <option value="BANCO INTERNACIONAL DE DESARROLLO">BANCO INTERNACIONAL DE DESARROLLO</option>
                            <option value="BANCO MERCANTIL<">BANCO MERCANTIL</option>
                            <option value="BANCO NACIONAL DE CREDITO">BANCO NACIONAL DE CREDITO</option>
                            <option value="BANCO PLAZA">BANCO PLAZA</option>
                            <option value="BANCO SOFITASA">BANCO SOFITASA</option>
                            <option value="BANCO VENEZOLANO DE CREDITO">BANCO VENEZOLANO DE CREDITO</option>
                            <option value="BANCRECER">BANCRECER</option>
                            <option value="BANESCO">BANESCO</option>
                            <option value="BANFANB">BANFANB</option>
                            <option value="BANGENTE">BANGENTE</option>
                            <option value="BANPLUS">BANPLUS</option>
                            <option value="BBVA PROVINCIAL">BBVA PROVINCIAL</option>
                            <option value="DELSUR BANCO UNIVERSAL>DELSUR BANCO UNIVERSAL</option>
                            <option value="MI BANCO">MI BANCO</option>
                            <option value="N58 BANCO DIGITAL BANCO MICROFINANCIERO">N58 BANCO DIGITAL BANCO MICROFINANCIERO</option>
                        </select>

                        <label for="nro_referencia">No. Referencia <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm mb-3" id="nro_referencia" name="nro_referencia" type="number" required disabled> 
                        
                        <label for="banco_receptor">Banco receptor <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm mb-3" id="banco_receptor" aria-label="Default select example" name="banco_receptor" disabled required>
                            <option value="BANCO NACIONAL DE CREDITO">BANCO NACIONAL DE CREDITO</option>
                        </select>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="fecha_emision">Fecha de Emisión <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-2" id="fecha_emision" name="fecha_emision" type="date" value="'.$fecha_actual.'" required readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="monto_trans">Monto Transferido <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" step="0.01" id="monto_trans" name="monto_trans" type="number" required disabled>
                            </div>
                        </div>

                        <label for="ref_pago">Referencia del Pago <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm" id="ref_pago" name="ref_pago" type="file" disabled> 
                        <p class="text-muted text-end mt-2"><span style="color:red">*</span> Campos requeridos.</p>

                        <table class="table d-flex justify-content-center table-borderless table-sm my-4">
                            <tr>
                                <th>UCD</th>
                                <td id="total_ucd" class="text-end">0</td>
                            </tr>
                            <tr>
                                <th>Precio del día</th>
                                <td id="precio_ucd" class="text-end">0</td>
                            </tr>
                            <tr class="table-warning fs-6">
                                <th>TOTAL A PAGAR</th> 
                                <td class="total_pagar" class="text-end ps-3">0 Bs.</td>
                            </tr>
                        </table>
                        
                        <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Notas: </span><br>
                            <span class="fw-bold">1. </span>Cada Guía tiene un valor de <span class="fw-bold">cinco (5) UCD</span> (Unidad de Cuenta Dinámica).<br>
                            <span class="fw-bold">2. </span>Solo podrá eligir las canteras que hayan sido verificadas previamente.
                        </p>

                        <div class="d-flex justify-content-center mt-3 mb-3" >
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar" disabled>Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_solicitud" disabled>Realizar solicitud</button>
                        </div>
                    </form>';

            return response($html);

        }else{
            return response('Error al traer las canteras verificadas.');
        }



    }

   
    public function store(Request $request)
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto','estado')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        if ($sp->estado == 'Verificado') {
            $year = date("Y");
            $mes = date("F");

            $idCantera = $request->post('cantera');
            $cant = $request->post('cantidad');
            $tipo = 50;
            
            $id_ucd = $request->post('id_ucd');
            $banco_emisor = $request->post('banco_emisor');
            $nro_referencia = $request->post('nro_referencia');
            $banco_receptor = $request->post('banco_receptor');
            $fecha_emision = $request->post('fecha_emision');
            $monto_trans = $request->post('monto_trans');

            $ucd = DB::table('ucds')->select('valor')->where('id','=',$id_ucd)->first();
            if ($ucd) {
                $precio_ucd = $ucd->valor;
            }

            ///////////CREAR CARPETA PARA REFERENCIAS SI NO EXISTE
            if (!is_dir('../public/assets/referencias/'.$year)){   ////no existe la carpeta del año
                if(mkdir('../public/assets/referencias/'.$year, 0777)){
                    mkdir('../public/assets/referencias/'.$year.'/'.$mes, 0777);
                }
            }
            else{   /////si existe la carpeta del año
                if (!is_dir('../public/assets/referencias/'.$year.'/'.$mes)) {
                    mkdir('../public/assets/referencias/'.$year.'/'.$mes, 0777);
                }
            }

            $solicitado = $cant * $tipo;

            $limite = DB::table('limite_guias')->where('id_cantera','=',$idCantera)->first();
            if ($limite){
                $fecha_actual = date('Y-m-d');
                if ($fecha_actual > $limite->fin_periodo){
                    ////ALCANZO LA FECHA LIMITE, TOCA NUEVO PERIODO
                    $inicio = $fecha_actual;
                    $fin = date("Y-m-d", strtotime($inicio . "+ 3 months"));

                    $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => 0, 'inicio_periodo' => $inicio, 'fin_periodo' => $fin]);
                    if ($update_limite){
                        $limite_update = DB::table('limite_guias')->where('id_cantera','=',$idCantera)->first();
                        if ($limite_update){
                            $total_guias_prev = $solicitado;
                            if ($total_guias_prev > $limite_update->total_guias_periodo){

                                return response()->json(['success' => false, 'nota' => 'EXCEDE EL NÚMERO DE GUÍAS A SOLICITAR EN EL ACTUAL PERÍODO']);
                            }
                        }
                    }
                }else{
                    $total_guias_prev = $limite->total_guias_solicitadas_periodo + $solicitado;
                    if ($total_guias_prev > $limite->total_guias_periodo){
                        return response()->json(['success' => false, 'nota' => 'EXCEDE EL NÚMERO DE GUÍAS A SOLICITAR EN EL ACTUAL PERÍODO']);
                    }
                }

                if ($request->hasFile('ref_pago')) {
                    $total_ucd = $solicitado * 5;
                    $monto_total = $total_ucd * $precio_ucd;
                    $insert = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 
                                                                'id_cantera'=>$idCantera,
                                                                'id_ucd'=>$id_ucd,
                                                                'banco_emisor'=>$banco_emisor, 
                                                                'nro_referencia'=>$nro_referencia,
                                                                'banco_receptor'=>$banco_receptor, 
                                                                'fecha_emision_pago'=>$fecha_emision, 
                                                                'monto_transferido'=>$monto_trans, 
                                                                'referencia' => null,
                                                                'total_ucd'=>$total_ucd, 
                                                                'monto_total'=> $monto_total,
                                                                'estado' => 4]);
                    if ($insert) {
                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');

                        $photo         = $request->file('ref_pago');
                        $nombreimagen  = 'REF_S'.$id_solicitud.'.'.$photo->getClientOriginalExtension();
                        $ruta          = public_path('assets/referencias/'.$year.'/'.$mes.'/'.$nombreimagen);
                        $ruta_n        = 'assets/referencias/'.$year.'/'.$mes.'/'.$nombreimagen;

                        if(copy($photo->getRealPath(),$ruta)){
                            $update_solicitud = DB::table('solicituds')->where('id_solicitud', '=', $id_solicitud)->update(['referencia' => $ruta_n]);
                            $query_detalle = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]); 

                            if ($query_detalle && $update_solicitud){
                                $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => $total_guias_prev]);
                                if ($update_limite) {
                                    return response()->json(['success' => true]);
                                }else{
                                    return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                                }
                            }else{
                                return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                            }
                        }else{
                            return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                        }
                        
                    }else{
                        return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                    }
                }else{   
                    return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                }
            }


        }elseif ($sp->estado == 'Rechazado') {
            return response()->json(['success' => false, 'nota' => 'DISCULPE, NO SE PUEDE REALIZAR LA SOLICITUD YA QUE LOS PERMISOS DE SU USUARIO SE ENCUENTRAN RESTRINGIDOS.']);
        }elseif ($sp->estado == 'Verificando') {
            return response()->json(['success' => false, 'nota' => 'DISCULPE, NO SE PUEDE REALIZAR LA SOLICITUD YA QUE SU USUARIO SE ENCUENTRA EN PROCESO DE VERIFICACIÓN.']);
        }

    
    }

    public function talonarios(Request $request){
        $idSolicitud = $request->post('id');

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
        $razon = $sp->razon_social;

        $tr = '';

        $cantera = DB::table('solicituds')->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                                        ->select('solicituds.*','canteras.nombre')
                                        ->where('solicituds.id_solicitud','=',$idSolicitud)->first();
        if ($cantera) {
            $nombre_cantera = $cantera->nombre;  
        }

        $ucd = DB::table('ucds')->select('valor')->where('id','=',$cantera->id_ucd)->first();

        $formato_monto_total = number_format($cantera->monto_total, 2, ',', '.');
        $formato_monto_transferido = number_format($cantera->monto_transferido, 2, ',', '.');

        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
        if($detalles){
            foreach ($detalles as $solicitud) {
                $tr .= '<tr>
                            <td>'.$cantera->fecha.'</td>
                            <td>'.$solicitud->tipo_talonario.' Guías</td>
                            <td>'.$solicitud->cantidad.' und.</td>
                        </tr>';
            }
        }
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-beetwen">
                    <div class="ps-3" style="font-size: 14px;">
                        <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel" >'.$nombre_cantera.'</h1>
                        <span class="text-muted">'.$razon.'</span><br>
                        <span class="text-muted">'.$sp->rif_condicion.'-'.$sp->rif_nro.'</span>
                    </div>
                    <button type="button" class="btn-close pe-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4" style="font-size:14px;">
                    <h6 class="text-center mb-3 text-navy fw-bold">DETALLES DE LA SOLICITUD REALIZADA</h6>
                    <table class="table text-center">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">Emisión de Solicitud</th>
                                <th scope="col">Contenido del Talonario</th>
                                <th scope="col">Cant. de Talonarios</th>
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
                                <td>'.$cantera->total_ucd.' UCD</td>
                                <td>'.$ucd->valor.' Bs.</td>
                                <td>'.$formato_monto_total.' Bs.</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 class="text-center mb-3 text-navy fw-bold">DATOS DEL PAGO</h6>
                    <table class="table">
                        <tr>
                            <th>Banco emisor</th>
                            <td>'.$cantera->banco_emisor.'</td>
                        </tr>
                        <tr>
                            <th>No. Referencia</th>
                            <td>#'.$cantera->nro_referencia.'</td>
                        </tr>
                        <tr>
                            <th>Banco receptor</th>
                            <td>'.$cantera->banco_receptor.'</td>
                        </tr>
                        <tr>
                            <th>Fecha de emisión</th>
                            <td>'.$cantera->fecha_emision_pago.'</td>
                        </tr>
                        <tr class="table-warning">
                            <th>Monto transferido</th>
                            <td>'.$formato_monto_transferido.' Bs.</td>
                        </tr>
                    </table>

                    <p class="text-muted" style="font-size:13px"><span class="fw-bold">Nota:
                    </span> El <span class="fw-bold">Tipo de talonario </span>
                    es definido por el número de guías que contenga este. 
                </p>
                </div>';

        return response($html);
       
    }


    /**
     * Display the specified resource.
     */
    public function calcular(Request $request)
    {
        $cantidad = $request->post('cant');
        $ucd = (50 * $cantidad) * 5;

        $actual =  DB::table('ucds')->select('id', 'valor')->orderBy('id', 'desc')->first();
        $precio_ucd = $actual->valor;
        $id_ucd = $actual->id;

        $total = $ucd * $precio_ucd;
        $total = number_format($total, 2, ',', '.');

        return response()->json(['ucd' => $ucd, 'precio_ucd' => $precio_ucd, 'total' => $total, 'id_ucd' => $id_ucd]);
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
        $idCantera = $request->post('cantera');
        // return response($idCantera);

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
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

        ///////////////ELIMINAR SOLICITUD//////////////////////////
        $delete = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->delete();
        
        if($delete && $update_limite){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
