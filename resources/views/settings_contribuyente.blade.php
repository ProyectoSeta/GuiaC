@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
  <div class="container rounded-4 p-3" style="background-color:#ffff;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-3 text-navy titulo">Configuración del Usuario</h3>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card card-widget widget-user">
                <div class="widget-user-header text-white" id="widget_user" style="background: url('{{asset('assets/img2.png')}}') center center; background-size: cover;">
                    <h3 class="widget-user-username text-right fw-bold" style="font-size:18px">{{ $sp->razon_social }}</h3>
                    <h5 class="widget-user-desc text-right">{{ $sp->rif_condicion }}-{{ $sp->rif_nro }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{asset('assets/user3.jpg')}}" alt="User Avatar">
                </div>
                <div class="card-footer pt-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $canteras->total }}</h5>
                                <span class="description-text">CANTERAS</span>
                            </div>
                        </div>
                        @php
                            $verificado = '';
                            switch ($sp->estado) {
                                case 'Verificando':
                                    $verificado = 'No';
                                    break;
                                case 'Verificado':
                                    $verificado = 'Si';
                                    break;
                                case 'Rechazado':
                                    $verificado = 'Rechazado';
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        @endphp
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $verificado }}</h5>
                                <span class="description-text">VERIFICADO</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Datos del Usuario</a>
            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Datos del Contribuyente</a>
            <a class="list-group-item list-group-item-action" id="list-representante-list" data-bs-toggle="list" href="#list-representante" role="tab" aria-controls="list-profile">Representante Legal</a>
            </div>
        </div>


        <div class="col-sm-8">
            <div class="tab-content" id="nav-tabContent">
                <!-- //////////////////////////CONTENIDO: DATOS USUARIO ///////////////////////// -->
                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list" style="font-size:14px;">
                    <p class="text-center fw-bold fs-4" >Datos del <span class="text-navy">Usuario</span></p>
                    <form action="">
                        <div class="campos_edit_user">
                            <div class="mb-3">
                                <label class="form-label" for="correo">Correo Electrónico</label><span class="text-danger">*</span>
                                <input type="email" id="correo" name="correo" class="form-control form-control-sm" value="{{ $sp->email}}" placeholder="example@gmail.com" disabled>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                   <div class="mb-3">
                                        <label class="form-label" for="pass">Contraseña</label><span class="text-danger">*</span>
                                        <input type="email" id="pass" name="pass" class="form-control form-control-sm" value="" disabled>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label class="form-label" for="confirmar">Confirmar Contraseña</label><span class="text-danger">*</span>
                                        <input type="email" id="confirmar" name="confirmar" class="form-control form-control-sm" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                        
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn bg-gradient-navy text-white btn-sm">Editar datos</button>
                        </div>

                        <!-- <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-sm me-3">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm">Cancelar</button>
                        </div> -->
                    </form>
                </div>


                <!-- //////////////////////////CONTENIDO: DATOS CONTRIBUYENTE ///////////////////////// -->
                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list" style="font-size:14px;">
                    <p class="text-center fw-bold fs-4" >Datos del <span style="color:#0d6efd">Contribuyente</span></p>
                    <form id="form_editar_contribuyente" method="post" onsubmit="event.preventDefault(); editarContribuyente()" >
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label" for="firstName">R.I.F.</label><span class="text-danger">*</span>
                                    <div class="row">
                                        <div class="col-4">
                                            <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion" disabled>
                                                @php
                                                    if($sp->rif_condicion == 'G'){
                                                @endphp
                                                    <option value="G" id="rif_gubernamental">G</option>
                                                    <option value="J" id="rif_juridico">J</option>
                                                @php
                                                    }else{
                                                @endphp
                                                    <option value="J" id="rif_juridico">J</option>
                                                    <option value="G" id="rif_gubernamental">G</option>
                                                @php  
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                        
                                        <div class="col-8">
                                            <input type="number" id="rif_nro" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" value="{{ $sp->rif_nro}}" disabled>
                                            <!-- <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger">*</span>
                                    <input type="text" id="razon_social" name="razon_social" class="form-control form-control-sm" value="{{ $sp->razon_social}}" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="direccion">Dirección</label><span class="text-danger">*</span>
                            <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" value="{{ $sp->direccion}}" disabled>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tlf_movil">Teléfono Móvil</label><span class="text-danger">*</span>
                                    <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" value="{{ $sp->tlf_movil}}" placeholder="Ejemplo: 04125231102" disabled>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tlf_fijo">Teléfono Fijo</label><span class="text-danger">*</span>
                                    <input type="number" id="tlf_fijo" class="form-control form-control-sm" name="tlf_fijo" value="{{ $sp->tlf_fijo}}" placeholder="Ejemplo: 02432632201" disabled>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 02432632201</p>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="">
                            <label class="form-label" for="state">¿Empresa Artesanal?</label><span class="text-danger">*</span>
                            @php
                                if($sp->artesanal == 'No'){
                            @endphp
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineRadio1">No</label>
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_no" value="No" checked disabled>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineRadio2">Si</label>
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_si" value="Si" disabled>
                                </div>
                            @php
                                }else{
                            @endphp
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineRadio1">No</label>
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_no" value="No" checked disabled>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineRadio2">Si</label>
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_si" value="Si" checked disabled>
                                </div>
                            @php  
                                }
                            @endphp
                            
                        </div> -->
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                        <input type="hidden" value="{{$sp->id_sujeto}}" name="id_sujeto">

                        <div class="d-flex justify-content-center" id="btn_editar_contribuyente">
                            <button type="button" class="btn btn-primary btn-sm" id="editar_datos_contribuyente">Editar datos</button>
                        </div>

                        <div class="d-flex justify-content-center d-none" id="btns_save_edit_cont">
                            <button type="submit" class="btn btn-success btn-sm me-3">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="cancelar_edit_cont">Cancelar</button>
                        </div>
                       
                    </form>

                </div>


                <!-- //////////////////////////CONTENIDO: DATOS REPRESENTANTE ///////////////////////// -->
                <div class="tab-pane fade" id="list-representante" role="tabpanel" aria-labelledby="list-representante-list" style="font-size:14px;">
                    <p class="text-center fw-bold fs-4" >Datos del <span style="color:#0d6efd">Representante</span></p>
                    <form id="form_editar_repr" method="post" onsubmit="event.preventDefault(); editarRepresentante()">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="ci_condicion_repr">C.I. del Representante</label><span class="text-danger">*</span>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" id="ci_condicion_repr" aria-label="Default select example" name="ci_condicion_repr" disabled>
                                            @php
                                                if($sp->ci_condicion_repr == 'V'){
                                            @endphp
                                                <option value="V">V</option>
                                                <option value="E">E</option>
                                            @php
                                                }else{
                                            @endphp
                                                <option value="E">E</option>
                                                <option value="V">V</option>
                                            @php  
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    
                                    <div class="col-8">
                                        <input type="number" id="ci_nro_repr" class="form-control form-control-sm" name="ci_nro_repr" value="{{ $sp->ci_nro_repr}}" placeholder="Ejemplo: 8456122" disabled>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="rif_nro">R.I.F.</label><span class="text-danger">*</span>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" id="rif_condicion_repr" aria-label="Default select example" name="rif_condicion_repr" disabled>
                                            @php
                                                if($sp->rif_condicion_repr == 'V'){
                                            @endphp
                                                <option value="V">V</option>
                                                <option value="E">E</option>
                                            @php
                                                }else{
                                            @endphp
                                                <option value="E">E</option>
                                                <option value="V">V</option>
                                            @php  
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    
                                    <div class="col-8">
                                        <input type="number" id="rif_nro_repr" class="form-control form-control-sm" name="rif_nro_repr" value="{{ $sp->rif_nro_repr}}" placeholder="Ejemplo: 084561221" disabled>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 084561221</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="form-label" for="nombre_repr">Nombre y Apellido</label><span class="text-danger">*</span>
                                <input type="text" id="nombre_repr" class="form-control form-control-sm" name="name_repr" value="{{ $sp->name_repr}}" disabled>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="tlf_movil_repr">Teléfono móvil</label><span class="text-danger">*</span>
                                <input type="number" id="tlf_movil_repr" class="form-control form-control-sm" name="tlf_repr" value="{{ $sp->tlf_repr}}" disabled>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                            </div>
                        </div>
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                        <input type="hidden" value="{{$sp->id_sujeto}}" name="id_sujeto">

                        <div class="d-flex justify-content-center" id="btn_editar_repr">
                            <button type="button" class="btn btn-primary btn-sm" id="editar_datos_repr">Editar datos</button>
                        </div>

                        <div class="d-flex justify-content-center d-none" id="btns_save_edit_repr">
                            <button type="submit" class="btn btn-success btn-sm me-3">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="cancelar_edit_repr">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>






  </div>
    

    
    
<!--****************** MODALES **************************-->
    

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
            ///////DATOS CONTRIBUYENTE
            $(document).on('click','#editar_datos_contribuyente', function(e) { 
                e.preventDefault(e); 
                $("#razon_social").attr('disabled', false);
                $("#direccion").attr('disabled', false);
                $("#tlf_movil").attr('disabled', false);
                $("#tlf_fijo").attr('disabled', false);

                $("#editar_datos_contribuyente").addClass('d-none');
                $('#btns_save_edit_cont').removeClass('d-none');
            });

            ///////CANCELAR: DATOS CONTRIBUYENTE
            $(document).on('click','#cancelar_edit_cont', function(e) { 
                e.preventDefault(e); 
                $("#razon_social").attr('disabled', true);
                $("#direccion").attr('disabled', true);
                $("#tlf_movil").attr('disabled', true);
                $("#tlf_fijo").attr('disabled', true);

                $("#editar_datos_contribuyente").removeClass('d-none');
                $('#btns_save_edit_cont').addClass('d-none');
               
            });

            ///////DATOS REPRESENTENTE
            $(document).on('click','#editar_datos_repr', function(e) { 
                e.preventDefault(e); 
                $("#rif_condicion_repr").attr('disabled', false);
                $("#rif_nro_repr").attr('disabled', false);
                $("#ci_condicion_repr").attr('disabled', false);
                $("#ci_nro_repr").attr('disabled', false);
                $("#nombre_repr").attr('disabled', false);
                $("#tlf_movil_repr").attr('disabled', false);

                $("#btn_editar_repr").addClass('d-none');
                $('#btns_save_edit_repr').removeClass('d-none');
            });

            ///////CANCELAR: DATOS REPRESENTENTE
            $(document).on('click','#cancelar_edit_repr', function(e) { 
                e.preventDefault(e); 
                $("#rif_condicion_repr").attr('disabled', true);
                $("#rif_nro_repr").attr('disabled', true);
                $("#ci_condicion_repr").attr('disabled', true);
                $("#ci_nro_repr").attr('disabled', true);
                $("#nombre_repr").attr('disabled', true);
                $("#tlf_movil_repr").attr('disabled', true);

                $("#btn_editar_repr").removeClass('d-none');
                $('#btns_save_edit_repr').addClass('d-none');
               
            });

        });

        function editarRepresentante(){
            var formData = new FormData(document.getElementById("form_editar_repr"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("settings_contribuyente.representante") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        if (response.success) {
                            alert('ACTUALIZACIÓN DE DATOS EXITOSO');
                            window.location.href = "{{ route('settings_contribuyente')}}";
                        } else {
                            alert('Ha ocurrido un error al Actualizar los Datos.');
                        } 

                    },
                    error: function(error){
                        
                    }
                });
        }

        function editarContribuyente(){
            var formData = new FormData(document.getElementById("form_editar_contribuyente"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("settings_contribuyente.contribuyente") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('ACTUALIZACIÓN DE DATOS EXITOSO');
                        window.location.href = "{{ route('settings_contribuyente')}}";
                    } else {
                        alert('Ha ocurrido un error al Actualizar los Datos.');
                    } 
                },
                error: function(error){
                }
            });
        }
        
    </script>
  
@stop