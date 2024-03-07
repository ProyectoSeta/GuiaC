<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\User;
use App\Models\Cantera;
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

        // var_dump($user);
        

        // $minerales = DB::table('produccions')->where('id_cantera', $id)->get();
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


        $cantera = Cantera::create([
            'id_sujeto'=> $id_sp,
            'direccion'=>$request->post('direccion'),
            'nombre'=>$request->post('nombre')
        ]);

        if($cantera->save()){ // insercion en la tabla cantera creando el usuario
            $identificador = $cantera->id; // Aca se Obtiene el ID del usuario creado
            $minerales = $request->post('mineral');
            $status_save = '';
            foreach ($minerales as $mineral) {
                $produccion = new Produccion(); // SE llama al modelo sujetopasivo
                $produccion = Produccion::create([
                    'id_cantera'=>$identificador,
                    'mineral' => $mineral
                ]);

                if($produccion->save()){
                    $status_save = true;
                }else{
                    $status_save = false;
                }
            }

            if($status_save == true){
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }


        } ////cierra if ($cantera->save())
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
