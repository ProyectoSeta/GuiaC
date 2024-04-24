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
        $dia = date("d");
        $mes = date("m");
        $year = date("Y");

        $nuevafecha = $mes - 1;
        if ($nuevafecha < 10) {
            $nuevafecha = '0'.$nuevafecha;
        }
        
        $c1 = DB::table('cierre_libros')->select('dia_cierre')->first();
        if ($c1) {
            $cierre = $c1->dia_cierre;
            if ($dia > $cierre) {
                $update = DB::table('libros')->where('id_sujeto', '=', $idSujeto)->update(['estado' => 'Rechazado', 'observaciones' => $observacion]);

            }




        }else{
            return response()->json(['success' => false]);
        }

        return response($mes.'-'.$nuevafecha);

    
    }
    
}
