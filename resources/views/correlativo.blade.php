@extends('adminlte::page')

@section('title', 'Talonarios')

@section('content_header')
    <h1 class="mb-3">Talonarios</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="table-responsive">
        <table id="example" class="table text-center" style="font-size:14px">
            <thead>
                <th>Cod. Talonario</th>
                <th>Cantera</th>
                <th>Nro. Solicitud</th>
                <th>Correlativo</th>
                <th>R.I.F.</th>
                <th>Empresa</th>
            </thead>
            <tbody> 
            @foreach ($talonarios as $talonario)
                    <tr>
                        <td>{{$talonario->id_talonario}}</td>
                        <td>
                            <span class="fw-bold">{{$talonario->nombre}}</span>
                        </td>
                        <td>{{$talonario->id_solicitud}}</td>
                        <td>
                            @php
                                $desde = $talonario->desde;
                                $hasta = $talonario->hasta;
                                $length = 6;
                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                            @endphp
                            <a href="#" class="info_talonario" role="button" id_talonario='{{ $talonario->id_talonario }}' data-bs-toggle="modal" data-bs-target="#modal_ver_talonario">{{$formato_desde}} - {{$formato_hasta}}</a>
                        </td>
                        <td>
                            <a class="info_sujeto" role="button" id_sujeto='{{ $talonario->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$talonario->rif_condicion}}-{{$talonario->rif_nro}}</a>
                        </td>
                        <td>{{$talonario->razon_social}}</td>
                        
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

     <!-- ********* VER GUIAS ******** -->
     <div class="modal" id="modal_ver_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer fs-1" style="color:#0c82ff"  ></i>                    
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Talonario 450</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px">
                    <table id="example2" class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>Nro. de Guía</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="content_info_talonario">
                            
                        </tbody>                      
                    </table>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


     <!-- ********* VER EL REGISTRO DE LA GUÍA ******** -->
     <div class="modal" id="modal_content_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="info_guia">
                <div class="modal-header">
                    <div class="d-flex flex-column">
                        <h5 style="color: #0072ff">Prueba Dos, C.A.</h5>
                        <span class="text-muted">J0000002</span>
                    </div>
                    <div class="d-flex flex-column">
                        <h5>Correlativo: AB000001 - AB000026</h5>
                        <span class="text-muted">Cod. Talonario: 456</span>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px">

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

             ///////MODAL: INFO TALONARIO
             $(document).on('click','.info_talonario', function(e) { 
                e.preventDefault(e); 
                var talonario = $(this).attr('id_talonario');
                // alert(talonario);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.talonario") }}',
                    data: {talonario:talonario},
                    success: function(response) {              
                        alert(response);
                        console.log(response);
                        $('#content_info_talonario').append(response);
                        $('#example2').DataTable().destroy();
                        // $("#example2").DataTable().fnDestroy();
                        $('#example2').DataTable({
                                "destroy":true,
                                "language": {
                                    "lengthMenu": " Mostrar  _MENU_  Registros",
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
                       
                    },
                    error: function() {
                    }
                });
            });

            ////////////////////MODAL: INFO GUIA
            $(document).on('click','.info_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('id_guia');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.guia") }}',
                    data: {guia:guia},
                    success: function(response) { 
                        $('#modal_ver_talonario').modal('hide');             
                        $('#modal_content_guia').modal('show');
                    },
                    error: function() {
                    }
                });
            });

        });
    </script>
  
@stop