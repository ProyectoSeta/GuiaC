<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('asignar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $rif_nro = $request->post('rif_nro'); 
        $rif_condicion = $request->post('rif_condicion');
        $html = '';

        $query =  DB::table('sujeto_pasivos')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
        if ($query->total == 0) {
            $query2 =  DB::table('sujeto_notusers')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            if ($query2->total == 0) {
                $html = '<div class="text-center">
                            <p class="fw-bold text-muted mb-2">Contribuyente No Registrado</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_no_registrado">Registrar</a>
                        </div>';
            }else{
                $consulta =  DB::table('sujeto_notusers')->select('id_sujeto_notuser','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
                $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado</p>
                            <a href="#" class="asignar" tipo="notuser" id_sujeto="'.$consulta->id_sujeto_notuser.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
            }
        }else{
            $consulta =  DB::table('sujeto_pasivos')->select('id_sujeto','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado</p>
                            <a href="#" class="asignar" tipo="user" id_sujeto="'.$consulta->id_sujeto.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
        }

        return response($html);
    }


    public function modal(Request $request)
    {
        $tipo = $request->post('tipo'); 
        $sujeto = $request->post('sujeto');
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
