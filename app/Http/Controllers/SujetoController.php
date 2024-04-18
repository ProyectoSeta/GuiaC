<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class SujetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sujeto = SujetoPasivo::all();
        return view('sujeto',compact('sujeto'));
    }

    public function representante(Request $request)
    {
        $idSujeto = $request->post('sujeto');
       
        $representante = DB::table('sujeto_pasivos')->select('ci_condicion_repr','ci_nro_repr','rif_condicion_repr','rif_nro_repr','name_repr','tlf_repr')->where('id_sujeto','=',$idSujeto)->get();
         if ($representante) {
            $html='';
            foreach ($representante as $repr) {
                $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-briefcase-alt fs-1" style="color:#c14900"></i>
                                <h1 class="modal-title fs-5" id="" style="color: #0072ff">Datos del Representante</h1>
                                <h5 class="modal-title" id="" style="font-size:14px">Sujeto Pasivo</h5>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <div>
                                <table class="table table-borderless text-center">
                                    <tr>
                                        <th>Nombre y Apellido</th>
                                        <td>'.$repr->name_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>R.I.F.</th>
                                        <td>'.$repr->rif_condicion_repr.'-'.$repr->rif_nro_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>C.I.</th>
                                        <td>'.$repr->ci_condicion_repr.'-'.$repr->ci_nro_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono</th>
                                        <td>'.$repr->tlf_repr.'</td>
                                    </tr>
                                </table>
                            </div>';
            }
            return response($html);
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
