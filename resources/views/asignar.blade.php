@extends('adminlte::page')

@section('title', 'Asignar Guías')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="text-center mb-2">
            <h3 class="mb-1 text-navy titulo">Asignación de Guías</h3>
            <span class="text-secondary">Talonarios de Reserva</span>
        </div>

        <div style="font-size:12.7px">
            <p class="text-secondary text-justify my-4" style="font-size:12.7px">
                <span class="fw-bold">*Recordatorio:</span> Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Officiis non totam repellendus sunt delectus, doloremque vero officia deleniti, distinctio rerum, atque inventore neque. 
                Omnis, debitis voluptatem excepturi vitae obcaecati facilis.
            </p>

            <div class="d-flex justify-content-center">
                <div class="w-50">
                    <label class="form-label mb-3" for="rif">
                        <span style="color:red">*</span> Ingrese el R.I.F del contribuyente al que va dirigida la asignación: 
                    </label>

                    <div class="row mb-4">
                        <div class="col-3">
                            <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion">
                                <option value="G" id="rif_gubernamental">G</option>
                                <option value="J" id="rif_juridico">J</option>
                            </select>
                        </div>
                        <div class="col-1">-</div>
                        <div class="col-6">
                            <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" autofocus value="{{ old('rif_nro') }}"/>
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-secondary btn-sm pb-0" id="search_sujeto_asignar">
                                <i class='bx bx-search-alt-2 fs-5'></i>
                            </button>
                        </div>
                    </div>

                    <div id="content-search-sujeto">
                        <!-- <div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado</p>
                            <a href="#" tipo="" id_sujeto="" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">ARAGUA MINAS Y CANTERAS, S.A. <br> G-200108240</a>
                        </div>

                        <div class="text-center">
                            <p class="fw-bold text-muted mb-2">Contribuyente No Registrado</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_no_registrado">Registrar</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>


        <div class="text-start mb-3 mt-5">
            <h3 class="mb-0 pb-0 text-navy titulo">Guías Asignadas <span class="text-secondary fs-5">(En Proceso)</span></h3>
            
        </div>

        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>R.I.F.</th>
                    <th>Contribuyente</th>
                    <th>Cant. Guías</th> 
                    <th>Emisión</th>
                    <th>Total UCD</th> 
                    <th>Soporte</th>
                    <th>Opción</th> <!-- entregado?  -->
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                
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
        $(document).on('click','#search_sujeto_asignar', function(e) {  
            var rif_nro = $('#rif').val();
            var rif_condicion = $('#rif_condicion').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.search") }}',
                data: {rif_nro:rif_nro,rif_condicion:rif_condicion},
                success: function(response) {           
                    $('#content-search-sujeto').html(response);
                },
                error: function() {
                }
            });
            // console.log(cant);
        });
         

    });

    



    </script>


  
@stop