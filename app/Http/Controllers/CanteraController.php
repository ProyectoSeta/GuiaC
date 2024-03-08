<?php

namespace App\Http\Controllers;
use App\Models\Users;
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
    public function show(string $id)
    {
        // $id_cantera = $request->post('cantera');
        // var_dump($id_cantera);
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
