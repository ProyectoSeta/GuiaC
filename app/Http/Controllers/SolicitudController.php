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
        $otroC = $request->post('otro_campo');

        ///////si el sj ingreso dos tipos de talonarios
        if ($otroC == 'true') {
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
            
            //////resultado
            $subtotal = $monto_1 + $monto_2;
            $total = number_format($subtotal, 2, ',', '.');
            return response($total);

        }else{ ////// si el sj solo ingreso un tipo de talonario
            $monto_1 = 0;

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

            //////resultado
            $total = number_format($monto_1, 2, ',', '.');
            return response($total);

        }

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
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;

        $tipo = $request->post('tipo');
        $cant = $request->post('cantidad');
        $monto = $request->post('monto_talonario');
        $photo = $request->file('ref_pago');
        return response($photo);
  
        $year = date("Y");
        $mes = date("F");

        if ($request->hasFile("ref_pago")) {
            if (!is_dir('../public/assets/dd/'.$year)){ ////existe la carpeta correspondiente a este año? No
                mkdir('../public/assets/dd/'.$year, 0777); /////se crea la carpeta del presente año y del mes (este caso se debe presentar en enero)   
                mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
            }
            else{
                if (!is_dir('../public/assets/dd/'.$year.'/'.$mes)) {
                    mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
                }
            }

            $photo         =   $request->file('ref_pago');
            $nombreimagen   =   $photo->getClientOriginalName();
            $ruta           =   public_path('../public/assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
            copy($photo->getRealPath(),$ruta);
            // return response('llego');

        }
       

        // if (is_dir('../public/assets/dd')){
        //     mkdir('../public/assets/dd/'.$year, 0777);
        //     return response('existe');
        // }else{
        //     return response('no existe');
        // }
       

        // $otroC = $request->post('status_otro_tipo');

        // if ($otroC == 'true') {
        //     $tipo2 = $request->post('tipo2');
        //     $cant2 = $request->post('cantidad2');



        //     // $register_1 = DB::table('solicituds')->insert(['id_sujeto' => $id_sp,'tipo_talonario' => $tipo,'cantidad' => $cant,
        //     //                                                 'monto' => $monto,'estado' => 'Verificando', 'id_pago']);




        // }else{

        // }


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
