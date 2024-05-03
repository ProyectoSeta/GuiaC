<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class DeclararController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $hoy = date('d');
        $mes = date('n');
        $year = date('Y');

        $mes_anterior = $mes - 1;
        if ($mes_anterior == 00) {
            $mes_anterior = 12;
            $year = $year - 1;
        }

        $cierre = DB::table('fechas')->select('fecha')->where('nombre','=','cierre_libro')->first();
        if ($cierre) {
            $dia_cierre = $cierre->fecha;
        }

        if ($hoy > $dia_cierre){
            ///////se traen todos los libros sin declarar menos el libro del mes actual
            $libros = DB::table('libros')->where('id_sujeto','=',$id_sp)
                                        ->where('estado','=',2)
                                        ->where('mes','!=',$mes)
                                        ->where('year','=',$year)
                                        ->get();
        }else{
            ///////se traen todos los libros sin declarar menos el libro del mes pasado
            $libros = DB::table('libros')->where('id_sujeto','=',$id_sp)
                                        ->where('estado','=',2)
                                        ->where('mes','!=',$mes_anterior)
                                        ->where('year','=',$year)
                                        ->get();
        }

        return view('declarar', compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function info_declarar(Request $request){
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $mes = $request->post('mes');
        $year = $request->post('year');
        $idLibro = $request->post('libro');

        $extemporaneas = DB::table('control_guias')->selectRaw("count(*) as total")
                                                        ->where('id_sujeto','=',$id_sp)
                                                        ->where('id_libro','=',$idLibro)
                                                        ->where('estado','=',3)->first();
        if ($extemporaneas) {
            $guias_extemp = $extemporaneas->total;
        }

        $emitidas = DB::table('control_guias')->selectRaw("count(*) as total")
                                                        ->where('id_sujeto','=',$id_sp)
                                                        ->where('id_libro','=',$idLibro)->first();
        if ($emitidas) {
            $guias_emitidas = $emitidas->total;
            $actividad = '';
            if ($guias_emitidas == 0) {
                //sin actividad economica
                $actividad = 'no';
            }else{
                //con actividad
                $actividad = 'si';
            }
        }

        $total_ucd = $guias_emitidas * 5;

        $ucd =  DB::table('ucds')->select('id','valor')->orderBy('id', 'desc')->first();
        if ($ucd){
            $valor_ucd = $ucd->valor;
            $id_ucd = $ucd->id;
            $total_pagar = $total_ucd * $valor_ucd;
        }

        $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
        $mes_libro = $meses[$mes];


        $html = '<p class="text-secondary-emphasis me-3 ms-3 text-justify" style="font-size:13px"><span class="fw-bold">IMPORTANTE:
                    </span>Estimado contribuyente, <span class="fw-bold">PARA PODER REALIZAR LA DECLARACIÓN</span> deberá haber <span class="fw-bold">REPORTADO</span> previamente en el 
                    <span class="fw-bold">Libro de Control, TODAS LAS GUÍAS GENERADAS DURANTE EL PERÍODO A DECLARAR</span>. Debido a, 
                    que si no reporta todas las guías emitidas, incluyendo las que hayan sido anuladas, estaría evadiendo 
                    el deber formal. Lo cual, según la <span class="fst-italic">Gaceta ordinaria N°2679, 2018. Ley Sobre el Régimen, Administración y Aprovechamiento de 
                    Minerales no Metálicos del Estado Aragua, Art. 92.</span> La empresa puede resivir sanciones por el incumplimiento de deberes formales.     
                </p>
                <form id="form_declarar_guias" method="post" onsubmit="event.preventDefault(); declararGuias()" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center mx-5 px-5 mb-2">
                        <table class="table" style="font-size:14px;">
                            <tr>
                                <th>Declaración Correspondiente al período</th>
                                <td>
                                    <select class="form-select form-select-sm" disabled>
                                        <option value="">'.$mes_libro.' '.$year.'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Guías Extemporaneas</th>
                                <td>
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" name="guias_extemp" id="guias_extemp" value="'.$guias_extemp.'">
                                </td>
                            </tr>
                            <tr>
                                <th>Total de Guías Emitidas</th>
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
                            <tr class="table-warning">
                                <th>TOTAL A PAGAR</th>
                                <td>
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" fw-bold name="total_pagar" id="total_pagar" value="'.$total_pagar.'">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="fw-bold fs-6 text-danger text-center d-none" id="actividad">* Sin actividad económica</p>
                    <input type="hidden" name="mes_declarar" value="'.$mes.'">
                    <input type="hidden" name="year_declarar" value="'.$year.'">
                    <input type="hidden" name="id_ucd" value="'.$id_ucd.'">
                    <input type="hidden" name="id_libro" value="'.$idLibro.'">

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

                return response()->json(['html' => $html, 'actividad' => $actividad]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
 
        $mes_declarar = $request->post('mes_declarar');
        $year_declarar = $request->post('year_declarar');
        $valor_ucd = $request->post('valor_ucd');
        $referencia = $request->post('referencia');
        $guias_extemp = $request->post('guias_extemp');
        $guias_emitidas = $request->post('guias_emitidas');
        $total_ucd = $request->post('total_ucd');
        $total_pagar = $request->post('total_pagar');
        $id_libro = $request->post('id_libro');
        




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
