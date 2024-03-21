<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class VerificarUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sujetos = DB::table('sujeto_pasivos')->where('estado','=','Verificando')->get();
        return view('verificar_user',compact('sujetos'));
    }

    public function info(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $query = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->get();
        if ($query) {
            foreach ($query as $sujeto) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2"></i>                       
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar al siguiente Sujeto pasivo?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5" id="" style="color: #0072ff">'.$sujeto->razon_social.'</h1>
                                    <h5 class="modal-title" id="" style="font-size:14px">'.$sujeto->rif.'</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                            <table class="table" style="font-size:14px">
                                <tr>
                                    <th>Tipo de Contribuyente</th>
                                    <td>'.$sujeto->tipo_sujeto.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F.</th>
                                    <td>'.$sujeto->rif.'</td>
                                </tr>
                                <tr>
                                    <th>Razon Social</th>
                                    <td>'.$sujeto->razon_social.'</td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>'.$sujeto->direccion.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono móvil</th>
                                    <td>'.$sujeto->tlf_movil.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono fijo</th>
                                    <td>'.$sujeto->tlf_fijo.'</td>
                                </tr>
                            </table>

                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Representante</h6>
                            <table class="table"  style="font-size:14px">
                                <tr>
                                    <th>C.I. del representante</th>
                                    <td>'.$sujeto->ci_repr.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F. del representante</th>
                                    <td>'.$sujeto->rif_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Nombre y Apellido</th>
                                    <td>'.$sujeto->name_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono movil</th>
                                    <td>'.$sujeto->tlf_repr.'</td>
                                </tr>
                            </table>   

                            <h6 class="text-muted text-center" style="font-size:14px;">Límite de Guías</h6>
                  
                                <div class="row m-3 mb-4">
                                    <label for="limite" class="col-sm-8 col-form-label">Límite de Guías Solicitadas por Mes</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="limite" id="limite">
                                    </div>
                                </div> 
                                <div class="d-flex justify-content-center my-2">
                                    <button class="btn btn-success btn-sm me-4" id="aprobar_sujeto_pasivo" id_sujeto="'.$idSujeto.'">Aprobar</button>
                                    <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                </div>

 
                        </div>';
                        
                return response($html);
                
            }
        }
    }

    public function aprobar(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $limite = $request->post('limite');
        $mes_actual = date("F");
        return($limite);

        // $insert = DB::table('limite_guias')->insert(['id_sujeto' => $idSujeto, 'total_guias_mes'=>$limite, 'mes_actual' => $mes_actual, 'total_guias_solicitadas_mes' => '0']);
        // $update = DB::table('sujeto_pasivos')->where('id_sujeto', '=', $idSujeto)->update(['estado' => 'Verificado']);
        // if ($insert &&$update) {
        //     return response()->json(['success' => true]);
        // }else{
        //     return response()->json(['success' => false]);
        // }
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
