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

    <div class="mb-3">
        <button type="button" class="btn btn-primary btn-sm" id="registrar_new_guia" data-bs-toggle="modal" data-bs-target="#modal_registro_guia"><i class='bx bx-plus'></i>Registrar guía</button>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-hover mt-3 text-center" style="font-size:14px;">
        <thead>
            <tr>
                <th scope="col">Nro. Guía</th>
                <th scope="col">Cantera</th>
                <th scope="col">Tipo de Mineral</th>
                <th scope="col">Cantidad Transportada</th>
                <th scope="col">Destinatario</th>
                <th scope="col">Destino</th>
                <th scope="col">Nro. Factura</th>
                <th scope="col">Tipo de Guia</th>
                <th scope="col">¿Anulada?</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($registros as $registro)
                    <tr role="button">
                        <td>{{$registro->nro_guia}}</td>
                        <td>{{$registro->nombre}}</td>
                        <td>{{$registro->mineral}}</td>
                        <td>{{$registro->cantidad}} {{$registro->unidad_medida}}</td>
                        <td>{{$registro->razon_destinatario}}</td>
                        <td>{{$registro->destino}}</td>
                        <td>{{$registro->nro_factura}}</td>
                        <td class="fst-italic text-secondary">{{$registro->tipo_guia}}</td>
                        <td>{{$registro->anulada}}</td>
                        <td>
                            <div class="d-flex">
                                <span class="badge me-1 delete_guia" style="background-color: #ed0000;" role="button" nro_guia="{{$registro->nro_guia}}">
                                    <i class='bx bx-trash-alt fs-6'></i>
                                </span>
                                <span class="badge" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_guia">
                                    <i class='bx bx-pencil fs-6'></i>
                                </span>
                            </div> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
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
                <div class="modal-body px-4" style="font-size:14px;" id="content_registro_guia">
                        
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
                        // alert(response);
                        // console.log(response);               
                        $('#content_registro_guia').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////MODAL: SELECCION DE CANTERA
            $(document).on('change','.select_cantera', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).val();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("registro_guia.cantera") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        // alert(response);
                        console.log(response);               
                        $('#select_minerales').html(response.minerales);
                        $('#direccion_cantera').html(response.direccion);
                       
                    },
                    error: function() {
                    }
                });
            });

            //////SELECION DE ANULADA: SI 
            $(document).on('click','#anulado_si', function(e) { 
                e.preventDefault(e); 
                $("#motivo_anulada").attr('disabled', false);
                // $("#anulado_si").attr('checked', true);
                // $("#anulado_no").attr('checked', false);
                
            });
             //////SELECION DE ANULADA: NO
            $(document).on('click','#anulado_no', function(e) { 
                e.preventDefault(e); 
                $("#motivo_anulada").attr('disabled', true);
                
            });

            //////ELIMINAR CANTERA
            $(document).on('click','.delete_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('nro_guia');
                // alert(guia);
                if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA GUÍA NRO.: " + guia + "?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("registro_guia.destroy") }}',
                        data: {guia:guia},
                        success: function(response) {
                            // alert(response);
                            if (response.success){
                                alert("GUÍA ELIMINADA EXITOSAMENTE");
                                window.location.href = "{{ route('registro_guia')}}";
                            } else{
                                alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA GUÍA");
                            }      
                        },
                        error: function() {
                        }
                    });
                }else{
                } 
            });


        });


        function registrarGuia(){
            var formData = new FormData(document.getElementById("form_registrar_guia"));
            console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("registro_guia.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('REGISTRO DE GUÍA EXITOSO');
                        $('#modal_registro_guia').modal('hide');
                        $('#form_registrar_guia')[0].reset();
                        window.location.href = "{{ route('registro_guia')}}";
                    } else {
                        alert('Ha ocurrido un error al registrar la guía.');
                    }  

                },
                error: function(error){
                    
                }
            });
        }
       
    </script>
    
@stop