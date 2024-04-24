@extends('adminlte::page')

@section('title', 'Solicitud de Guías')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3">Solicitud de Guías</h2>
            <div class="me-3">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold btn-sm" id="new_solicitud" data-bs-toggle="modal" data-bs-target="#modal_new_solicitud"><i class='bx bx-plus fw-bold'></i>Nueva solicitud</button>
            </div>
        </div>
        
        
        <div class="table-responsive" style="font-size:14px">        
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:14px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">Cod.</th>
                        <th scope="col">Cantera</th>
                        <th scope="col">Fecha de emisión</th>
                        <th scope="col">Solicitud</th>
                        <th scope="col">UCD a Pagar</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $solicitudes as $solicitud)               
                        <tr>
                            <td>{{$solicitud->id_solicitud}}</td>
                            <td class="fw-bold">{{$solicitud->nombre}}</td>
                            <td>{{$solicitud->fecha}}</td>
                            <td>
                                <p class="text-primary fw-bold info_talonario" role="button" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</p>
                            </td>
                            <td>
                                <span>{{$solicitud->ucd_pagar}}</span>
                            <td>
                                @switch($solicitud->estado)
                                @case('Verificando')
                                        <span class="badge text-bg-secondary p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-error-circle fs-6 me-2'></i>Verificando solicitud</span>
                                    @break
                                    @case('Negada')
                                        <span role="button" class="badge text-bg-danger p-2 d-flex justify-content-center align-items-center solicitud_denegada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_denegada" id_solicitud='{{ $solicitud->id_solicitud }}'><i class='bx bx-x-circle fs-6 me-2'></i>Negada</span>
                                    @break
                                    @case('En proceso')
                                        <span class="badge text-bg-primary p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                    @break
                                    @case('Retirar') 
                                        <span class="badge text-bg-warning p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;background-color: #ef7f00;"><i class='bx bx-error-circle fs-6 me-2'></i>Retirar Talonario(s)</span>
                                    @break
                                    @case('Retirado')
                                        <span class="badge text-bg-success p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Retirado</span>
                                    @break
                    
                                @endswitch                    
                            </td>
                            <td>
                                @if ($solicitud->estado == 'Verificando')
                                    <span class="badge delete_solicitud" style="background-color: #ed0000;" role="button" id_cantera="{{$solicitud->id_cantera}}" id_solicitud="{{$solicitud->id_solicitud}}">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @else
                                    <span class="badge" style="background-color: #ed00008c;">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
    
   


      

    
    
  <!--****************** MODALES **************************-->
    <!-- ********* NUEVA SOLICITUD ******** -->
    <div class="modal fade" id="modal_new_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff">
                    <!-- <i class='bx bxs-file-plus'></i> -->
                        Solicitud de Guías - Talonario
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-2" style="font-size:14px;" id="content_info_new">
                    
                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* ELIMINAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_delete_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Eliminar solicitud</h1>
                    </div>
                    
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body" style="font-size:14px;">
                    
                    <p class="text-center">¿Desea cancelar la Solicitud registrada con los siguientes datos?</p>

                    <table class="table">
                        <tr>
                            <th>Nro. Solicitud</th>
                            <td>105</td>
                        </tr>
                        <tr>
                            <th>Solicitante</th>
                            <td>Prueba, C.A.</td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td>12/02/2024</td>
                        </tr>

                        <tr>
                            <th>Nro. Talonario(s)</th>
                            <td>2</td>
                        </tr>                    
                        <tr>
                            <th>Tipo de talonario(s)</th>
                            <td>25 - 50</td>
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

    <!-- ********* VER INFO TALONARIO(S) ******** -->
    <div class="modal fade" id="modal_info_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_talonarios">
                
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
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
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
        });
    </script> 

    <script type="text/javascript">
        $(document).ready(function (){
           
            ///////MODAL: REALIZAR SOLICITUD
            $(document).on('click','#new_solicitud', function(e) { 
                e.preventDefault(e); 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.new_solicitud") }}',
                    success: function(response) {              
                        $('#content_info_new').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ////////////////////CALCULAR LOS UCD A PAGAR
            $(document).on('click','#calcular', function(e) { 
                e.preventDefault(e); 
                var cant = $('#cantidad').val();
                console.log(cant);

                if (cant == '') {
                    $('#total_ucd').html('0 UCD');
                }else{
                    var total_guias = cant * 50;
                    var total_ucd = total_guias * 5;
                    $('#total_ucd').html(total_ucd +' UCD');

                    $("#btn_cancelar").attr('disabled', false);
                    $("#btn_generar_solicitud").attr('disabled', false);
                }
            });

            ////////////////////
            $(document).on('keyup','#cantidad', function(e) {  
                var cant = $(this).val();
                if (cant == 0) {
                    $("#btn_cancelar").attr('disabled', true);
                    $("#btn_generar_solicitud").attr('disabled', true);
                }
                console.log(cant);
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
                        // console.log(response);          
                        $('#content_info_talonarios').html(response);
                    },
                    error: function() {
                    }
                });
            });


            //////ELIMINAR SOLICITUD
            $(document).on('click','.delete_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var cantera = $(this).attr('id_cantera');
                
                if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA SOLICITUD CON EL CÓDIGO:   " + solicitud + "?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("solicitud.destroy") }}',
                        data: {solicitud:solicitud,cantera:cantera},
                        success: function(response) {
                           console.log(response);
                            if (response.success){
                                alert("SOLICITUD ELIMINADA EXITOSAMENTE");
                                window.location.href = "{{ route('solicitud')}}";
                            } else{
                                alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA SOLICITUD");
                            }              
                        },
                        error: function() {
                        }
                    });
                }else{

                }
                
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

        function generarSolicitud(){
                var formData = new FormData(document.getElementById("form_generar_solicitud"));
                // alert(formData);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.store") }}',
                    data: formData,
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    success: function(response) {
                        // console.log(response);
                       if (response.success) {
                            alert('La solicitud a sido generada exitosamente!');
                            $('#form_generar_solicitud')[0].reset();
                            $('#modal_new_solicitud').modal('hide');
                            window.location.href = "{{ route('solicitud')}}";   
                        }else{
                            alert(response.nota);
                       }
                    },
                    error: function() {
                    }
                });
        }

    </script>
@stop