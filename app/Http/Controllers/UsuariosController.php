<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sujetos = DB::table('sujeto_pasivos')
            ->join('users', 'sujeto_pasivos.id_user', '=', 'users.id')
            ->select('sujeto_pasivos.id_sujeto', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'users.id', 'users.name','users.email', 'users.created_at')
            ->where('users.type',3)
            ->get();
        $admins = DB::table('users')
            ->select('id', 'name','email', 'created_at')
            ->where('type',4)
            ->get();
        return view('usuarios', compact('sujetos', 'admins'));
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
        $pass = $request->post('pass');
        $confirmar = $request->post('confirmar');

        if($pass == $confirmar){
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'confirmed', Password::min(8)
                ->letters() // Requerir al menos una letra...
                ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
                ->numbers() // Requerir al menos un número...
                ->symbols() // Requerir al menos un símbolo...
                ->uncompromised()],
                'email' => 'required|unique:users|email',
            ]);

            if ($validator->fails()) {
                // return $validator->errors();
                return response()->json(['success' => false, 'nota' => $validator->errors()]);
            }else{

            }

        }else{
            return response()->json(['success' => false, 'nota' => 'Las contraseñas no son iguales. Por favor, verifique.']);
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
