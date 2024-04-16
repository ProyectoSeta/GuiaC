<?php

namespace App\Http\Controllers;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ControlCanterasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limites = DB::table('limite_guias')
                ->join('sujeto_pasivos', 'limite_guias.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->join('canteras', 'limite_guias.id_cantera','=', 'canteras.id_cantera')
                ->select('limite_guias.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                ->get();

        return view('control_canteras', compact('limites'));
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
