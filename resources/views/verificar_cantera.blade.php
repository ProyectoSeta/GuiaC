@extends('adminlte::page')

@section('title', 'Verificación: Canteras')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy titulo">Verificación de Canteras</h3>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:13px">
                <thead class="border-light-subtle">
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
                                <a class="info_sujeto" role="button" id_sujeto='{{ $cantera->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$cantera->rif_condicion}}-{{$cantera->rif_nro}}</a>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm rounded-4 px-3 aprobar_cantera" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_verificar_cantera">Verificar</button>
                                <button class="btn btn-danger btn-sm rounded-4 px-3 denegar_cantera" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_cantera">Denegar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* INFO CANTERA ******** -->
    <div class="modal" id="modal_info_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="info_produccion">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* VERIFICAR CANTERA ******** -->
    <div class="modal" id="modal_verificar_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_verificar_cantera">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DENEGAR CANTERA ******** -->
    <div class="modal" id="modal_denegar_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_denegar_cantera">
                <div class="py-4 d-flex flex-column text-center">
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