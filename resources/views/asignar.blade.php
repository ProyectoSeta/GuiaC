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
        
    <!-- ********* ASIGNACIÓN: SUJETO REGISTRADO ******** -->
    <div class="modal fade" id="modal_asignar_sujeto_registrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel" >Asignación de Guías</h1>
                </div>

                <div class="modal-body " style="font-size:13px">
                    <form id="form_asignar_guias" method="post" onsubmit="event.preventDefault(); asignarGuias();">
                        <div class="row px-4">
                            <div class="col-sm-6">
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Datos del Contribuyente</span>
                                </div>

                                <div class="mb-0">
                                    <span class="fw-bold">R.I.F.</span>
                                    <p class="text-navy fw-bold mb-2">G-200108240</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Razon Social</span>
                                    <p class="text-navy fw-bold mb-2">ARAGUA MINAS Y CANTERAS, S.A.</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Dirección</span>
                                    <p class="text-muted mb-2">DIRECCION</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Teléfono Móvil</span>
                                    <p class="text-muted mb-2">04120000001</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Teléfono Fijo</span>
                                    <p class="text-muted mb-2">02440000001</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Representante legal</span>
                                    <p class="text-muted mb-2">LEON</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">C.I. del Representante</span>
                                    <p class="text-muted mb-2">V-000001</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">R.I.F. del Representante</span>
                                    <p class="text-muted mb-2">V00000001</p>
                                </div>
                                <div class="mb-0">
                                    <span class="fw-bold">Teléfono del Representante</span>
                                    <p class="text-muted mb-2">04120000001</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Correspondiente a la Asignación</span>
                                </div>

                                <div class=" mb-2">
                                    <label class="form-label" for="cantera">Cantera y/o Desazolve</label><span class="text-danger">*</span>
                                    <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                        <option  value=""></option>
                                    </select>
                                </div>
                                <div class=" mb-2">
                                    <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                    <input class="form-control form-control-sm" type="number" name="cantidad" required disabled>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                    <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                    <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required disabled>
                                </div>

                                <div class="d-flex justify-content-end align-items-center me-2 fs-6 mb-2">
                                    <span class="fw-bold me-4">Total: </span>
                                    <span id="total_ucd" class="fs-5">0 UCD</span>
                                </div>

                                <input type="hidden" name="id_sujeto" required>
                                <input type="hidden" name="tipo_sujeto" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar" disabled="">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion" disabled="">Asignar</button>
                        </div>
                    </form>
                    

                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* ASIGNACIÓN: SUJETO NO REGISTRADO ******** -->
    <div class="modal fade" id="modal_asignar_sujeto_no_registrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel" >Asignación de Guías</h1>
                </div>

                <div class="modal-body " style="font-size:13px">
                    <form id="form_asignar_guias_noregister" method="post" onsubmit="event.preventDefault(); asignarGuiasNoregister();">
                        <div class="row px-4">
                            <div class="col-sm-6">  <!-- ********************************************************************* -->
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Datos del Contribuyente</span>
                                </div>

                                <label class="form-label" for="rif">R.I.F.</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion" required>
                                            <option value="G" id="rif_gubernamental">G</option>
                                            <option value="J" id="rif_juridico">J</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" required/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                                    </div>
                                </div>
                                
                                <!-- razon social input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger"> *</span>
                                    <input type="text" id="razon_social" class="form-control form-control-sm" name="razon_social" required>
                                </div>

                                <!-- direccion input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="direccion">Dirección</label><span class="text-danger"> *</span>
                                    <input type="text" id="direccion" class="form-control form-control-sm" name="direccion" required/>
                                </div>

                                <!-- tlf movil input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_movil">Teléfono Movil</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" placeholder="Ejemplo: 04125231102" required >
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>

                                <!-- tlf fijo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_fijo">Teléfono Fijo</label>
                                    <input type="number" id="tlf_fijo" class="form-control form-control-sm" name="tlf_fijo" placeholder="Ejemplo: 02432632201" required>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 02432632201</p>
                                </div>

                                <!-- rif:repr input -->
                                <label class="form-label" for="rif_repr">R.I.F. del Representante</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion_repr" aria-label="Default select example" name="rif_condicion_repr" required>
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif_nro_repr" class="form-control form-control-sm" name="rif_nro_repr" placeholder="Ejemplo: 084561221" required>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 084561221</p>
                                    </div>
                                </div>

                                <!-- ci:repr input -->
                                <label class="form-label" for="ci_repr">Cédula del Representante</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="ci_condicion_repr" aria-label="Default select example" name="ci_condicion_repr" required>
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="ci_nro_repr" class="form-control form-control-sm" name="ci_nro_repr" placeholder="Ejemplo: 8456122" required>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>

                                 <!-- nombre:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="name_repr">Nombre del Representante</label><span class="text-danger"> *</span>
                                    <input type="text" id="name_repr" class="form-control form-control-sm" name="name_repr" required>
                                </div>

                                 <!-- tlf:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_repr">Teléfono del Representante</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_repr" class="form-control form-control-sm" name="tlf_repr" placeholder="Ejemplo: 04125231102" required>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>

                                
                            </div>
                            <div class="col-sm-6"> <!-- ********************************************************************** -->
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Datos de la Cantera (o Desazolve)</span>
                                </div>

                                <!-- razon social input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="nombre_cantera">Nombre de la Cantera o Desazolve</label><span class="text-danger"> *</span>
                                    <input type="text" id="nombre_cantera" class="form-control form-control-sm" name="nombre_cantera" required/>
                                </div>

                                <!-- municipio y parroqui cantera -->
                                
                                <div class="form-outline mb-2">
                                    <label for="municipio" class="col-form-label">Municipio<span style="color:red">*</span></label>
                                    <select class="form-select form-select-sm" aria-label="Default select example" id="municipio" name="municipio" required>
                                        <option value="Bolívar">Bolívar</option>
                                        <option value="Camatagua">Camatagua</option>
                                        <option value="Francisco Linares Alcántara">Francisco Linares Alcántara</option>
                                        <option value="Girardot">Girardot</option>
                                        <option value="José Ángel Lamas">José Ángel Lamas</option>
                                        <option value="José Félix Ribas">José Félix Ribas</option>
                                        <option value="José Rafael Revenga">José Rafael Revenga</option>
                                        <option value="Libertador">Libertador</option>
                                        <option value="Mario Briceño Iragorry">Mario Briceño Iragorry</option>
                                        <option value="Ocumare de la Costa de Oro">Ocumare de la Costa de Oro</option>
                                        <option value="San Casimiro">San Casimiro</option>
                                        <option value="San Sebastián">San Sebastián</option>
                                        <option value="Santiago Mariño">Santiago Mariño</option>
                                        <option value="Santos Michelena">Santos Michelena</option>
                                        <option value="Sucre">Sucre</option>
                                        <option value="Tovar">Tovar</option>
                                        <option value="Urdaneta">Urdaneta</option>
                                        <option value="Zamora">Zamora </option>
                                    </select>

                                </div>
                                  
                                <div class="form-outline mb-2">
                                    <label for="parroquia" class="col-form-label">Parroquia<span style="color:red">*</span></label>
                                    <select class="form-select form-select-sm" aria-label="Default select example" id="parroquia" name="parroquia" required>
                                        <option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="direccion_cantera" class="col-form-label">Lugar de Aprovechamiento<span style="color:red">*</span></label>
                                    <input type="text" id="direccion_cantera" class="form-control form-control-sm" name="direccion_cantera"  required>
                                </div>
                                                                    
                                

                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Correspondiente a la Asignación</span>
                                </div>

                                <div class=" mb-2">
                                    <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                    <input class="form-control form-control-sm" type="number" name="cantidad" required disabled>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                    <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                    <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required disabled>
                                </div>

                                <div class="d-flex justify-content-end align-items-center me-2 fs-6 mb-2">
                                    <span class="fw-bold me-4">Total: </span>
                                    <span id="total_ucd" class="fs-5">0 UCD</span>
                                </div>

                                <input type="hidden" name="id_sujeto" required>
                                <input type="hidden" name="tipo_sujeto" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar" disabled="">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion" disabled="">Asignar</button>
                        </div>
                    </form>
                    

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

        $(document).on('click','.asignar', function(e) {  
            var tipo = $(this).attr('tipo');
            var sujeto = $(this).attr('id_sujeto');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.modal") }}',
                data: {tipo:tipo,sujeto:sujeto},
                success: function(response) {           
                    $('#modal_asignar_sujeto_registrado').html(response);
                },
                error: function() {
                }
            });
            // console.log(cant);
        });












        /////////////PARROQUIAS
        $(document).on('change','#municipio', function(e) {
            var municipio = $(this).val();

            switch (municipio) {
                case 'Bolívar':
                    $('#parroquia').html('<option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>');
                    break;
                case 'Camatagua':
                    $('#parroquia').html('<option value="Camatagua">Camatagua</option>'+
                                        '<option value="Carmen de Cura">Carmen de Cura</option>');
                    break;
                case 'Francisco Linares Alcántara':
                    $('#parroquia').html('<option value="Santa Rita">Santa Rita</option>'+
                                        '<option value="Francisco de Miranda">Francisco de Miranda</option>'+
                                        '<option value="Moseñor Feliciano González">Moseñor Feliciano González</option>');
                    break;
                case 'Girardot':
                    $('#parroquia').html('<option value="Pedro José Ovalles">Pedro José Ovalles</option>'+
                                        '<option value="Joaquín Crespo">Joaquín Crespo</option>'+
                                        '<option value="José Casanova Godoy">José Casanova Godoy</option>'+
                                        '<option value="Madre María de San José">Madre María de San José</option>'+
                                        '<option value="Andrés Eloy Blanco">Andrés Eloy Blanco</option>'+
                                        '<option value="Los Tacarigua">Los Tacarigua</option>'+
                                        '<option value="Las Delicias">Las Delicias</option>'+
                                        '<option value="Choroní">Choroní</option>');

                break;
                case 'José Ángel Lamas':
                    $('#parroquia').html('<option value="Santa Cruz">Santa Cruz</option>');
                    break;
                case 'José Félix Ribas':
                    $('#parroquia').html('<option value="José Félix Ribas">José Félix Ribas</option>'+
                                        '<option value="Castor Nieves Ríos">Castor Nieves Ríos</option>'+
                                        '<option value="Las Guacamayas">Las Guacamayas</option>'+
                                        '<option value="Pao de Zárate">Pao de Zárate</option>'+
                                        '<option value="Zuata">Zuata</option>');
                break;
                case 'José Rafael Revenga':
                    $('#parroquia').html('<option value="José Rafael Revenga">José Rafael Revenga</option>');
                    break;
                case 'Libertador':
                    $('#parroquia').html('<option value="Palo Negro">Palo Negro</option>'+
                                        '<option value="San Martín de Porres">San Martín de Porres</option>');
                    break;
                case 'Mario Briceño Iragorry':
                    $('#parroquia').html('<option value="El Limón">El Limón</option>'+
                                        '<option value="Caña de Azúcar">Caña de Azúcar</option>');
                break;
                case 'Ocumare de la Costa de Oro':
                    $('#parroquia').html('<option value="Ocumare de la Costa">Ocumare de la Costa</option>');
                    break;
                case 'San Casimiro':
                    $('#parroquia').html('<option value="San Casimiro">San Casimiro</option>'+
                                        '<option value="Güiripa">Güiripa</option>'+
                                        '<option value="Ollas de Caramacate">Ollas de Caramacate</option>'+
                                        '<option value="Valle Morín">Valle Morín</option>');
                    break;
                case 'San Sebastián':
                    $('#parroquia').html('<option value="San Sebastián">San Sebastián</option>');
                    break;
                case 'Santiago Mariño':
                    $('#parroquia').html('<option value="Turmero">Turmero</option>'+
                                        '<option value="Arévalo Aponte">Arévalo Aponte</option>'+
                                        '<option value="Chuao">Chuao</option>'+
                                        '<option value="Samán de Güere">Samán de Güere</option>'+
                                        '<option value="Alfredo Pacheco Miranda">Alfredo Pacheco Miranda</option>');
                    break;
                case 'Santos Michelena':
                    $('#parroquia').html('<option value="Santos Michelena">Santos Michelena</option>'+
                                        '<option value="Tiara">Tiara</option>');
                    break;
                case 'Sucre':
                    $('#parroquia').html('<option value="Cagua">Cagua</option>'+
                                        '<option value="Bella Vista">Bella Vista</option>');
                break;
                case 'Tovar':
                    $('#parroquia').html('<option value="Tovar">Tovar</option>');
                    break;
                case 'Urdaneta':
                    $('#parroquia').html('<option value="Urdaneta">Urdaneta</option>'+
                                        '<option value="Las Peñitas">Las Peñitas</option>'+
                                        '<option value="San Francisco de Cara">San Francisco de Cara</option>'+
                                        '<option value="Taguay">Taguay</option>');
                    break;
                case 'Zamora':
                    $('#parroquia').html('<option value="Zamora">Zamora</option>'+
                                        '<option value="Magdaleno">Magdaleno</option>'+
                                        '<option value="San Francisco de Asís">San Francisco de Asís</option>'+
                                        '<option value="Valles de Tucutunemo">Valles de Tucutunemo</option>'+
                                        '<option value="Augusto Mijares">Augusto Mijares</option>');
                    break;
                default:
                    break;
            }

        });  
         

    });

    function asignarGuias(){
        var formData = new FormData(document.getElementById("form_asignar_guias"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("asignar") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    //alert(response);
                    if (response.success) {
                        alert('EL ESTADO DE LA SOLICITUD HA SIDO ACTUALIZADO CORRECTAMENTE');
                        window.location.href = "{{ route('estado')}}";
                    } else {
                        alert('Ha ocurrido un error al Actualizar el estado de la Solicitud.');
                    }    

                },
                error: function(error){
                    
                }
            });
    }

    



    </script>


  
@stop