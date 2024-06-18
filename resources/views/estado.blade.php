@extends('adminlte::page')

@section('title', 'Estado - Solicitudes')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-0" style="background-color:#ffff;">
        <div class="d-flex justify-content-between mt-2">
            <div class="">
                <h3 class="mb-1 mt-3 text-navy titulo">Actualización de Estado</h3>
                <span class="text-muted" style="font-size:15px">Talonarios a generar - Correlativos asignados - Talonarios Recibidos</span><br>
                <span class="text-navy" style="font-size:15px">Procesando un Total de: {{$count->total}} Solicitude(s)</span>
            </div>

            <div class="row w-50">
                <div class="col-sm-6">
                    <div class="card shadow-none border-light-subtle">
                        <div class="card-body px-3 py-2">
                            <h3 class="d-flex align-items-center justify-content-between mb-0 pb-1">
                                <div class="p-2 border border-primary grd-primary-light rounded-5 d-flex">
                                    <i class='bx bx-refresh bx-spin fs-3 text-primary' ></i>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <span class="fs-6 pb-1">En Proceso</span>
                                    <span class="text-primary">{{$count_proceso->total}}</span> 
                                </div>
                            </h3>

                            <div class="d-flex align-items-center justify-content-between" style="font-size:13px">
                                <span class="text-muted">Solicitudes en proceso</span>
                                <span class="badge bg-primary text-primary bg-opacity-10 ">{{$porcentaje_proceso}}%</span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="card shadow-none border-light-subtle">
                        <div class="card-body px-3 py-2">
                            <h3 class="d-flex align-items-center justify-content-between mb-0 pb-1">
                                <div class="p-2 border border-warning-subtle grd-warning-light rounded-5 d-flex">
                                    <i class='bx bx-error-circle bx-tada fs-3' style="color:#ff8f00"></i>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <span class="fs-6 pb-1">Por Retirar</span>
                                    <span class="" style="color:#ff8f00">{{$count_retirar->total}}</span> 
                                </div>
                            </h3>

                            <div class="d-flex align-items-center justify-content-between" style="font-size:13px">
                                <span class="text-muted">Talonarios por retirar</span>
                                <span class="badge bg-opacity-10" style="color:#ff8f00; background:#fff2e2">{{$porcentaje_retirar}}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- contenido -->
        <!-- nav - option -->
        <ul class="nav nav-tabs d-flex justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" id="list-enviar-list" data-bs-toggle="list" href="#list-enviar" role="tab" aria-controls="list-enviar">Enviar a Imprenta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-admin-list" data-bs-toggle="list" href="#list-admin" role="tab" aria-controls="list-admin">Enviados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-admin-list" data-bs-toggle="list" href="#list-admin" role="tab" aria-controls="list-admin">Recibidos</a>
            </li>
        </ul>

        <!-- contenido - nav - option -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: USUARIOS CONTRIBUYENTE -->
            <div class="tab-pane fade show active" id="list-enviar" role="tabpanel" aria-labelledby="list-enviar-list">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center mt-2 mb-0 me-3"><i class='bx bx-printer fs-5 me-2'></i><span>Reporte</span></button>
                    <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center mt-2 mb-0"><i class='bx bxs-collection fs-5 me-2'></i></i><span>Lote Enviado</span></button>
                </div>
                <div class="table-responsive" style="font-size:14px">
                    <table id="enviados" class="table  border-light-subtle text-center" style="width:100%; font-size:13px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">Cod. Talonario</th>
                                    <th scope="col">Cantera</th>
                                    <th scope="col">Contribuyente</th>
                                    <th scope="col">R.I.F</th>
                                    <th scope="col">Solicitud</th>
                                    <th scope="col">Correlativo</th>
                                    <th scope="col">Opcion</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($t_enviar as $enviar)
                                <tr>
                                    <td>{{$enviar->id_talonario}}</td>
                                    <td>{{$enviar->nombre_cantera}}</td>
                                    <td>{{$enviar->razon_social}}</td>
                                    <td>
                                        <a class="info_sujeto" role="button" id_sujeto='{{ $enviar->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$enviar->rif_condicion}}-{{$enviar->rif_nro}}</a>
                                    </td>
                                    <td>
                                        <a class="detalle_solicitud" id_solicitud="{{$enviar->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_detalles_solicitud">Ver</a>
                                    </td>
                                    @php
                                        $desde = $enviar->desde;
                                        $hasta = $enviar->hasta;
                                        $length = 6;
                                        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                    @endphp
                                    <td>{{$formato_desde}} - {{$formato_hasta}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary d-inline-flex align-items-center" type="button">
                                            Enviado
                                            <!-- <i class='bx bxs-chevron-right'></i> -->
                                            <i class='bx bx-chevron-right ms-2'></i>
                                            <!-- <i class='bx bx-chevron-right-circle ms-2'></i> -->
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- CONTENIDO: USUARIOS ADMINISTRATIVO -->
            <div class="tab-pane fade" id="list-admin" role="tabpanel" aria-labelledby="list-admin-list">
                <div class="table-responsive" style="font-size:14px">
                    <table id="" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Creado</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        

    </div>
   
    

      

    
    
<!--****************** MODALES **************************-->
   <!-- ********* INFO SUJETO ******** -->
   <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* DETALLES SOLICITUD ******** -->
    <div class="modal fade" id="modal_detalles_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>





    <!-- ********* APROBAR SOLICITUD ******** -->
    <!-- <div class="modal fade" id="modal_ver_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>
        </div>  
    </div> -->






    

    <!-- *********INFO SOLICITUD DENEGADA ******** -->
    <div class="modal" id="modal_info_denegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_denegada">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* MODAL ACTUALIZAR ESTADO ******** -->
    <div class="modal" id="modal_actualizar_estado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-refresh bx-spin  fs-1' style='color:#0d8a01' ></i>       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualización de Estado</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px" id="content_actualizar_estado">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                    
                    

                </div>
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
            $('#enviados').DataTable(
                {
                    "order": [[ 0, "desc" ]],
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

            $('#recibidos').DataTable(
                {
                    "order": [[ 0, "desc" ]],
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


            $('#enviados').DataTable(
                {
                    "order": [[ 0, "desc" ]],
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
            ///////MODAL: INFO SUJETO PASIVO
            $(document).on('click','.info_sujeto', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.sujeto") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {              
                        $('#html_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });


            ///////MODAL: VER SOLICITUD
            $(document).on('click','.detalle_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(solicitud);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.solicitud") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        // alert(response);
                        // console.log(response);
                        $('#content_ver_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO SOLICITUD DENEGADA
            $(document).on('click','.solicitud_denegada', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.info_denegada") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {
                        // console.log(response);               
                        $('#content_info_denegada').html(response);
                    },
                    error: function() {
                    }
                });
            });

             ///////MODAL: ACTUALIZAR ESTADO
             $(document).on('click','.actualizar_estado', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.actualizar") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {
                        console.log(response);               
                        $('#content_actualizar_estado').html(response);
                    },
                    error: function() {
                    }
                });
            });

        });


        function actualizarEstado(){
            var formData = new FormData(document.getElementById("form_actualizar_estado"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("estado.update") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        //alert(response);
                        if (response.success) {
                            alert('EL ESTADO DE LA SOLICITUD HA SIDO ACTUALIZADO CORRECTAMENTE');
                            window.location.href = "{{ route('estado')}}";
                        } else {
                            alert('Ha ocurrido un error al Actualizar el estado de la Solicitud.');
                        }    

                    },
                    error: function(error){
                        
                    }
                });
        }
    </script>
  
@stop