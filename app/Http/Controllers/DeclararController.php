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

        $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
        $year_actual = date('Y');

        $periodo = '';
        $periodo_val = '';
        $guias_emitidas = '';
        $total_ucd = '';
        $total_pagar = '';
        $actividad = '';

        $mes_declarar = '';
        $year_declarar = '';


        /////////////CONSULTA DEL PRIMER TALONARIO EMITIDO AL SP
        $consulta = DB::table('talonarios')->select('fecha_retiro')->where('id_sujeto','=',$id_sp)->first();
        if ($consulta) {
            $fecha_primer_talonario = $consulta->fecha_retiro;
            $fecha_prev = strtotime($fecha_primer_talonario);
            $mes_inicio = date("n", $fecha_prev); // Devuelve un entero desde 1 (enero) hasta 12 (diciembre)
            $year_inicio = date("Y", $fecha_prev); // Devuelve el año con cuatro dígitos (por ejemplo, 2023)

            ///////////////CONSULTA: ¿EL SP HA HECHO DECLARACIONES ANTES?
            $consulta_2 = DB::table('declaracions')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->first();
            if ($consulta_2) {
                $nro_declaraciones = $consulta_2->total;
                if ($nro_declaraciones == 0) {
                    //////EL SP NO HA DECLARADO NADA TODAVIA
                    $periodo = $meses[$mes_inicio].' - '.$year_inicio; ////no se le suma 1 porque el array de meses comienza desde 0
                    $periodo_val = $year_inicio.'-'.($mes_inicio).'-01';
                    
                    $mes_declarar = $mes_inicio;
                    $year_declarar = $year_inicio;
                }else{
                    //////EL SP YA HA DECLARADO ANTERIORMENTE
                    $consulta_3 = DB::table('declaracions')->select('mes_declarado','year_declarado')->orderBy('id', 'desc')->where('id_sujeto','=',$id_sp)->first();
                    if ($consulta_3) {
                        $ultimo_mes_declarado = $consulta_3->mes_declarado;
                        $ultimo_year_declarado = $consulta_3->year_declarado;

                        if ($ultimo_year_declarado == $year_actual) {
                            ///////la ultima declaracion realizada por el sp fue del presente año
                            if ($ultimo_mes_declarado == 12) {
                                //////el mes a declarar es enero del siguente año
                                $nuevo_year = date("Y",strtotime($year_actual."+ 1 year")); 

                                $periodo = $meses[1].' - '.$nuevo_year; ///enero del año siguiente es el mes a declarar
                                $periodo_val = $nuevo_year.'-1-01';

                                $mes_declarar = 1;
                                $year_declarar = $nuevo_year;
                            }else{
                                //////todavia le quedan meses al año
                                $periodo = $meses[$ultimo_mes_declarado + 1].' - '.$year_actual; 
                                $periodo_val = $year_actual.'-'.($ultimo_mes_declarado + 1).'-01';

                                $mes_declarar = $ultimo_mes_declarado + 1;
                                $year_declarar = $year_actual;
                            }
                        }else{
                            ///////el año de la ultima declaración es diferente al actual
                            if ($ultimo_mes_declarado == 12) {
                                ////el mes a declarar es enero del siguiente año
                                $new_year = date("Y",strtotime($ultimo_year_declarado."+ 1 year"));

                                $periodo = $meses[1].' - '.$new_year;
                                $periodo_val = $new_year.'-1-01'; 

                                $mes_declarar = 1;
                                $year_declarar = $new_year;
                            }else{
                                $periodo = $meses[$ultimo_mes_declarado + 1].' - '.$ultimo_year_declarado; 
                                $periodo_val = $ultimo_year_declarado.'-'.($ultimo_mes_declarado + 1).'-01';

                                $mes_declarar = $ultimo_mes_declarado + 1;
                                $year_declarar = $ultimo_year_declarado;
                            }
                        }

                    }else{
                        return response()->json(['success' => false, 'nota' => 'Error al cargar la información.']);
                    }
                }



                /////////BUSCAR GUIAS EMITIDAS CORRESPONDIENTE AL PERIODO A DECLARAR
                $guias = DB::table('control_guias')->selectRaw("count(*) as total")
                                            ->whereYear('fecha', $year_declarar)
                                            ->whereMonth('fecha', $mes_declarar)
                                            ->where('id_sujeto','=',$id_sp)
                                            ->first();
                if ($guias) {
                    $guias_emitidas = $guias->total;
                    if ($guias_emitidas == 0) {
                        ////////sin actividad economica
                        $total_ucd = 0;
                        $total_pagar = 0;
                        $actividad = 'no';
                    }else{
                        //////
                        $total_ucd = $guias_emitidas * 5;
                        $actividad = 'si';
                        $ucd =  DB::table('ucds')->select("valor")->orderBy('id', 'desc')->first();
                        if ($ucd) {
                            $valor_ucd = $ucd->valor;
                            $total_pagar = $total_ucd * $valor_ucd;
                        }else{
                            return response()->json(['success' => false, 'nota' => 'Error al cargar la información.']);
                        }  

                    }
                    
                }else{
                    return response()->json(['success' => false, 'nota' => 'Error al cargar la información.']);
                }

                $html = '<p class="text-secondary-emphasis me-3 ms-3" style="font-size:13px"><span class="fw-bold">IMPORTANTE:
                            </span>Estimado contribuyente, <span class="fw-bold">para poder realizar la Declaración</span> deberá reportar previamente en el 
                            <span class="fw-bold">Libro de Control, TODAS las guías generadas</span>, del mes anterior. Debido a, 
                            que si no reporta todas las guías emitidas, incluyendo las que hayan sido anuladas, estaría evadiendo 
                            el deber formal. Lo cual según el art. ------------ de la ley ----------- implicaría la fiscalización 
                            y/o multa de la empresa.    
                        </p>
                        <form id="form_declarar_guias" method="post" onsubmit="event.preventDefault(); declararGuias()" enctype="multipart/form-data">
                            <div class="d-flex justify-content-center mx-5 px-5 mb-2">
                                <table class="table" style="font-size:14px;">
                                    <tr>
                                        <th>Declaración Correspondiente al período</th>
                                        <td>
                                            <select class="form-select form-select-sm" disabled>
                                                <option value="'.$periodo_val.'">'.$periodo.'</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Guías Emitidas</th>
                                        <td>
                                            <input type="text" readonly class="form-control-plaintext form-control-sm" name="guias_emitidas" id="guias_emitidas" value="'.$guias_emitidas.'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total UCD</th>
                                        <td>
                                            <input type="text" readonly class="form-control-plaintext form-control-sm" name="total_ucd" id="total_ucd" value="'.$total_ucd.'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total a Pagar</th>
                                        <td>
                                            <input type="text" readonly class="form-control-plaintext form-control-sm" name="total_pagar" id="total_pagar" value="'.$total_pagar.'">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p class="fw-bold fs-6 text-danger text-center d-none" id="actividad">* Sin actividad económica</p>
                            <input type="hidden" name="actividad" value="'.$actividad.'">
                            <input type="hidden" name="mes_declarar" value="'.$mes_declarar.'">
                            <input type="hidden" name="year_declarar" value="'.$year_declarar.'">
                            <input type="hidden" name="valor_ucd" value="'.$valor_ucd.'">
                            <input type="hidden" name="periodo" value="'.$periodo_val.'">

                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <div class="row">
                                    <div class="col-sm-4">
                                    <label for="referencia" class="form-label">Referencia del Pago</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control form-control-sm" id="referencia" name="referencia" type="file">
                                    </div>
                                </div>
                            </div>

                            <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">NOTA:
                                </span>Cada Guía tiene un valor de <span class="fw-bold"> cinco (5) UCD</span> (Unidad de Cuenta Dinámica). 
                                El valor de un (1) UCD equivale al tipo de cambio de la moneda de mayor valor publicado por el 
                                Banco Central de Venezuela.    
                            </p>

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="submit" class="btn btn-success btn-sm me-3 btn_form_declarar" disabled>Declarar</button>
                                <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>';
                
                return response()->json(['success' => true, 'html' => $html, 'actividad' => $actividad]);


            }else{
                return response()->json(['success' => false, 'nota' => 'Error al cargar la información.']);
            }

        }else{
            return response()->json(['success' => false, 'nota' => 'Error al cargar la información.']);
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

        $periodo = $request->post('periodo');
        $guias_emitidas = $request->post('guias_emitidas');
        $total_ucd = $request->post('total_ucd');
        $total_pagar = $request->post('total_pagar');
        $actividad = $request->post('actividad');
        $mes_declarar = $request->post('mes_declarar');
        $year_declarar = $request->post('year_declarar');
        $valor_ucd = $request->post('valor_ucd');

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

        if ($request->hasFile('referencia')) {
            $photo         =   $request->file('referencia');
            $nombreimagen  =   $photo->getClientOriginalName();
            $ruta          =   public_path('assets/declaraciones/'.$year.'/'.$mes.'/'.$nombreimagen);
            $ruta_n        = 'assets/declaraciones/'.$year.'/'.$mes.'/'.$nombreimagen;
            if(copy($photo->getRealPath(),$ruta)){

                if ($actividad == 'no') {
                    $obv = 'Sin actividad económica';
                }else{
                    $obv = '';
                }

                $year_p = date('Y', strtotime($periodo));
                $mes_p = date('n', strtotime($periodo));

                $mes_hoy = date('n');
                // $mes_limite = date("m",strtotime('-1 month', strtotime($mes_hoy)));
                $mes_limite = date("n", strtotime($mes_hoy."-1  months")); 
                $nota = '';

                if ($year_p != $year) {
                    ////A DESTIEMPO EL AÑO NO COINCIDE
                    $nota = 'Pago a destiempo';
                }else{
                    if ($mes_limite == $mes_p) {
                        $nota = 'Pago a tiempo';
                    }else{
                        $nota = 'Pago a destiempo';
                    }
                }
                
                // $insert = DB::table('declaracions')->insert(['id_sujeto' => $id_sp, 
                //                                             'year_declarado' => $year_declarar, 
                //                                             'mes_declarado' => $mes_declarar,
                //                                             'nro_guias_declaradas' => $guias_emitidas, 
                //                                             'total_ucd' => $total_ucd, 
                //                                             'monto_total' => $total_pagar, 
                //                                             'valor_ucd_dia' => $valor_ucd,
                //                                             'referencia' => $ruta_n, 
                //                                             'nota' => $nota,
                //                                             'observacion' => $obv]);
                
                // if($insert){
                //     return response()->json(['success' => true]);
                // }else{
                //     return response()->json(['success' => false]);
                // }
            }
        }

        return response($mes_limite);



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
