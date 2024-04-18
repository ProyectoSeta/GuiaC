<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeclararController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('declarar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function info_declarar()
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        ///////////¿ES LA PRIMERA DECLARACIÓN QUE HACE EL SP?
        $comprobar = DB::table('declaracions')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->first();
        if ($comprobar) {
            if ($comprobar->total == 0) {
                ////////PRIMERA VEZ QUE EL SP REALIZA UNA DECLARACIÓN


            }else{
                ////////EL SP YA HA DECLARADO ANTERIORMENTE

            }
        }else{
            return response()->json(['success' => false]);
        }

        ////////////busco en la tabla "DECLARACIONS" la ultima declaración que hizo el SJ
    



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
