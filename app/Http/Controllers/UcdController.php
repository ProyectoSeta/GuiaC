<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class UcdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ucd = DB::table('ucds')->get();

        $actual =  DB::table('ucds')->select('valor','moneda')->orderBy('id', 'desc')->first();
        
        return view('ucd', compact('ucd','actual'));
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
    public function update(Request $request)
    {
        $valor = $request->post('valor');
        $moneda = $request->post('moneda');

        $insert = DB::table('ucds')->insert(['valor' => $valor,'moneda' => $moneda]);

        if ($insert) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
