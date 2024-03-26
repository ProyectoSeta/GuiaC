<?php

namespace App\Http\Controllers;
use App\Models\SujetoPasivo;
use DB;

use Illuminate\Http\Request;

class RegistroGuiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;

        $registros = DB::table('control_guias')->where('id_sujeto', $id_sp)->get();

        return view('registro_guia', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function modal_registro(){
    //     $user = auth()->id();
    //     $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
    //     $id_sp = $sp->id_sujeto;

    //     $query = DB::table('control_guias')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->get(); 
    //     foreach ($query as $c) {
    //         $count = $c->total;
    //         if ($count == 0) {
    //             /////////el usuario no ha registrado guias todavia
    //             $query_2 = DB::table('control_guias')->where('id_sujeto', $id_sp)->latest('id_control')->first();

    //         }else{
    //             ////////el usuario ya tiene guias registradas

    //         }
    //     }

    //    return response($count);



    }




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
