<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AprobacionProvicionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = DB::table('solicitud_reservas')
                                            ->join('sujeto_pasivos', 'solicitud_reservas.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('clasificacions', 'solicitud_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                            ->select('solicitud_reservas.*','canteras.nombre','clasificacions.nombre_clf', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                                            ->where('solicitud_reservas.estado', 4)->get();

        return view('aprobacion_provicional',compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function aprobar(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
       
        $solicitud = DB::table('solicitud_reservas')
        ->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
        ->join('sujeto_pasivos', 'solicitud_reservas.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicitud_reservas.*','canteras.nombre', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro')
        ->where('solicitud_reservas.id_solicitud_reserva','=',$idSolicitud)
        ->first();

        if ($solicitud) {
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar la siguiente solicitud?</h1>
                        <div class="">
                            <h1 class="modal-title fs-6 text-secondary" id="">Guías Provicionales</h1>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-3"  style="font-size:14px;">
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">Contribuyente:</div>
                        <div class="col-sm-8">'.$solicitud->razon_social.'</div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">R.I.F.:</div>
                        <div class="col-sm-8">'.$solicitud->rif_condicion.'-'.$solicitud->rif_nro.'</div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">Cantera:</div>
                        <div class="col-sm-8">'.$solicitud->nombre.'</div>
                    </div>
                    <div class="border my-4"></div>
                    <h6 class="text-center mb-4 text-navy fw-bold">Solicitud de Guías Realizada</h6>
                    <div class="d-flex justify-content-center">
                        <table class="table table-sm w-75 text-center">
                            <thead>
                                <tr>
                                    <th>No. Guías</th>
                                    <th> Total UCD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>'.$solicitud->cantidad_guias.'</td>
                                    <td>'.$solicitud->total_ucd.'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
 
                    <input type="hidden" value="'.$solicitud->id_solicitud_reserva.'" name="id_solicitud">

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm me-4 aprobar_correlativo_p" id_solicitud="'.$solicitud->id_solicitud_reserva.'" >Aprobar</button>
                        <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    



                </div>';

                return response($html);
        }
       
       
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
