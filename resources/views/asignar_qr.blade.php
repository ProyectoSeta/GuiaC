@extends('adminlte::page')

@section('title', 'Asignación - QR')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    
    
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        
        <div class="text-start mb-3 d-flex justify-content-between">
            <h3 class="mb-0 pb-0 text-navy titulo">Asignación QR</h3>
            <!-- <h5 class="text-secondary d-flex align-items-center">
                <span>Procesando</span> 
                <i class='bx bx-dots-horizontal-rounded bx-flashing fs-4 ms-2' ></i>
            </h5> -->
        </div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>R.I.F.</th>
                    <th>Detalles</th>
                    <th>Guías Solicitadas</th> 
                    <th>Correlativo</th>
                    <th>Soporte</th>
                    <th>QR</th>
                    <th>¿QR Listo?</th> <!-- entregado?  -->
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                @foreach ($asignaciones as $a)
                        <tr>
                            <td class="text-secondary">{{$a->id_asignacion}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $a->id_sujeto }}' tipo="{{ $a->contribuyente }}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$a->rif_condicion}}-{{$a->rif_nro}}</a>
                            </td>
                            <td>
                                <a class="detalle_asignacion" role="button" id_asignacion='{{ $a->id_asignacion }}' tipo="{{ $a->contribuyente }}" data-bs-toggle="modal" data-bs-target="#modal_detalle_asignacion">Ver</a>
                            </td>
                            <td  class="table-primary fw-bold">{{$a->cantidad_guias}} Guías</td>
                            <td>

                            </td>
                            <td>
                                <a target="_blank" class="ver_pago" href="{{asset($a->soporte)}}">Ver</a>
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                <i class='bx bx-check-circle fs-4 text-success mb-0 pb-0' id_asignacion="{{$a->id_asignacion}}" role="button"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>

        

        

        
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    


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
         
         

    });

    

    



    </script>


  
@stop