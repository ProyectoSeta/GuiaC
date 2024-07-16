<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AsignarQrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignaciones = [];
        $consulta = DB::table('asignacion_reservas')
                                    ->join('clasificacions', 'asignacion_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                    ->select('asignacion_reservas.*','clasificacions.nombre_clf')
                                    ->where('asignacion_reservas.estado','=',17)
                                    ->get();

        foreach($consulta as $c) {
            $tipo_sujeto = $c->contribuyente;
            $rif_nro = '';
            $rif_condicion = '';
            if ($tipo_sujeto == 27) { ///registrado
                $sujeto = DB::table('sujeto_pasivos')->select('rif_nro','rif_condicion')->where('id_sujeto','=',$c->id_sujeto)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
            }else{  //////no registrado
                $sujeto = DB::table('sujeto_notusers')->select('rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$c->id_sujeto)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
            }

            $query = DB::table('detalle_talonarios')->select('desde','hasta','qr')
                                                    ->where('id_solicitud_reserva','=',$c->id_asignacion)
                                                    ->first();
            
            $array = array(
                'id_asignacion' => $c->id_asignacion,
                'contribuyente' => $c->contribuyente,
                'id_sujeto' => $c->id_sujeto,
                'id_cantera' => $c->id_cantera,
                'rif_nro' => $rif_nro,
                'rif_condicion' => $rif_condicion,
                'cantidad_guias' => $c->cantidad_guias,
                'fecha_emision' => $c->fecha_emision,
                'total_ucd' => $c->total_ucd,
                'soporte' => $c->soporte,
                'estado' => $c->estado,
                'desde' => $query->desde ?? 'None',
                'hasta' => $query->hasta ?? 'None',
                'qr' => $query->qr ?? 'None'
            );

            $a = (object) $array;
            array_push($asignaciones, $a);
        }


        return view('asignar_qr', compact('asignaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function qr_listo(Request $request)
    {
        $asignacion = $request->post('asignacion');
        $query = DB::table('detalle_talonarios')->select('desde','hasta')->where('id_solicitud_reserva','=',$asignacion)->first();
        if ($query) {
            $desde = $query->desde;
            $hasta = $query->hasta;
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $html = '<div class="modal-body text-center ">
                        <p class="fw-bold text-navy d-flex flex-column px-3">
                            <i class="bx bx-help-circle fs-1 text-secondary"></i>
                            ¿Las siguientes Guía(s) ya contienen su respectivo Código QR?
                        </p>
                        <div class="d-flex flex-column">
                            <span class="">Correlativo:</span>
                            <span class="text-muted">'.$formato_desde.' - '.$formato_hasta.'</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btn_qr_listo" id_asignacion="'.$asignacion.'">Si, listo.</button>
                    </div>';
            return response($html);
        }
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
