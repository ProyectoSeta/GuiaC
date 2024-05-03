@extends('adminlte::page')

@section('title', 'Sujetos Pasivos')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3">Libros</h2>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table display border-light-subtle text-center table-sm" style="width:100%; font-size:14px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mes</th>
                        <th scope="col">Año</th>
                        <th scope="col">Declaración</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libros as $libro)
                        @php
                            $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                            $mes_bd = $libro->mes;
                            $mes_libro = $meses[$mes_bd];


                        @endphp
                        <tr class="ver_libro">
                            <td>{{$libro->id_libro}}</td>
                            <td>{{$mes_libro}}</td>
                            <td>{{$libro->year}}</td>
                            <td>
                                <span class="text-secondary fst-italic">{{$libro->nombre}}</span>
                            </td>
                            <td>
                                <a href="{{ route('detalle_libro.index', ['mes' =>$libro->mes, 'year' =>$libro->year]) }}" class="btn btn-primary btn-sm px-3 rounded-4" mes="{{$libro->mes}}" year="{{$libro->year}}" >Ver libro</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
   
    


      

    
<!--****************** MODALES **************************-->
    <!-- ********* APERTURA DE LIBRO: NUEVA GUIA ******** -->
    <div class="modal" id="modal_registro_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel" style="color: #0072ff">
                        <i class='bx bx-barcode fs-1 me-2'></i>
                        Registro de Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4" style="font-size:14px;" id="content_registro_guia">

                    
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
        $(document).ready(function () {
        
           

        });
            
    </script>
@stop