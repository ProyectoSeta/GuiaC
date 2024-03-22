@extends('adminlte::page')

@section('title', 'Estado - Solicitudes')

@section('content_header')
    <h1 class="mb-3">Estado de Solicitudes</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <!-- <div class="d-flex justify-content-around">
        <div class="info-box m-2">
            <span class="info-box-icon fs-2" style="background: #f6b828; color: #ffff;"><i class='bx bx-search-alt-2'></i></span>
            <div class="info-box-content">
                <span class="info-box-text fw-bold">Por Aprobar</span>
                <span class="info-box-number">8</span>
            </div>
        </div>
        <div class="info-box m-2">
            <span class="info-box-icon fs-2 bg-primary"><i class='bx bxs-hourglass-top' ></i></i></span>
            <div class="info-box-content">
                <span class="info-box-text fw-bold">En Proceso</span>
                <span class="info-box-number">10</span>
            </div>
        </div>
        <div class="info-box m-2">
            <span class="info-box-icon fs-2" style="background: #62bf00; color: #ffff;"><i class='bx bxs-inbox'></i></span>
            <div class="info-box-content">
                <span class="info-box-text fw-bold">Por Retirar</span>
                <span class="info-box-number">4</span>
            </div>
        </div>
    </div> -->
    <!-- <div class="d-flex justify-content-around">
        <div class="small-box w-25" style="background: #f5ac00d6; color: #fff;">
            <div class="inner">
                <h3>8</h3>
                <p>Por Aprobar</p>
            </div>
            <div class="icon">
                <i class='bx bx-search-alt-2'></i>
            </div>
            <a href="#" class="small-box-footer">
                Ver <i class='bx bxs-chevron-right'></i>
            </a>
        </div>

        <div class="small-box w-25" style="background: #108fff; color: #fff;">
            <div class="inner">
                <h3>5</h3>
                <p>En Proceso</p>
            </div>
            <div class="icon">
                <i class='bx bxs-hourglass-top' ></i>
            </div>
            <a href="#" class="small-box-footer">
                Ver <i class='bx bxs-chevron-right'></i>
            </a>
        </div>

        <div class="small-box w-25" style="background: #62bf00; color: #fff;">
            <div class="inner">
                <h3>4</h3>
                <p>Por Retirar</p>
            </div>
            <div class="icon">
                <i class='bx bxs-inbox'></i>
            </div>
            <a href="#" class="small-box-footer">
                Ver <i class='bx bxs-chevron-right'></i>
            </a>
        </div>

    </div> -->
    <div class="table-responsive">
        <table id="example" class="table text-center" style="font-size:14px">
            <thead>
                <th>Cod.</th>
                <th>Razón Social</th>
                <th>Rif</th>
                <th>Solicitud</th>
                <th>Estado</th>
                <th>Emisión</th>
            </thead>
            <tbody> 
            @foreach ($solicitudes as $solicitud)
                    <tr>
                        <td>{{$solicitud->id_solicitud}}</td>
                        <td>
                            <span class="fw-bold">{{$solicitud->razon_social}}</span>
                        </td>
                        <td>
                            <a class="info_sujeto" role="button" id_sujeto='{{ $solicitud->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$solicitud->rif}}</a>
                        </td>
                        <td>
                            <p class="text-primary fw-bold ver_solicitud" role="button" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_ver_solicitud">Ver</p>
                        </td>
                        <td>
                            @switch($solicitud->estado)
                                @case('Verificando')
                                    <span class="badge text-bg-secondary p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-error-circle fs-6 me-2'></i>Verificando pago</span>
                                @break
                                @case('Negada')
                                    <span role="button" class="badge text-bg-danger p-2 d-flex justify-content-center align-items-center solicitud_denegada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_denegada" id_solicitud='{{ $solicitud->id_solicitud }}'><i class='bx bx-x-circle fs-6 me-2'></i>Negada</span>
                                @break
                                @case('En proceso')
                                    <span class="badge text-bg-primary p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                @break
                                @case('Retirar') 
                                    <span class="badge text-bg-warning p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;background-color: #ef7f00;"><i class='bx bx-error-circle fs-6 me-2'></i>Retirar</span>
                                @break
                                @case('Retirado')
                                    <span class="badge text-bg-success p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Retirado</span>
                                @break
                  
                            @endswitch                    
                        </td>
                        <td>{{$solicitud->fecha}}</td>
                        
                    </tr>
               @endforeach
               
                        
                 
            </tbody> 
            
        </table>
        
    </div>
    

      

    
    
<!--****************** MODALES **************************-->
   <!-- ********* INFO SUJETO ******** -->
   <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* APROBAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_ver_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ver_solicitud">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *********INFO SOLICITUD DENEGADA ******** -->
    <div class="modal" id="modal_info_denegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_denegada">
                
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
            $(document).on('click','.ver_solicitud', function(e) { 
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

        });
    </script>
  
@stop