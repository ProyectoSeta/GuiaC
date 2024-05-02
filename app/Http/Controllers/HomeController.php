<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        return view('home');
    }

    
    public function libro()
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $dia = date("d");
        $mes = date("m");
        $year = date("Y");

        // $consulta = DB::table('libros')->select('mes','year')->orderBy('id_libro', 'desc')->where('id_sujeto','=',$id_sp)->first();
        // if ($consulta) {
        //     $ultimo_mes_declarado = $consulta->mes;
        //     $ultimo_year_declarado = $consulta->year;

            

        //     return response($ultimo_mes_declarado.'/'.$ultimo_year_declarado);
        // }
       


    

    
    }
    
}
