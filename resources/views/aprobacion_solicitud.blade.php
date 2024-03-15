@extends('adminlte::page')

@section('title', 'Aprobacion - Solicitudes')

@section('content_header')
    <h1 class="mb-3">Aprobación de Solicitudes</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="table-responsive">
        <table id="example" class="table text-center" style="font-size:14px">
            <thead>
                <th>Cod.</th>
                <th>Razón Social</th>
                <th>Solicitud</th>
                <th>Monto</th>
                <th>Emisión</th>
                <th>Correlativo</th> 
                <th>Opciones</th>
            </thead>
            <tbody> 
              
               @foreach ($solicitudes as $solicitud)
                    <tr>
                        <td>{{$solicitud->id_solicitud}}</td>
                        <td>
                            <span class="fw-bold info_sujeto" role="button" id_sujeto='{{ $solicitud->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$solicitud->razon_social}}</span>
                        </td>
                        <td>
                            <p class="text-primary fw-bold info_talonario" role="button" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</p>
                        </td>
                        <td>
                            <a target="_blank" class="ver_pago" id_solicitud="{{$solicitud->id_solicitud}}" href="{{ asset($solicitud->referencia) }}">{{$solicitud->monto}}</a>
                        </td>
                        <td>{{$solicitud->fecha}}</td>
                        <td>
                            <span class="fst-italic text-secondary">Sin asignar</span>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm aprobar_solicitud" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_aprobar_solicitud">Aprobar</button>
                            <button class="btn btn-danger btn-sm" id_solicitud="{{$solicitud->id_solicitud}}">Denegar</button>
                        </td>
                    </tr>
               @endforeach
                        
                 
            </tbody> 
            
        </table>
        
    </div>
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* INFO CANTERA ******** -->
    <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* VER INFO TALONARIO(S) ******** -->
    <div class="modal fade" id="modal_info_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_talonarios">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* APROBAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_aprobar_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_aprobar_solicitud">
                <!-- <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-help-circle fs-2'></i>                       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar la siguiente solicitud?</h1>
                        <div class="">
                            <h1 class="modal-title fs-5" id="" style="color: #0072ff">Prueba 2, C.A.</h1>
                            <h5 class="modal-title" id="" style="font-size:14px">J0000001</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px;">
                    <h6 class="text-center mb-3">Solicitud de Talonario(s) Realizada</h6>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Tipo de talonario</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>25</td>
                                <td>2</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        <table class="table table-sm w-75">
                            <tr>
                                <th>Total de Guías a emitir</th>
                                <td>50</td>
                            </tr>
                            <tr>
                                <th>UCD a pagar</th>
                                <td>250</td>
                            </tr>
                            <tr>
                                <th>Precio del UCD (al día)</th>
                                <td>38.57</td>
                            </tr>
                            <tr>
                                <th>Monto total</th>
                                <td>7.857,40</td>
                            </tr>
                            <tr>
                                <th>Referencia</th>
                                <td><span class="text-primary fw-bold info_talonario" role="button">Ver</span></td>
                            </tr>
                        </table>
                    </div>
                    

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-success btn-sm me-4">Aprobar</button>
                        <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                    

                </div>  cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* SOLICITUD APROBADA: VER CORRELATIVO ******** -->
    <div class="modal fade" id="modal_ver_correlativo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_talonarios">
            <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-check-circle fs-2'></i>                     
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¡La solicitud a sido Aprobada!</h1>
                        <div class="">
                            <h1 class="modal-title fs-5" id="" style="color: #0072ff">Prueba 2, C.A.</h1>
                            <h5 class="modal-title" id="" style="font-size:14px">J0000001</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px">
                    <p class="text-center" style="font-size:14px">El correlativo correspondiente a la solicitud generada es el siguiente:</p>
                    
                    <span class="ms-3">Talonario Nro. 1</span>
                    <table class="table mt-2 mb-3">
                        <tr>
                            <th>Tipo:</th>
                            <td>25</td>
                            <th>Desde:</th>
                            <td>245-000001-24</td>
                            <th>Hasta:</th>
                            <td>245-000026-24</td>
                        </tr>
                    </table>

                    <span class="ms-3">Talonario Nro. 1</span>
                    <table class="table mt-2 mb-3">
                        <tr>
                            <th>Tipo:</th>
                            <td>25</td>
                            <th>Desde:</th>
                            <td>245-000027-24</td>
                            <th>Hasta:</th>
                            <td>245-000052-24</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-center">
                        <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
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

            ///////MODAL: INFO TALONARIOS
            $(document).on('click','.info_talonario', function(e) { 
                e.preventDefault(e); 
                var id = $(this).attr('id_solicitud');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.talonarios") }}',
                    data: {id:id},
                    success: function(response) {              
                        $('#content_info_talonarios').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: APROBAR SOLICITUD
            $(document).on('click','.aprobar_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.aprobar") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {              
                        $('#content_aprobar_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

                

        });
    </script>
  
@stop