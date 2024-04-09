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
        $solicitudes = DB::table('solicituds')
            ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
            ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
            ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
            ->get();

        return view('estado', compact('solicitudes'));
    }

    public function solicitud(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
       
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
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
                                    <td>'.$i->tipo_talonario.' Guías</td>
                                    <td>'.$i->cantidad.' und.</td>
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

                // //////////////valor del ucd el dia de la solicitud
                // $query_ucd = DB::table('ucds')
                //         ->select('valor')
                //         ->where('fecha','=', $date_sol)->get();
                // foreach ($query_ucd as $u){
                //     $val_ucd = $u->valor;
                // }

                $estado = $solicitud->estado;
                $html_talonarios = '';
                $tr_talonarios = '';
                if ($estado == 'En proceso' || $estado == 'Retirar' || $estado == 'Retirado') {
                    $talonarios = DB::table('talonarios')->where('id_solicitud','=',$idSolicitud)->get();
                    $i=0;
                    foreach ($talonarios as $talonario) {
                        $i=$i+1;
                        $desde = $talonario->desde;
                        $hasta = $talonario->hasta;
                        $length = 6;
                        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                        $tr_talonarios .= ' <tr>
                                                <td>'.$i.'</td>
                                                <td class="fst-italic">'.$formato_desde.'</td>
                                                <td class="fst-italic">'.$formato_hasta.'</td>
                                            </tr>';
                    }   

                    $html_talonarios = '<div class="my-3">
                                            <h6 class="text-center mb-3" style="color: #0064cd;">Talonarios Emitidos</h6>
                                            <table class="table text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Desde</th>
                                                    <th>Hasta</th>
                                                </tr>
                                                '.$tr_talonarios.'
                                            </table>
                                    </div>';
                }else{
                    $html_talonarios = '';
                }

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-layer fs-1" style="color:#0c82ff"  ></i>                    
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Datos de la Solicitud</h1>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">

                           <div class="mb-3">
                                <h6 class="text-center mb-3" style="color: #0064cd;">Solicitud de Talonario(s) Realizada</h6>
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
                           </div>
                            '.$html_talonarios.'
                            <div class="d-flex justify-content-center my-3">
                                <table class="table table-sm w-75">
                                    <tr>
                                        <th>Total de Guías a emitir</th>
                                        <td>'.$total_guias.'</td>
                                    </tr>
                                    <tr>
                                        <th>UCD a pagar</th>
                                        <td>'.$solicitud->ucd_pagar.'</td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="d-flex justify-content-center">
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                            </div>

                        </div>';

                        return response($html);
            }

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
                                <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <span class="fw-bold">Observaciones de la Denegación</span>
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
