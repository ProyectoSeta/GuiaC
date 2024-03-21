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
                <th>Opciones</th> 
            </thead>
            <tbody id="list_canteras"> 
               
                @foreach ( $canteras as $cantera )            
                    <tr>
                        <td>{{ $cantera->id_cantera }}</td>
                        <td>{{ $cantera->nombre }}</td>
                        <td>{{ $cantera->direccion }}</td>
                        <td>
                            <p class="text-primary fw-bold info_cantera" role="button" id_cantera='{{ $cantera->id_cantera }}' data-bs-toggle="modal" data-bs-target="#modal_info_cantera">Ver más</p>
                        </td>
                        <td>
                        <button class="btn btn-success btn-sm aprobar_sujeto" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_aprobar_cantera">Aprobar</button>
                        <button class="btn btn-danger btn-sm denegar_sujeto" id_cantera="{{$cantera->id_cantera}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_cantera">Denegar</button>
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
                        <!-- <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i> -->
                        <i class='bx bx-cube-alt fs-2'></i>
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
            

           

        });
    </script>
  
@stop