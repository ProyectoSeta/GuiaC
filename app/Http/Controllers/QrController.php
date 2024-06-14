<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function qr(Request $request)
    {
        $idTalonario = $request->get('id');
        $talonario = DB::table('detalle_talonarios')
                        ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                        ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
                        ->join('talonarios', 'detalle_talonarios.id_talonario', '=', 'talonarios.id_talonario')
                        ->select('detalle_talonarios.*','talonarios.id_solicitud', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre', 'canteras.municipio_cantera', 'canteras.parroquia_cantera', 'canteras.lugar_aprovechamiento')
                        ->where('detalle_talonarios.id_talonario','=', $idTalonario)
                        ->first();

       return view('qr', compact('talonario'));
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
