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
                <th>Rif</th>
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
                            <span class="fw-bold">{{$solicitud->razon_social}}</span>
                        </td>
                        <td>
                            <a class="info_sujeto" role="button" id_sujeto='{{ $solicitud->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$solicitud->rif}}</a>
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
                            <button class="btn btn-danger btn-sm denegar_solicitud" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_solicitud">Denegar</button>
                        </td>
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
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* SOLICITUD APROBADA: VER CORRELATIVO ******** -->
    <div class="modal fade" id="modal_ver_correlativo"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_correlativo">
               
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DENEGAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_denegar_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_denegar_solicitud">
                
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
                // alert(solicitud);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.aprobar") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        // alert(response);
                        // console.log(response);
                        $('#content_aprobar_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: APROBAR Y GENERAR CORRELATIVO
            $(document).on('click','.aprobar_correlativo', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var sujeto = $(this).attr('id_sujeto');
                var fecha = $(this).attr('fecha');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.correlativo") }}',
                    data: {solicitud:solicitud, sujeto:sujeto, fecha:fecha},
                    success: function(response) {           
                        
                        if (response.success) {
                            $('#modal_aprobar_solicitud').modal('hide');
                            $('#modal_ver_correlativo').modal('show');

                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("aprobacion.info") }}',
                                data: {solicitud:solicitud},
                                success: function(response) {           
                                    
                                    $('#content_info_correlativo').html(response);
                                },
                                error: function() {
                                }
                            });
  
                        }else {
                            alert('Ha ocurrido un error al aprobar la solicitud');
                        }
        
                    },
                    error: function() {
                    }
                });
            });

            ////////cerrar modal info correlativo
            $(document).on('click','#cerrar_info_correlativo', function(e) { 
                $('#modal_ver_correlativo').modal('hide');
                window.location.href = "{{ route('aprobacion')}}";
            });
            
            ///////MODAL: DENEGAR SOLICITUD
            $(document).on('click','.denegar_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.denegarInfo") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        $('#content_denegar_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////DENEGAR SOLICITUD
            $('#form_denegar_solicitud').submit(function(e) {
                e.preventDefault(e);    
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.denegar") }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                    //     if (response.success) {
                    //         alert('LA SOLICITUD HA SIDO DENEGADA CORRECTAMENTE');
                    //         // window.location.href = "{{ route('aprobacion')}}";
                            
                    //     } else {
                    //         alert('Ha ocurrido un error al denegar la solicitud.');
                    //    }
                    },
                    error: function() {
                    }
                });
            });

        });
    </script>
  
@stop