@extends('adminlte::page')

@section('title', 'Estado | Solicitudes')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-0" style="background-color:#ffff; font-size:14px">
        <div class="d-flex justify-content-between mt-2">
            <div class="">
                <h3 class="mb-1 mt-3 text-navy titulo">Actualización de Estado</h3>
                <span class="text-muted" style="font-size:15px">Talonarios a generar - Correlativos asignados - Talonarios Recibidos</span><br>
                <span class="text-muted fw-bold" style="font-size:15px">No. Total de Solicitudes en Proceso: <span class="text-navy">{{$count->total}} Solicitud(es)</span></span>
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
                <a class="nav-link active" id="list-enviar-list" data-bs-toggle="list" href="#list-enviar" role="tab" aria-controls="list-enviar">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bxl-telegram fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Imprenta</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Por Enviar</h6>
                        </div>
                    </div>
                </a>
                <!-- <a class="nav-link active" id="list-enviar-list" data-bs-toggle="list" href="#list-enviar" role="tab" aria-controls="list-enviar">Enviar a Imprenta</a> -->
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-enviados-list" data-bs-toggle="list" href="#list-enviados" role="tab" aria-controls="list-enviados">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-loader fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Imprenta</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Enviados</h6>
                        </div>
                    </div>
                </a>
                <!-- <a class="nav-link" id="list-enviados-list" data-bs-toggle="list" href="#list-enviados" role="tab" aria-controls="list-enviados">Enviados</a> -->
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-recibidos-list" data-bs-toggle="list" href="#list-recibidos" role="tab" aria-controls="list-recibidos">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-package fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Imprenta</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Recibidos</h6>
                        </div>
                    </div>
                </a>
                <!-- <a class="nav-link" id="list-admin-list" data-bs-toggle="list" href="#list-admin" role="tab" aria-controls="list-admin">Recibidos</a> -->
            </li>
        </ul>

        <!-- contenido - nav - option -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: TALONARIOS POR ENVIAR  -->
            <div class="tab-pane fade show active" id="list-enviar" role="tabpanel" aria-labelledby="list-enviar-list">
                <div class="d-flex justify-content-center mb-1 d-none" id="btn_enviar_all">
                    <button class="btn  btn-outline-primary btn-sm d-flex align-items-center" type="button" id="btn_talonarios_enviados" data-bs-toggle="modal" data-bs-target="#modal_talonarios_enviados">
                        <span>Talonarios enviados </span>
                        <i class='bx bxs-chevron-right ms-1'></i>
                    </button>
                </div>
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="enviar" class="table border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input fs-6" type="checkbox" value="" id="check_all_enviar">
                                        </div>
                                    </th>
                                    <th scope="col">Talonario</th>
                                    <th scope="col">Clase</th>
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
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input fs-6 check_enviar check_{{$enviar->id_talonario}}" type="checkbox" value="{{$enviar->id_talonario}}">
                                    </div>
                                </td>
                                <td class="text-secondary fw-bold">{{$enviar->id_talonario}}</td>

                                @if ($enviar->clase == 6)
                                    <td class="fw-bold text-navy">Reserva</td>
                                    <td class="text-secondary fst-italic">No aplica</td>
                                    <td class="text-secondary fst-italic">No aplica</td>
                                    <td class="text-secondary fst-italic">No aplica</td>
                                    <td class="text-secondary fst-italic">No aplica</td>
                                    @php
                                            $desde = $enviar->desde;
                                            $hasta = $enviar->hasta;
                                            $length = 6;
                                            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                        @endphp
                                    <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$enviar->id_talonario}}" type="button">
                                            <i class='bx bxs-chevron-right'></i>
                                        </button>
                                    </td>
                                @else <!-- **************************************************** -->
                                    <td class="fw-bold text-navy">Regular</td>
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
                                    <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$enviar->id_talonario}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_talonarios_enviados">
                                            <i class='bx bxs-chevron-right'></i>
                                        </button>
                                    </td>
                                @endif                                    
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- CONTENIDO: TALONARIOS ENVIADOS -->
            <div class="tab-pane fade" id="list-enviados" role="tabpanel" aria-labelledby="list-enviados-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="enviados" class="table display border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                            <tr>
                                <th scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input fs-6" type="checkbox" value="" id="check_all_recibido">
                                    </div>
                                </th>
                                <th scope="col">Talonario</th>
                                <th scope="col">Clase</th>
                                <th scope="col">Cantera</th>
                                <th scope="col">Contribuyente</th>
                                <th scope="col">R.I.F</th>
                                <th scope="col">Solicitud</th>
                                <th scope="col">Correlativo</th>
                                <th scope="col">Enviado</th>
                                <th scope="col">Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($t_enviados as $enviados)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-6 check_recibido" type="checkbox" value="{{$enviados->id_talonario}}">
                                        </div>
                                    </td>
                                    <td class="text-secondary fw-bold">{{$enviados->id_talonario}}</td>
                                    @if ($enviados->clase == 6)
                                        <td class="fw-bold text-navy">Reserva</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                            @php
                                                $desde = $enviados->desde;
                                                $hasta = $enviados->hasta;
                                                $length = 6;
                                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                            @endphp
                                        <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                        <td class="fw-bold text-secondary-emphasis table-light">{{$enviados->fecha_enviado_imprenta}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$enviados->id_talonario}}" type="button">
                                                <i class='bx bxs-chevron-right'></i>
                                            </button>
                                        </td>
                                    @else <!-- *************************** -->
                                        <td class="fw-bold text-navy">Regular</td>
                                        <td>{{$enviados->nombre_cantera}}</td>
                                        <td>{{$enviados->razon_social}}</td>
                                        <td>
                                            <a class="info_sujeto" role="button" id_sujeto='{{ $enviados->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$enviados->rif_condicion}}-{{$enviados->rif_nro}}</a>
                                        </td>
                                        <td>
                                            <a class="detalle_solicitud" id_solicitud="{{$enviados->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_detalles_solicitud">Ver</a>
                                        </td>
                                            @php
                                                $desde = $enviados->desde;
                                                $hasta = $enviados->hasta;
                                                $length = 6;
                                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                            @endphp
                                        <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                        <td class="fw-bold text-secondary-emphasis table-light">{{$enviados->fecha_enviado_imprenta}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$enviados->id_talonario}}" type="button" data-bs-toggle="tooltip" data-bs-title="Disabled tooltip">
                                                <i class='bx bxs-chevron-right'></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- CONTENIDO: TALONARIOS RECIBIDOS -->
            <div class="tab-pane fade" id="list-recibidos" role="tabpanel" aria-labelledby="list-recibidos-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="recibidos" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                    <thead class="bg-primary border-light-subtle">
                            <tr>
                                <th scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input fs-6" type="checkbox" value="" id="check_all_recibido">
                                    </div>
                                </th>
                                <th scope="col">Talonario</th>
                                <th scope="col">Clase</th>
                                <th scope="col">Cantera</th>
                                <th scope="col">Contribuyente</th>
                                <th scope="col">R.I.F</th>
                                <th scope="col">Solicitud</th>
                                <th scope="col">Correlativo</th>
                                <th scope="col">Enviado</th>
                                <th scope="col">Recibido</th>
                                <th scope="col">Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($t_recibidos as $recibidos)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-6 check_recibido" type="checkbox" value="{{$recibidos->id_talonario}}">
                                        </div>
                                    </td>
                                    <td class="text-secondary fw-bold">{{$recibidos->id_talonario}}</td>
                                    @if ($recibidos->clase == 6)
                                        <td class="fw-bold text-navy">Reserva</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                        <td class="text-secondary fst-italic">No aplica</td>
                                            @php
                                                $desde = $recibidos->desde;
                                                $hasta = $recibidos->hasta;
                                                $length = 6;
                                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                            @endphp
                                        <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                        <td class="fw-bold text-secondary-emphasis table-light">{{$recibidos->fecha_enviado_imprenta}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$recibidos->id_talonario}}" type="button">
                                                <i class='bx bxs-chevron-right'></i>
                                            </button>
                                        </td>
                                    @else <!-- *************************** -->
                                        <td class="fw-bold text-navy">Regular</td>
                                        <td>{{$recibidos->nombre_cantera}}</td>
                                        <td>{{$recibidos->razon_social}}</td>
                                        <td>
                                            <a class="info_sujeto" role="button" id_sujeto='{{ $recibidos->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$recibidos->rif_condicion}}-{{$recibidos->rif_nro}}</a>
                                        </td>
                                        <td>
                                            <a class="detalle_solicitud" id_solicitud="{{$recibidos->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_detalles_solicitud">Ver</a>
                                        </td>
                                            @php
                                                $desde = $recibidos->desde;
                                                $hasta = $recibidos->hasta;
                                                $length = 6;
                                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                            @endphp
                                        <td class="text-muted">{{$formato_desde}} - {{$formato_hasta}}</td>
                                        <td class="fw-bold text-secondary-emphasis table-light">{{$recibidos->fecha_enviado_imprenta}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary talonario_enviado d-inline-flex align-items-center" id_talonario="{{$recibidos->id_talonario}}" type="button" data-bs-toggle="tooltip" data-bs-title="Disabled tooltip">
                                                <i class='bx bxs-chevron-right'></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
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
    
    <!-- ********* TALONARIOS ENVIADOS ******** -->
    <div class="modal" id="modal_talonarios_enviados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_talonarios_enviados">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
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
            $('#enviar').DataTable({   
                ordering: false,  
                "order": [[ 0, "asc" ]],
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
            });

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


            ///////BTN: TALONARIO ENVIADO 
            $(document).on('click','.talonario_enviado', function(e) { 
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


            // ///////MODAL: INFO SOLICITUD DENEGADA
            // $(document).on('click','.solicitud_denegada', function(e) { 
            //     e.preventDefault(e); 
            //     var solicitud = $(this).attr('id_solicitud');
            //     // alert(cantera);
            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("estado.info_denegada") }}',
            //         data: {solicitud:solicitud},
            //         success: function(response) {
            //             // console.log(response);               
            //             $('#content_info_denegada').html(response);
            //         },
            //         error: function() {
            //         }
            //     });
            // });
        


            $i = 0;
            ////////SELECCIONAR TODOS LOS CHECKBOX
            $('#check_all_enviar').change(function() {
                var checkboxes = $('input:checkbox').length;
                if ($(this).is(':checked')) {
                    $('#btn_enviar_all').removeClass('d-none');
                    $(".talonario_enviado").attr('disabled', true);
                    $i = checkboxes - 1;
                }else{
                    $('#btn_enviar_all').addClass('d-none');
                    $(".talonario_enviado").attr('disabled', false);
                    $i = 0;
                }
                $('.check_enviar').prop('checked', $(this).is(':checked'));
            });


            /////////SELECCIONAR CHECKBOX
            $('.check_enviar').change(function() {
                if ($(this).is(':checked')) {
                   $i++;
                }else{
                    $i--;
                }
                // /////////////////////////
                if ($i <= 1) {
                    $('#btn_enviar_all').addClass('d-none');
                    $(".talonario_enviado").attr('disabled', false);
                }else{
                    $('#btn_enviar_all').removeClass('d-none');
                    $(".talonario_enviado").attr('disabled', true);
                }
            });


            ///////SELECCIONAR UN TALONARIO PARA ENVIAR
            $(document).on('click','.talonario_enviado', function(e) { 
                e.preventDefault(e); 
                var talonarios = [];
                var id_talonario = $(this).attr('id_talonario');

                talonarios.push(id_talonario);
                $i++;

                $(".check_"+id_talonario).prop("checked", true);
                $('input[type="checkbox"]').not(".check_"+id_talonario).prop('checked', false);

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.modal_enviados") }}',
                    data: {talonarios:talonarios},
                    success: function(response) {        

                        $('#html_talonarios_enviados').html(response);

                        //////////////////////////////////////////////////////////////
                        $(document).on('click','#btn_aceptar_enviados', function(e) {
                            // console.log(talonarios);
                            $("#btn_aceptar_enviados").attr('disabled', true);                            
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("estado.enviados") }}',
                                data: {talonarios:talonarios},
                                success: function(response) {  
                                    if (response.success) {
                                        alert("ACTUALIZACIÓN DE ESTADO EXITOSO");
                                        window.location.href = "{{ route('estado')}}";
                                    }else{
                                        alert("ERROR AL ACTUALIZAR EL ESTADO");
                                    }     
                                    
                                },
                                error: function() {
                                }
                            });
                        }); 
                        //////////////////////////////////////////////////////////////
                    },
                    error: function() {
                    }
                });
                
            });


            ///////MODAL: TALONARIOS ENVIADOS
            $(document).on('click','#btn_talonarios_enviados', function(e) { 
                e.preventDefault(e); 
                var talonarios = [];

                $("input[type=checkbox]:checked").each(function() {
                    talonarios.push($(this).val());
                });

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.modal_enviados") }}',
                    data: {talonarios:talonarios},
                    success: function(response) {        

                        $('#html_talonarios_enviados').html(response);

                        //////////////////////////////////////////////////////////////
                        $(document).on('click','#btn_aceptar_enviados', function(e) {
                            // console.log(talonarios);
                            $("#btn_aceptar_enviados").attr('disabled', true);                            
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("estado.enviados") }}',
                                data: {talonarios:talonarios},
                                success: function(response) {  
                                    if (response.success) {
                                        alert("ACTUALIZACIÓN DE ESTADO EXITOSO");
                                        window.location.href = "{{ route('estado')}}";
                                    }else{
                                        alert("ERROR AL ACTUALIZAR EL ESTADO");
                                    }     
                                    
                                },
                                error: function() {
                                }
                            });
                        }); 
                        //////////////////////////////////////////////////////////////
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