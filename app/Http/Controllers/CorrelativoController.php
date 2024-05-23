<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class CorrelativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talonarios = DB::table('talonarios')
        ->join('sujeto_pasivos', 'talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->join('canteras', 'talonarios.id_cantera', '=', 'canteras.id_cantera')
        ->select('talonarios.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
        ->get();

        return view('correlativo', compact('talonarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function talonario(Request $request)
    {
        $idTalonario = $request->post('talonario');
        $columnas = [];
        $talonarios = DB::table('talonarios')->join('canteras', 'talonarios.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('sujeto_pasivos', 'talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->select('talonarios.*', 'canteras.nombre', 'sujeto_pasivos.razon_social')
                                            ->where('talonarios.id_talonario','=', $idTalonario)->get();
        if ($talonarios) {
            $tr = '';
            foreach ($talonarios as $talonario) {
                $desde = $talonario->desde;
                $hasta = $talonario->hasta;
                $count_reportada = 0; 

                for ($i=$desde; $i <= $hasta; $i++) { 
                    $length = 6;
                    $formato_nro_guia = substr(str_repeat(0, $length).$i, - $length);
                    

                    $estado = '';
                    $query = DB::table('control_guias')->where('nro_guia','=', $i)->count();
                    if ($query == 0) {
                        $estado = 'Sin reportar';
                    }else{
                        $estado = '<span class="text-success">Reportada</span>';
                        $count_reportada = $count_reportada + 1; 
                    }
                    $tr .= '<tr role="button" class="info_guia" nro_guia="'.$i.'">
                                <td style="color: #0069eb">'.$formato_nro_guia.'</td>
                                <td>'.$estado.'</td>
                            </tr>';
                }/////cierra for

                // PORCENTAJE REPORTADO
                $reportado = ($count_reportada * 100)/50;

                $html = '<div class="d-flex justify-content-between px-3 pb-3">
                            <div>
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Talonario #'.$idTalonario.'</h1>
                                <span>Realizado en la Solicitud #'.$talonario->id_solicitud.'</span>
                            </div>
                            <div class="text-end">
                                <h1 class="modal-title fs-5">Cantera: '.$talonario->nombre.'</h1>
                                <span>Empresa: '.$talonario->razon_social.'</span>
                            </div>
                        </div>

                        <div class="mx-5 px-5 mb-3" style="">
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: '.$reportado.'%">'.$reportado.'%</div>
                            </div>
                            <p class="text-center pt-2">Se ha <span class="fw-bold">Reportado un '.$reportado.'%</span> del Talonario en el <span class="fw-bold">Libro de Control</span></p>
                        </div>

                        <table id="tableGuias" class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Nro. de Guía</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>                      
                        </table>';
             
                return response($html);

            }////cierra foreach
        }//// cierra if talonarios

    }

    public function guia(Request $request)
    {
        $nroGuia = $request->post('guia');
        $guia = DB::table('control_guias')->join('canteras', 'control_guias.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('sujeto_pasivos', 'control_guias.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->join('minerals', 'control_guias.id_mineral', '=', 'minerals.id_mineral')
                                            ->select('control_guias.*', 'canteras.nombre', 'canteras.municipio_cantera', 'canteras.parroquia_cantera', 'canteras.lugar_aprovechamiento', 'minerals.mineral', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                                            ->where('control_guias.nro_guia','=', $nroGuia)->get();
        
        if ($guia) {
            
            foreach ($guia as $g) {
                $html = '';
                $motivo = '';
                if ($g->anulada == 'Si') {
                   $motivo = $g->motivo;
                }else{
                    $motivo = '<span class="fst-italic text-secondary">No Aplica</span>';
                }

                $nro_factura = '';
                if ($g->nro_factura != '') {
                    $nro_factura = $g->nro_factura;
                }else{
                    $nro_factura = '<span class="fst-italic text-secondary">No Aplica</span>';
                }
                
                $length = 6;
                $formato_nro_guia = substr(str_repeat(0, $length).$g->nro_guia, - $length);

                $html = '   <div class="row d-flex justify-content-end">
                                <div class="col-4 text-end fs-5 fw-bold text-muted">
                                    <span class="text-danger">Nro° Guía </span><span id="nro_guia_view">'.$formato_nro_guia.'</span>
                                </div>
                            </div>

                            <div class="table-responsive">                    
                                <!-- FECHA Y HORA -->
                                <table class="table" style="width: 40%;">
                                    <tr>
                                        <th>Fecha:</th>
                                        <td>'.$g->fecha.'</td>
                                        <th>Hora de Salida:</th>
                                        <td>'.$g->hora_salida.'</td>
                                    </tr>
                                </table>
                                <!-- DATOS DE LA EMPRESA Y CANTERA -->
                                <table class="table">
                                    <tr>
                                        <th>Razon Social:</th>
                                        <td>'.$g->razon_social.'</td>
                                        <th>R.I.F.:</th>
                                        <td>'.$g->rif_condicion.'-'.$g->rif_nro.'</td>
                                    </tr>
                                    <tr>
                                        <th>Nombre de la Cantera:</th>
                                        <td>'.$g->nombre.'</td>
                                        <th>Municipio y Parroquia:</th>
                                        <td>Municipio '.$g->municipio_cantera.', Parroquia '.$g->parroquia_cantera.'</td>
                                    </tr>
                                    <tr>
                                        <th>Lugar de Aprovechamiento:</th>
                                        <td colspan="3">'.$g->lugar_aprovechamiento.'</td>
                                    </tr>
                                </table>
                                <!-- DATOS DEL DESTINATARIO -->
                                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>
                                <table class="table">
                                    <tr>
                                        <th>Razon Social del Destinatario:</th>
                                        <td>'.$g->razon_destinatario.'</td>
                                        <th>C.I/R.I.F. del Destinatario:</th>
                                        <td>'.$g->ci_destinatario.'</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono del Destinatario:</th>
                                        <td>'.$g->tlf_destinatario.'</td>
                                        <th>Municipio y Parroquia:</th>
                                        <td>Municipio '.$g->municipio_destino.', Parroquia '.$g->parroquia_destino.'</td>
                                    </tr>
                                    <tr>
                                        <th>Dirección de Destino:</th>
                                        <td colspan="3">'.$g->destino.'</td>
                                    </tr>
                                </table>
                                <!-- DATOS DE LA CARGA -->
                                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>
                                <table class="table">
                                    <tr>   
                                        <th>Nro. Factura:</th>
                                        <td colspan="2">'.$nro_factura.'</td>
                                        <th>Fecha de Facturación:</th>
                                        <td colspan="2">'.$g->fecha_facturacion.'</td>
                                    </tr>
                                    <tr>
                                        <th>Mineral:</th>
                                        <td colspan="2">'.$g->mineral.'</td>
                                        <th>Cantidad Facturada:</th>
                                        <td colspan="2">'.$g->cantidad_facturada.' '.$g->unidad_medida.'</td>
                                    </tr>
                                    <tr>
                                        <th>Saldo Anterior:</th>
                                        <td>'.$g->saldo_anterior.' '.$g->unidad_medida.'</td>
                                        <th>Cantidad Despachada:</th>
                                        <td>'.$g->cantidad_despachada.' '.$g->unidad_medida.'</td>
                                        <th>Saldo Restante:</th>
                                        <td>'.$g->saldo_restante.' '.$g->unidad_medida.'</td>
                                    </tr>
                                </table>
                                <!-- DATOS DEL VEHICULO Y CONDUCTOR -->
                                <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Vehículo y Conductor</p>
                                <table class="table ">
                                    <tr>   
                                        <th>Nombre del Conductor:</th>
                                        <td>'.$g->nombre_conductor.'</td>
                                        <th>C.I. del Conductor:</th>
                                        <td>'.$g->ci_conductor.'</td>
                                        <th>Teléfono del Conductor:</th>
                                        <td>'.$g->tlf_conductor.'</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo del Vehículo:</th>
                                        <td>'.$g->modelo_vehiculo.'</td>
                                        <th>Placa Nro.:</th>
                                        <td>'.$g->placa.'</td>
                                        <th>Capacidad del Vehículo:</th>
                                        <td>'.$g->capacidad_vehiculo.'</td>
                                    </tr>
                                </table>
                                <!-- DATOS: anulada?-->
                                <table class="table d-flex justify-content-end">
                                    <tr>
                                        <th>¿ANULADA?:</th>
                                        <td>'.$g->anulada.'</td>
                                        <th>Motivo:</th>
                                        <td>'.$motivo.'</td>
                                    </tr>
                                </table>
                            </div>
                           

                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Salir</button>
                            </div>';
               return response($html); 
            }
        }else{
            return response('ERROR AL TRAER LOS DATOS DE LA GUÍA.');
        }
        
        
        
        
        
        
        


    }

    /**
     * Store a newly created resource in storage.
     */
    public function qr(Request $request)
    {
        $ruta = $request->post('ruta');
        $talonario = $request->post('talonario');

        $html = '<div class="text-center my-4">
                    <img src="'.asset($ruta).'" alt="">
                </div>
                <div class="d-flex justify-content-center my-2">
                    <a href="'.asset($ruta).'" id="descargar_qr" talonario="'.$talonario.'" download class="btn btn-primary btn-sm">Descargar QR</a>
                </div>';
        return response($html);
      
    }

    /**
     * Display the specified resource.
     */
    public function accion(Request $request)
    {
        $talonario = $request->post('talonario');
        $user = auth()->id();
        $accion = 'QR DESCARGADO DEL TALONARIO NRO.'.$talonario.'.';
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 13, 'accion'=> $accion]);
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
