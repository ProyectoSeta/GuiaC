<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\User;
use App\Models\SujetoPasivo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $usuario = User::create([
            'name'=>$request->post('name'),
            'email'=>$request->post('email'),
            'password'=>bcrypt($request->post('password'))
        ]);
        if($usuario->save()){ // insercion en la tabla User creando el usuario
            $identificador = $usuario->id; // Aca se Obtiene el ID del usuario creado
            $sujeto = new SujetoPasivo(); // SE llama al modelo sujetopasivo
            $sujeto = SujetoPasivo::create([
                    'id_user'=>$identificador,
                    'tipo_sujeto' => $request->post('tipo_sujeto'),
                    'rif' => $request->post('rif'),
                    'razon_social' => $request->post('razon_social'),
                    'direccion' => $request->post('direccion'),
                    'tlf_movil' => $request->post('tlf_movil'),
                    'tlf_fijo' => $request->post('tlf_fijo'),
                    'ci_repr' => $request->post('ci_repr'),
                    'rif_repr' => $request->post('rif_repr'),
                    'name_repr' => $request->post('name_repr'),
                    'tlf_repr' => $request->post('tlf_repr')
            ]);
            if ($sujeto->save()) { //insercion en la tabla sujeto pasivo
                return redirect()->route("home"); // Redirecciona a el controlador que se necesite
            }
        }
                
        return $id;
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
