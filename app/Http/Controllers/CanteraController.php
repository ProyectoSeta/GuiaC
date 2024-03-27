<?php

namespace App\Http\Controllers;
// use App\Models\Users;
use App\Models\User;
use App\Models\Cantera;
use App\Models\Mineral;
use App\Models\SujetoPasivo;
use App\Models\Produccion;
use Illuminate\Http\Request;
use DB;

class CanteraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;
        $canteras = DB::table('canteras')->where('id_sujeto', $id_sp)->get();

       return view('cantera', compact('canteras'));

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
    public function store(Request $request){
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;

        $nombre = $request->post('nombre');
        $direccion = $request->post('direccion');

        $cantera = DB::table('canteras')->insert([
                                'id_sujeto' =>  $id_sp,
                                'nombre' => $nombre,
                                'direccion' => $direccion,
                                'status' => 'Verificando']);
        if($cantera){
            $id_cantera = DB::table('canteras')->max('id_cantera');
           
            $minerales = $request->post('mineral');
            foreach($minerales as $mineral){
                if($mineral != null){
                    $id_min = '';
                    $query_min = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();

                    if(count($query_min) > 0 ){
                        foreach ($query_min as $min) {
            
                            $id_min = $min->id_mineral;

                        }
                    }else{
                        ///el mineral NO existe en la tabla minerals
                        $new_min = DB::table('minerals')->insert(['mineral' => $mineral]);
                        if ($new_min) {
                            $query_new = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();
                            foreach ($query_new as $new) {
            
                                $id_min = $new->id_mineral;
    
                            }
                        }

                    }
                    // var_dump($id_min);
                    $produccions = DB::table('produccions')->insert(['id_cantera' => $id_cantera,'id_mineral' => $id_min]);
                    
                } /////cierra if ($mineral != null)
            }//////cierra foreach
            return response()->json(['success' => true]);
        } ///cierra if($cantera)
        else{
            return response()->json(['success' => false]);
         }       
    }

    /**
     * Display the specified resource.
     */

    public function minerales(Request $request)
    {
        $idCantera = $request->post('cantera');
        $query = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
         
        if($query){
            $html = '';
            foreach ($query as $id_min) {
                $id = $id_min->id_mineral;
                $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                if($query_min){
                    foreach ($query_min as $mineral) {
                        $name_mineral = $mineral->mineral;
                        $html .= '<span>'.$name_mineral.'</span>';
                    }
                } 
            }

            return response($html);

        }
    }

    
    public function info_denegada(Request $request){
        $idCantera = $request->post('cantera');
        $query = DB::table('canteras')->select('observaciones')->where('id_cantera','=',$idCantera)->get();

        if ($query) {
            $html='';
            foreach ($query as $c) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>
                                <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <span class="fw-bold">Observaciones de la Denegación</span>
                            <p class="mx-3 mt-1">'.$c->observaciones.'</p>

                            <div class="mt-3 mb-2">
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span>Las <span class="fw-bold">Observaciones </span>
                                    realizadas cumplen con el objetivo de notificarle
                                    del porque la Cantera no fue verificada. Para que así, pueda rectificar y cumplir con el deber formal.
                                </p>
                            </div>
                        </div>';

            }

            return response($html);
        }


    }

    public function show(Request $request){
        
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
    public function destroy(Request $request)
    {   
        $user = auth()->id();
        $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $id_sp = $sp->id_sujeto;

        $idCantera = $request->post('cantera');
        $conteo = DB::table('control_guias')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->get();
        if ($conteo) {
            foreach ($conteo as $c){
                if ($c->total == 0){
                    //////el usuario no ha registrado ninguna guia aun.
                    $delete = DB::table('canteras')->where('id_cantera', '=', $idCantera)->delete();

                    if($delete){
                        return response()->json(['success' => true]);
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    ////////el usuario ya ha registrado guias
                    return response()->json(['success' => 'sin permiso']);
                }
            }
        }else{
            return response()->json(['success' => false]);
        }

        
    }
}
