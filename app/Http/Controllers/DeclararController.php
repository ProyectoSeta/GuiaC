<?php

namespace App\Http\Controllers;
use DB;
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
    public function info_declarar(){
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $hoy = date("Y-n-d"); 
        $month = date("n");
        $year = date("Y"); 

        ///////////////CONSULTA: ¿EL SP HA HECHO DECLARACIONES ANTES?
        $c1 = DB::table('declaracions')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->first();
        if ($c1){
            $nro_dcr = $c1->total;
            if ($nro_dcr == 0) {
                ////////sin declaraciones
                ///////primer talonario emitido: inicio del proceso
                $c2 = DB::table('talonarios')->select('fecha_retiro')->where('id_sujeto','=',$id_sp)->first();
                if ($c2) {
                    $date_first_talonario = $c2->fecha_retiro;
                    $format_date_first = strtotime($date_first_talonario);
                    $month_start = date("n", $format_date_first); // Devuelve un entero desde 1 (enero) hasta 12 (diciembre)
                    $year_start = date("Y", $format_date_first); // Devuelve el año con cuatro dígitos (por ejemplo, 2023)

                    if (condition) {
                        # code...
                    }

                    
                }else{

                }
            }else{
                ///////con declaraciones

            }
        }else{

        }





















    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
 
        
        $year = date("Y");
        $mes = date("F");

        ///////////CREAR CARPETA PARA REFERENCIAS SI NO EXISTE
        if (!is_dir('../public/assets/declaraciones/'.$year)){   ////no existe la carpeta del año
            if(mkdir('../public/assets/declaraciones/'.$year, 0777)){
                mkdir('../public/assets/declaraciones/'.$year.'/'.$mes, 0777);
            }
        }
        else{   /////si existe la carpeta del año
            if (!is_dir('../public/assets/declaraciones/'.$year.'/'.$mes)) {
                mkdir('../public/assets/declaraciones/'.$year.'/'.$mes, 0777);
            }
        }











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
