<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SujetoPasivo;
use DB;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;
        $solicitudes = DB::table('solicituds')->where('id_sujeto', $id_sp)->get();

        return view('solicitud', compact('solicitudes'));

    }

    public function calcular(Request $request)
    {
        $tipo = $request->post('tipo');
        $cant = $request->post('cantidad');

        $tipo2 = $request->post('tipo2');
        $cant2 = $request->post('cantidad2');

        $monto_1 = 0;
        $monto_2 = 0;

        if (($tipo == 25) || ($tipo == 50)) {
            $ucds = ($tipo * 5)*$cant; 
            $id_max = DB::table('ucds')->max('id');
            $valor = DB::table('ucds')->select('valor')->where('id','=',$id_max)->get();
            foreach ($valor as $v) {
                $ucd_valor = $v->valor;
                $monto_1 = $ucds * $ucd_valor;
            }
        }else{
            $monto_1 = 0;
        }
        /////////////  OTRO TIPO DE TALONARIO   /////////////
        if (($tipo2 == 25) || ($tipo2 == 50)) {
            $ucds_2 = ($tipo2 * 5)*$cant2; 
            $id_max = DB::table('ucds')->max('id');
            $valor = DB::table('ucds')->select('valor')->where('id','=',$id_max)->get();
            foreach ($valor as $v) {
                $ucd_valor = $v->valor;
                $monto_2 = $ucds_2 * $ucd_valor;
            }
        }else{
            $monto_2 = 0;
        }
       
        $subtotal = $monto_1 + $monto_2;
        $total = number_format($subtotal, 2, ',', '.');
        return response($total);
           

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
