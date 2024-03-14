<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;


use Illuminate\Http\Request;

class AprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $datos = [];
        $solicitudes = DB::table('solicituds')->where('estado','=','Verificando')->get();
        foreach ($solicitudes as $solicitud) {
            $id_sujeto = $solicitud->id_sujeto;
            $razon = '';
            $sujeto_pasivo = DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->get();
            foreach ($sujeto_pasivo as $sp) {
                $razon = $sp->razon_social;
            }
            array_push($datos, [
                    'id_solicitud' => $solicitud->id_solicitud,   
                    'id_sujeto' => $id_sujeto,
                    'razon' => $razon, 
                    'monto' => $solicitud->monto,
                    'fecha' => $solicitud->fecha]);
        }
        var_dump($datos);
        // return view('aprobacion_solicitud', compact('datos'));
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
