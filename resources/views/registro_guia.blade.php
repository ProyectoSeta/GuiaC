@extends('adminlte::page')

@section('title', 'Registro de Guías')

@section('content_header')
    <h1>Libro de Control</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <p></p>

    <div class="">
        <button type="button" class="btn btn-primary btn-sm" id="registrar_new_guia" data-bs-toggle="modal" data-bs-target="#modal_registro_guia"><i class='bx bx-plus'></i>Registrar guía</button>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-hover mt-3 text-center" style="font-size:14px;">
            <tbody>
                <tr>
                    <th scope="col">Nro. Guía</th>
                    <th scope="col">Cantera</th>
                    <th scope="col">Tipo de Mineral</th>
                    <th scope="col">Metros</th>
                    <th scope="col">Toneladas</th>
                    <th scope="col">Destinatario</th>
                    <th scope="col">Rif Destinatario</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Nro. Factura</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Acciones</th>
                </tr>
                <tr>
                    <td>A00000125</td>
                    <td>Agua viva II</td>
                    <td>Polvillo</td>
                    <td class="fst-italic text-secondary">No Aplica</td>
                    <td>2,3</td>
                    <td>Ferrepontal, C.A.</td>
                    <td>J933200-1</td>
                    <td>Villa de cura Av. Sucre, Edif. Los samanes, local 3-55</td>
                    <td>5002</td>
                    <td>Salida</td>
                    <td>
                        <div class="d-flex">
                            <span class="badge me-1" style="background-color: #ed0000;" role="button" data-bs-toggle="modal" data-bs-target="#modal_delete_guia">
                                <i class='bx bx-trash-alt fs-6'></i>
                            </span>
                            <span class="badge" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_guia">
                                <i class='bx bx-pencil fs-6'></i>
                            </span>
                        </div>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                <a class="page-link">Anterior</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
       
    </div>


      

    
    
  <!--****************** MODALES **************************-->
    <!-- ********* NUEVA GUIA ******** -->
    <div class="modal" id="modal_registro_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel" style="color: #0072ff">
                        <i class='bx bx-barcode fs-1 me-2'></i>
                        Registro de Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4" style="font-size:14px;">
                    <form>
                        <div class="text-end fs-5 fw-bold text-muted py-2">
                            <span class="text-danger">Nro° Guía </span><span>000001</span>
                        </div>

                        <div class="row px-3">
                            <div class="col-sm-4">
                                <!-- fecha de emision -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-5">
                                        <label for="fecha" class="col-form-label">Fecha Emisión: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-7">
                                        <input type="date" id="fecha" class="form-control form-control-sm" name="fecha_emision" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- tipo de guia -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="" class="col-form-label">Tipo Guía: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_guia" required>
                                            <option selected>...</option>
                                            <option value="Entrada">Entrada</option>
                                            <option value="Salida">Salida</option>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- cantera -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select form-select-sm" aria-label="Small select example" name="cantera" required>
                                            <option selected>...</option>
                                            <option value="1">Agua Viva I</option>
                                            <option value="2">El Paito</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>

                        <div class="row">
                            <div class="col-sm-6 px-4">
                                <!-- razon social -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="razon" class="col-form-label">Razon social: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="razon" class="form-control form-control-sm" name="razon_dest" placeholder="Ejemplo: Razon Social, C.A." required>
                                    </div>
                                </div>

                                <!-- telefono del destinatario  -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="tlf_dest" class="col-form-label">Telefono: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="tlf_dest" class="form-control form-control-sm" name="tlf_dest" placeholder="Ejemplo: 0414-0000000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 px-4">
                                <!-- ci del destinatario -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="ci" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="ci" class="form-control form-control-sm" name="ci_dest" placeholder="Ejemplo: V00000000" required>
                                    </div>
                                </div>

                                <!-- destino -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="destino" class="col-form-label">Destino: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="destino" class="form-control form-control-sm" name="destino" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>

                        <div class="row px-3">
                            <div class="col-sm-5">
                                <!-- mineral no metalico -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-5">
                                        <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-7">
                                        <select class="form-select form-select-sm" aria-label="Small select example" name="mineral" required>
                                            <option selected>...</option>
                                            <option value="1"></option>
                                            <option value="2"></option>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <!-- cantidad -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" aria-label="Small select example" name="tipo_medida" required>
                                            <option selected>Tipo de medida</option>
                                            <option value="tonelada">Toneladas</option>
                                            <option value="metro_cubico">Metros Cúbicos</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="cantidad" class="form-control form-control-sm" name="cantidad" placeholder="Cantidad" required>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>

                        <div class="row">
                            <div class="col-sm-6 px-4">
                                <!-- modelo del vehiculo -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="modelo" class="col-form-label">Modelo Vehículo: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="modelo" class="form-control form-control-sm" name="modelo" placeholder="Ejemplo: Camion Plataforma Ford F-350" required>
                                    </div>
                                </div>

                                <!-- Nombre del conductor  -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="nombre_conductor" class="col-form-label">Nombre Conductor: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="nombre_conductor" class="form-control form-control-sm" name="nombre_conductor" placeholder="Ejemplo: Juan Castillo" required>
                                    </div>
                                </div>

                                <!-- telefono del conductor  -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="tlf_conductor" class="col-form-label">Telefono Conductor: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="tlf_conductor" class="form-control form-control-sm" name="tlf_conductor" placeholder="Ejemplo: 04140000000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 px-4">
                                <!-- placa -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="placa" class="col-form-label">Placa: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="placa" class="form-control form-control-sm" name="placa" placeholder="Ejemplo: AB123CD" required>
                                    </div>
                                </div>

                                <!-- ci conductor -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="ci_conductor" class="col-form-label">C.I.: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="ci_conductor" class="form-control form-control-sm" name="ci_conductor" placeholder="Ejemplo: V0000000" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de Circulación</p>
                        
                        <div class="row">
                            <div class="col-sm-6 px-4">
                                <!-- hora de Salida -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="hora_salida" class="col-form-label">Hora de Salida: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="hora_salida" class="form-control form-control-sm" name="hora_salida" placeholder="Ejemplo: 5:30 AM" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 px-4">
                                <!-- hora de llegada -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-4">
                                        <label for="hora_llegada" class="col-form-label">Hora de Llegada: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="hora_llegada" class="form-control form-control-sm" name="hora_llegada" placeholder="Ejemplo: 6:45 AM" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- otros datos -->
                        <div class="row px-2">
                            <div class="col-sm-3">
                                <!-- nro factura -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-6">
                                        <label for="factura" class="col-form-label">Nro° Factura: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" id="factura" class="form-control form-control-sm" name="nro_factura" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- anulada -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-5">
                                        <label for="" class="col-form-label">¿Anulada?: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-check form-check-inline ">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_si" value="Si">
                                            <label class="form-check-label" for="anulado_si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="anulada" id="anulado_no" value="No" checked>
                                            <label class="form-check-label" for="anulado_no">
                                                No
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- motivo de anulacion -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-3">
                                        <label for="motivo_anulada" class="col-form-label">Motivo: <span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="motivo_anulada" class="form-control form-control-sm" name="motivo" placeholder="Elemplo: Por tachaduras" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end fs-5 fw-bold text-muted py-2">
                            <span class=" text-danger">Nro° Control </span><span>CNZE6ZVZ70</span>
                        </div>

                        <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>
                        <div class="d-flex justify-content-center mt-3 mb-3" >
                            <button type="submit" class="btn btn-primary btn-sm me-3">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    

                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* ELIMINAR GUIA ******** -->
    <div class="modal" id="modal_delete_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Eliminar Guía</h1>
                    </div>
                    
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body" style="font-size:14px;">
                    
                    <p class="text-center">¿Desea eliminar la guía registrada con los siguientes datos?</p>

                    <table class="table">
                        <tr>
                            <th>Nro. Guía</th>
                            <td>A00000125</td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td class="text-muted">12/02/2024</td>
                        </tr>
                        <tr>
                            <th>Cantera</th>
                            <td>Agua Viva II</td>
                        </tr>

                        <tr>
                            <th>Razon social del destinatario</th>
                            <td>Ferrepontal, C.A.</td>
                        </tr>                    
                        <tr>
                            <th>Tipo de mineral</th>
                            <td>Gravilla</td>
                        </tr>  
                        <tr>
                            <th>Cantidad</th>
                            <td>2,5 Toneladas</td>
                        </tr>
                        <tr>
                            <th>Tipo de guía</th>
                            <td>Salida</td>
                        </tr>
                        <tr>
                            <th>Nro. Factura</th>
                            <td>125</td>
                        </tr>
                        <tr>
                            <th>Anulada</th>
                            <td>No</td>
                        </tr>
                    </table>

                    

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
                    </div> 


                 </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* EDITAR GUIA ******** -->
    <div class="modal" id="modal_editar_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff">
                    <!-- <i class='bx bxs-file-plus'></i> -->
                        Editar Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:14px;">
                    
                    <div class="row">
                        <div class="col-6">
                           <!-- Nro Guia -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Nro. Guía <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="" class="form-control form-control-sm"   value="A00000125">
                                </div>
                            </div>

                            <!-- cantera -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Cantera <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="" class="form-control form-control-sm"    value="Agua Viva II">
                                </div>
                            </div>

                            <!-- razon dest -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Razon social del destinatario <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="" class="form-control form-control-sm"   value="Ferrepontal, C.A.">
                                </div>
                            </div>

                             <!-- tipo mineral -->
                             <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Tipo de mineral <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm" aria-label="Small select example">
                                        <option >...</option>
                                        <option value="1">Piedra picada</option>
                                        <option value="2">Arena lavada</option>
                                        <option selected value="3">Gravilla</option>
                                        <option value="3">Otro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- cantidad -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Cantidad <span style="color:red">*</span></label>
                                </div>
                                <div class="col-4">
                                    <select class="form-select form-select-sm" aria-label="Small select example">
                                        <option selected value="1">Toneladas</option>
                                        <option value="2">Metros cubicos</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" id="" class="form-control form-control-sm"    value="2,3">
                                </div>
                            </div>

                            <!-- nro factura -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Nro. Factura <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="" class="form-control form-control-sm"    value="5002">
                                </div>
                            </div>
                        </div>   <!--   cierra col-6 -->

                        <div class="col-6">
                            <!-- Fecha -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Fecha <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="" class="form-control form-control-sm" value="12-02-2024">
                                </div>
                            </div>

                            <!-- destino -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Lugar de destino <span style="color:red">*</span></label>
                                </div>
                                <div class="col-8">
                                    <input type="text" id="" class="form-control form-control-sm"     value="Villa de cura Av. Sucre, Edif. Los samanes, local 3-55">
                                </div>
                            </div>

                            <!-- rif dest -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Rif del destinatario <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="" class="form-control form-control-sm"     value="J933200-1">
                                </div>
                            </div>

                            <!-- otro mineral -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Especifique</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" disabled id="" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- tipo mineral -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Tipo de guía <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm" aria-label="Small select example">
                                        <option value="1">Salida</option>
                                        <option value="2">Entrada</option>
                                    </select>
                                </div>
                            </div>

                            <!-- anulado -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-4">
                                    <label for="" class="col-form-label">Anulada <span style="color:red">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="anulado" id="anulado_si">
                                        <label class="form-check-label" for="anulado_si">
                                            Si
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="anulado" id="anulado_no" checked>
                                        <label class="form-check-label" for="anulado_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> <!--   cierra col-6 -->
                    </div>
                    
                    <p class="text-muted"><span style="color:red">*</span> Campos requeridos.</p>

                    <div class="d-flex justify-content-center mt-3 mb-3" >
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm">Guardar</button>
                    </div>

                 </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


<!--************************************************-->



    




@stop





@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
<script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
                {
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No se encuentran Registros",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        'search':"Buscar",
                        'paginate':{
                            'next':'Siguiente',
                            'previous':'Anterior'
                        }
                    }
                }
            );

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            ///////MODAL: INFO SOLICITUD DENEGADA
            $(document).on('click','#registrar_new_guia', function(e) { 
                e.preventDefault(e); 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("registro_guia.modal_registro") }}',
                    success: function(response) {
                        alert(response);
                        console.log(response);               
                        // $('#content_info_denegada').html(response);
                    },
                    error: function() {
                    }
                });
            });
        });
    </script>
    
@stop