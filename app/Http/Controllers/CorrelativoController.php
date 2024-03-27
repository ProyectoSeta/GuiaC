<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class CorrelativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talonarios = DB::table('talonarios')
        ->join('sujeto_pasivos', 'talonarios.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('talonarios.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
        ->get();

    return view('correlativo', compact('talonarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function talonario(Request $request)
    {
        $idTalonario = $request->post('talonario');
        $talonarios = DB::table('talonarios')->select('desde','hasta')->where('id_talonario','=', $idTalonario)->get();
        if ($talonarios) {
            $tr = '';
            foreach ($talonarios as $talonario) {
               $desde = $talonario->desde;
               $hasta = $talonario->hasta;

                for ($i=$desde; $i <= $hasta; $i++) { 
                    $length = 6;
                    $formato_nro_guia = substr(str_repeat(0, $length).$i, - $length);
                    

                    $estado = '';
                    $query = DB::table('control_guias')->where('nro_guia','=', $i)->count();
                    if ($query == 0) {
                        $estado = 'Sin reportar';
                    }else{
                        $estado = 'Reportada';
                    }

                    $tr .= '<tr role="button" class="info_guia" nro_guia="'.$i.'">
                                <td style="color: #0069eb">'.$formato_nro_guia.'</td>
                                <td>'.$estado.'</td>
                            </tr>';
                }/////cierra for
             
                return response($tr);

            }////cierra foreach
        }//// cierra if talonarios

    }

    public function guia(Request $request)
    {
        $idGuia = $request->post('guia');
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
