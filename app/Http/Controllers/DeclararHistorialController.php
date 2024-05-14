<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class DeclararHistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $declaraciones = DB::table('declaracions')
                                ->join('clasificacions', 'declaracions.estado', '=', 'clasificacions.id_clasificacion')
                                ->join('tipos', 'declaracions.tipo', '=', 'tipos.id_tipo')
                                ->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                ->select('declaracions.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'clasificacions.nombre','tipos.nombre_tipo')
                                ->where('declaracions.id_sujeto', $id_sp)
                                ->orderBy('declaracions.id_declaracion', 'asc')
                                ->get();
                               

        return view('historial_declaraciones', compact('declaraciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function nota(Request $request)
    {
        $declaracion = $request->post('declaracion');
        $query = DB::table('declaracions')->select('observaciones')->where('id_declaracion','=',$declaracion)->first();
        if ($query) {
            $html = '<h5 class="text-muted text-center mb-2">NOTA</h5>
                    <p class="text-justify" style="font-size:14px">
                        '.$query->observaciones.'
                    </p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
