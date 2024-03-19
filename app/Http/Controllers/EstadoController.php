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
            ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
            ->get();

        return view('estado', compact('solicitudes'));
    }

    public function solicitud(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
       
        $solicitudes = DB::table('solicituds')
        ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicituds.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
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
                $ucds = $total_guias * 5;

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
                            <i class="bx bxs-layer fs-1" style="color:#0c82ff"  ></i>                    
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Datos de la Solicitud</h1>
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
                                        <th>UCD a pagar</th>
                                        <td>'.$ucds.'</td>
                                    </tr>
                                    <tr>
                                        <th>Precio del UCD (al día)</th>
                                        <td>'.$val_ucd.'</td>
                                    </tr>
                                    <tr>
                                        <th>Monto total</th>
                                        <td>'.$solicitud->monto.'</td>
                                    </tr>
                                    <tr>
                                        <th>Referencia</th>
                                        <td><a target="_blank" href="'.asset($solicitud->referencia).'">Ver</a></td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm me-4 aprobar_correlativo" id_solicitud="'.$idSolicitud.'" id_sujeto="'.$solicitud->id_sujeto.'" fecha="'.$date_sol.'" >Aprobar</button>
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </div>';

                        return response($html);
            }

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
