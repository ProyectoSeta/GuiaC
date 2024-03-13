<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SujetoPasivo;
use App\Models\Solicitud;
use DB;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto','razon_social', 'rif')->find($user);
        $id_sp = $sp->id_sujeto;
        $razon = $sp->razon;
        $rif = $sp->rif;

        $solicitudes = DB::table('solicituds')->where('id_sujeto', $id_sp)->get();

        $tr = '';
        foreach ($solicitudes as $solicitud) {
            $id_solicitud = $solicitud->id_solicitud;
            $query_pagos = DB::table('pagos')->select('monto')->where('id_solicitud','=',$id_solicitud)->get();
            foreach ($query_pagos as $monto) {
                $monto = $monto->monto;
            }
            switch ($solicitud->estado) {
                case 'Verificando':
                    $estado = '<span class="badge text-bg-light">Verificando pago</span>';
                    break;
                case 'Negada':
                    $estado = '<span class="badge text-bg-danger">Negada</span>';
                    break;

                case 'En proceso':
                    $estado = '<span class="badge text-bg-primary">En proceso</span>';
                    break;
                
                case 'Retirar':
                    $estado = '<span class="badge" style="background-color: #ef7f00;">Retirar</span>';
                    break;
                
                case 'Retirado':
                    $estado = '<span class="badge text-bg-success">Retirado</span>';
                    break;
            }

            $tr .= '<tr>
                        <td>'.$id_solicitud.'</td>
                        <td>'.$razon.'</td>
                        <td>'.$rif.'</td>
                        <td>
                            <p class="text-primary fw-bold info_talonario" role="button" id_talonario="" >Ver más</p>
                        </td>
                        <td>'.$monto.'</td>
                        <td class="text-muted">12/02/2024</td>
                        <td>
                            '.$estado.'
                        </td>
                        <td>
                            <span class="badge" style="background-color: #ed0000;" role="button" data-bs-toggle="modal" data-bs-target="#modal_delete_solicitud">
                                <i class="bx bx-trash-alt fs-6"></i>
                            </span>
                        </td>
                    </tr>';
        }


        return view('solicitud');

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

        $year = date("Y");
        $mes = date("F");
        
        ///////////CREAR CARPETA PARA REFERENCIAS SI NO EXISTE
        if (!is_dir('../public/assets/dd/'.$year)){   ////no existe la carpeta del año
            if(mkdir('../public/assets/dd/'.$year, 0777)){
                mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
            }
        }
        else{   /////si existe la carpeta del año
            if (!is_dir('../public/assets/dd/'.$year.'/'.$mes)) {
                mkdir('../public/assets/dd/'.$year.'/'.$mes, 0777);
            }
        }

        $otroC = $request->post('status_otro_tipo');

        if ($otroC == 'true') {     ///////DOS (2) TIPOS DE TALONARIOS
            $tipo2 = $request->post('tipo2');
            $cant2 = $request->post('cantidad2');

            if ($request->hasFile('ref_pago')) {
                $photo         =   $request->file('ref_pago');
                $nombreimagen  =   $photo->getClientOriginalName();
                $ruta          =   public_path('assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
                $ruta_n        = 'assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen;
                if(copy($photo->getRealPath(),$ruta)){
                    
                    $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'estado' => 'Verificando']);
                    
                    if($query_solicitud){
                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                        
                        $query_pago = DB::table('pagos')->insert(['monto' => $monto, 'referencia' => $ruta_n, 'id_solicitud' => $id_solicitud]);
                        $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
                        $query_detalle_2 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 'cantidad' => $cant2, 'id_solicitud' => $id_solicitud]);
                        
                        if($query_detalle_1 && $query_detalle_2){
                            return response()->json(['success' => true]);
                        }
                    }
                }
            }else{   
                return response()->json(['success' => false]);
            }

        }else{      ///////UN (1) TIPO DE TALONARIO
            
            if ($request->hasFile('ref_pago')) {
                $photo         =   $request->file('ref_pago');
                $nombreimagen  =   $photo->getClientOriginalName();
                $ruta          =   public_path('assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen);
                $ruta_n        = 'assets/dd/'.$year.'/'.$mes.'/'.$nombreimagen;
                if(copy($photo->getRealPath(),$ruta)){
                    
                    $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 'estado' => 'Verificando']);

                    if($query_solicitud){
                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                        
                        $query_pago = DB::table('pagos')->insert(['monto' => $monto, 'referencia' => $ruta_n, 'id_solicitud' => $id_solicitud]);
                        $query_detalle_1 = DB::table('detalle_solicituds')->insert(['tipo_talonario' => $tipo, 'cantidad' => $cant, 'id_solicitud' => $id_solicitud]);
                        
                        if($query_detalle_1){
                            return response()->json(['success' => true]);
                        }
                    }
                }
            }else{   
                return response()->json(['success' => false]);
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
