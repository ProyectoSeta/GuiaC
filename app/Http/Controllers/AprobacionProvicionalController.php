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
