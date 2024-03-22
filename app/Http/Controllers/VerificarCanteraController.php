<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class VerificarCanteraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canteras = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
                ->where('status', 'Verificando')->get();
        return view('verificar_cantera', compact('canteras'));
    }


    public function info(Request $request)
    {
        $idCantera = $request->post('cantera');
        $query = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
                ->where('canteras.id_cantera','=',$idCantera)->get();
        if ($query) {
            $html = '';
            $min = '';

            foreach ($query as $c) {
                //////////////minerales
                $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
                foreach ($minerales as $id_min) {
                    $id = $id_min->id_mineral;
                    $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                    if($query_min){
                        foreach ($query_min as $mineral) {
                            $name_mineral = $mineral->mineral;
                            $min .= '<span>'.$name_mineral.'</span>';
                        }
                    } 
                }

                ///////////datos cantera
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Verificar Cantera?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$c->nombre.'</h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <span class="fw-bold">Contribuyente</span>
                            <p class="text-center">'.$c->razon_social.' - '.$c->rif.'</p>
                            
                            <span class="fw-bold">Dirección</span>
                            <p class="text-center">'.$c->direccion.'</p>

                        
                            <span class="fw-bold">Producción</span>
                            <div class="d-flex flex-column text-center" id="info_produccion">
                               '.$min.'
                            </div>

                            <div class="d-flex justify-content-center my-3">
                                <button class="btn btn-success btn-sm me-4" id="cantera_verificada" id_cantera="'.$idCantera.'">Verificada</button>
                                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>';
                return response($html);
            }
        }
    }

    public function verificar(Request $request)
    {
        $idCantera = $request->post('cantera');
        $updates = DB::table('canteras')->where('id_cantera', '=', $idCantera)->update(['status' => 'Verificada']);
        if ($updates) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }



    public function info_denegar(Request $request)
    {
        $idCantera = $request->post('cantera');
        $query = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif')
                ->where('canteras.id_cantera','=',$idCantera)->get();
        if ($query) {
            $html = '';
            $min = '';

            foreach ($query as $c) {
                //////////////minerales
                $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
                foreach ($minerales as $id_min) {
                    $id = $id_min->id_mineral;
                    $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                    if($query_min){
                        foreach ($query_min as $mineral) {
                            $name_mineral = $mineral->mineral;
                            $min .= '<span>'.$name_mineral.'</span>';
                        }
                    } 
                }

                ///////////datos cantera
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>                    
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Denegar la Verificación de la Cantera?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$c->nombre.'</h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <span class="fw-bold">Contribuyente</span>
                            <p class="text-center">'.$c->razon_social.' - '.$c->rif.'</p>
                            
                            <span class="fw-bold">Dirección</span>
                            <p class="text-center">'.$c->direccion.'</p>

                        
                            <span class="fw-bold">Producción</span>
                            <div class="d-flex flex-column text-center" id="info_produccion">
                               '.$min.'
                            </div>

                            <form id="denegar_cantera" method="post" onsubmit="event.preventDefault(); denegarCantera()">
                                
                                <div class="ms-2 me-2">
                                    <label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                                    <input type="hidden" name="id_cantera" value="'.$idCantera.'">
                                </div>
                                <div class="text-muted text-end" style="font-size:13px">
                                    <span class="text-danger">*</span> Campos Obligatorios
                                </div>
                            
                                <div class="mt-3 mb-2">
                                    <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                        </span>Las <span class="fw-bold">Observaciones </span>
                                        cumplen la función de notificar al <span class="fw-bold">Contribuyente</span>
                                        del porque la Cantera no ha sido verificada. Para que así, puedan rectificar y cumplir con el deber formal.
                                    </p>
                                </div>

                                <div class="d-flex justify-content-center m-3">
                                    <button type="submit" class="btn btn-danger btn-sm me-4">Denegar</button>
                                    <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>

                            
                        </div>';
                return response($html);
            }
        }
    }


    public function denegar(Request $request)
    {
        $idCantera = $request->post('id_cantera');
        $observacion = $request->post('observacion');

        $updates = DB::table('canteras')->where('id_cantera', '=', $idCantera)->update(['status' => 'Denegada', 'observaciones' => $observacion]);
        if ($updates) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
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
