<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DetalleReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_talonario = $request->talonario;
        $detalles = DB::table('detalle_talonarios')
            ->join('sujeto_pasivos', 'detalle_talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
            ->join('canteras', 'detalle_talonarios.id_cantera', '=', 'canteras.id_cantera')
            ->select('detalle_talonarios.*','canteras.nombre', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
            ->where('detalle_talonarios.id_talonario','=',$id_talonario)
            ->get();
    

        return view('detalle_reserva', compact('detalles','id_talonario'));
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
