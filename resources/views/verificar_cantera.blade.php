@extends('adminlte::page')

@section('title', 'Verificación: Canteras')

@section('content_header')
    <h1 class="mb-3">Verificación de Canteras</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
<div class="table-responsive">
        <table id="example" class="table text-center" style="font-size:14px">
            <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Producción</th>
                <th>Contribuyente</th>
                <th>Opciones</th> 
            </thead>
            <tbody id="list_canteras"> 
               
                @foreach ( $canteras as $cantera )            
                    <tr>
                        <td>{{ $cantera->id_cantera }}</td>
                        <td>{{ $cantera->nombre }}</td>
                        <td>{{ $cantera->lugar_aprovechamiento }}</td>
                        <td>
                            <p class="text-primary fw-bold info_cantera" role="button" id_cantera='{{ $cantera->id_cantera }}' data-bs-toggle="modal" data-bs-target="#modal_info_cantera">Ver más</p>
                        </td>
                        <td>
                        <a class="info_sujeto" role="button" id_sujeto='{{ $cantera->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$cantera->rif}}</a>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm aprobar_cantera" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_verificar_cantera">Verificar</button>
                            <button class="btn btn-danger btn-sm denegar_cantera" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_cantera">Denegar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody> 
            
        </table>
        
    </div>
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* INFO CANTERA ******** -->
    <div class="modal" id="modal_info_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bxs-hard-hat fs-2' style="color:#ff8f00"></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Producción de la Cantera</h1>
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agua Viva II</h1>
                    </div>
                    
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body" style="font-size:15px;">
                    
                    <div class="d-flex flex-column text-center" id="info_produccion">
                        
                    </div>

                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* VERIFICAR CANTERA ******** -->
    <div class="modal" id="modal_verificar_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_verificar_cantera">
            <!-- <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Verificar Cantera?</h1>
                        <div class="">
                            <h1 class="modal-title fs-5" id="" style="color: #0072ff"></h1>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px;">
                    <table class="table">
                        <tr>
                            <th>Conribuyente</th>
                            <td class="d-flex flex-column">
                                <span>ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.</span>
                                <span>G-32873763</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Nombre de la Cantera</th>
                            <td>UTP El Apamate</td>
                        </tr>
                        <tr>
                            <th>Lugar de Aprovechamiento</th>
                            <td>Sector la Quebrada Honda, Municipio San Sebastián Estado Aragua.</td>
                        </tr>
                        <tr>
                            <th>Producción</th>
                            <td class="d-flex flex-column">
                                <span>Piedra Picada ¾</span>
                                <span>Material Integral</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Límite de Guías solicitadas por período</th>
                            <td>
                                <input type="number" class="form-control" id="limite_guia_cantera" name="limite_guia_cantera">
                            </td>
                        </tr>
                    </table>
                    <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                        </span> El <span class="fw-bold">Límite de guías a solicitar, </span>
                        se define como el límite impuesto de guías que el contribuyente pude solicitar en un 
                        <span class="fw-bold">período de tres (3) meses</span>, lo cual se aplica
                        <span class="fw-bold">exclusivamete a esta cantera</span>. El número de guias se estima según su producción.
                        
                    </p>
                    <div class="d-flex justify-content-center my-3">
                        <button class="btn btn-success btn-sm me-4" id="cantera_verificada" id_cantera="'.$idCantera.'">Verificar y guardar</button>
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div> -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DENEGAR CANTERA ******** -->
    <div class="modal" id="modal_denegar_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_denegar_cantera">
                

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
            ///////MODAL: INFO CANTERA
            $(document).on('click','.info_cantera', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).attr('id_cantera');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("cantera.minerales") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        // alert(response);                 
                        $('#info_produccion').html(response);
                    },
                    error: function() {
                    }
                });
            });

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

            ///////MODAL: VERIFICAR CANTERA
            $(document).on('click','.aprobar_cantera', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).attr('id_cantera');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("verificar_cantera.info") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        // alert(response);        
                        // console.log(response);         
                        $('#content_verificar_cantera').html(response);
                    },
                    error: function() {
                    }
                });
            });

            // ///////VERIFICAR CANTERA
            // $(document).on('click','#cantera_verificada', function(e) { 
            //     e.preventDefault(e); 
            //     var cantera = $(this).attr('id_cantera');
                
            //     // alert(cantera);
            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("verificar_cantera.verificar") }}',
            //         data: {cantera:cantera},
            //         success: function(response) {
            //             if (response.success) {
            //                 alert('LA CANTERA HA SIDO VERIFICADA CORRECTAMENTE');
            //                 window.location.href = "{{ route('verificar_cantera')}}";
            //             } else {
            //                 alert('Ha ocurrido un error al Verificar la Cantera.');
            //             }             
                       
            //         },
            //         error: function() {
            //         }
            //     });
            // });

            ///////MODAL: DENEGAR CANTERA
            $(document).on('click','.denegar_cantera', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).attr('id_cantera');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("verificar_cantera.info_denegar") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        // alert(response);                 
                        $('#content_denegar_cantera').html(response);
                    },
                    error: function() {
                    }
                });
            });
            

           

        });

        function verificarCantera(){
            var formData = new FormData(document.getElementById("form_verificar_cantera"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("verificar_cantera.verificar") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        // alert(response);
                        if (response.success) {
                            alert('LA CANTERA HA SIDO VERIFICADA CORRECTAMENTE');
                            window.location.href = "{{ route('verificar_cantera')}}";
                        } else {
                            alert('Ha ocurrido un error al Verificar la Cantera.');
                        }    

                    },
                    error: function(error){
                        
                    }
                });
        }

        function denegarCantera(){
            var formData = new FormData(document.getElementById("denegar_cantera"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("verificar_cantera.denegar") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('LA VERIFICACIÓN DE LA CANTERA HA SIDO DENEGADA CORRECTAMENTE');
                            window.location.href = "{{ route('verificar_cantera')}}";
                        } else {
                            alert('Ha ocurrido un error al Denegar la verificación de la Cantera.');
                        }  

                    },
                    error: function(error){
                        
                    }
                });
        }
    </script>
  
@stop