@extends('adminlte::page')

@section('title', 'Control: Canteras')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3">Control de Canteras</h2>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:14px">
                <thead class="border-light-subtle">
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="2" class="text-secondary">Período</th>
                        <th colspan="3">Guías</th>
                        <th colspan="1"></th>
                    </tr>
                    <tr>
                        <th>Cantera</th>
                        <!-- <th>Contribuyente</th> -->
                        <th>R.I.F.</th>
                        <th class="text-secondary">Inicio</th>
                        <th class="text-secondary">Fin</th>
                        <th>Límite</th>
                        <th>Solicitadas</th>
                        <th>Extención</th>
                        <th>Opciones</th>
                    </tr>                    
                </thead>
                <tbody id="list_canteras"> 
                    @foreach ($limites as $limite)
                        <tr>
                            <td class="fw-bold">{{ $limite->nombre }}</td>
                            <!-- <td>{{ $limite->razon_social }}</td> -->
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $limite->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$limite->rif_condicion}}-{{$limite->rif_nro}}</a>
                            </td>
                            <td class="text-secondary">{{ $limite->inicio_periodo }}</td>
                            <td class="text-secondary">{{ $limite->fin_periodo }}</td>

                            <td class="fw-bold">{{ $limite->total_guias_periodo }} Guías</td>
                            
                            @php
                                if($limite->total_guias_solicitadas_periodo == $limite->total_guias_periodo){
                            @endphp
                                <td class="text-danger fw-bold">{{ $limite->total_guias_solicitadas_periodo }} Guías</td>
                            @php
                                }else{
                            @endphp
                                <td class="text-success fw-bold">{{ $limite->total_guias_solicitadas_periodo }} Guías</td>
                            @php     
                                }
                            @endphp
                            <td>
                                <span class="text-secondary fst-italic">Sin extención</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" style="font-size:13px">Extender límite</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* ******** -->
    <!-- <div class="modal" id="modal_info_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bxs-hard-hat fs-2' style="color:#ff8f00"></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff"> Producción de la Cantera</h1>
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agua Viva II</h1>
                    </div>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:15px;">
                    
                    <div class="d-flex flex-column text-center" id="info_produccion">
                        
                    </div>

                </div>  
            </div>  
        </div>  
    </div> -->


     <!-- ********* INFO SUJETO ******** -->
     <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

 

  

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
            

           

        });

        

        
    </script>
  
@stop