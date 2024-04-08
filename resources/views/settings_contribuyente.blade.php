@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <h1 class="mb-3">Configuraciones del Usuario</h1>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
  <div class="container rounded-4 p-3" style="background-color:#ffff;">
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Datos del Usuario</a>
            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Datos del Contribuyente</a>
            <a class="list-group-item list-group-item-action" id="list-representante-list" data-bs-toggle="list" href="#list-representante" role="tab" aria-controls="list-profile">Representante Legal</a>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                    <p class="text-center fw-bold fs-6" style="color:#0d6efd">Datos del Usuario</p>
                    <div class="row">
                        <div class="col-sm-7">

                        </div>

                        <!-- <div class="col-sm-5 d-flex flex-column text-center">
                            <i class='bx bx-user' style='color:#817f7f; font-size:140px;'  ></i>
                            <span class="fw-bold text-secondary" >ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.</span>
                        </div> -->
                    </div>



                </div>








                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list" style="font-size:14px;">
                    <p class="text-center fw-bold fs-6" style="color:#0d6efd">Datos del Contribuyente</p>
                    <form class="">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label" for="firstName">R.I.F.</label>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion" disabled>
                                                <option value="G" id="rif_gubernamental">G</option>
                                                <option value="J" id="rif_juridico">J</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-1">-</div> -->
                                        <div class="col-8">
                                            <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label" for="razon_social">Razon Social</label>
                                    <input name="text" type="text" id="razon_social" name="razon_social" class="form-control" value="" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input name="email" type="email" id="direccion" name="direccion" class="form-control" value="" disabled>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tlf_movil">Teléfono Movil</label>
                                    <input name="city" type="text" id="tlf_movil" class="form-control" name="tlf_movil" value="" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tlf_fijo">Teléfono Fijo</label>
                                    <input name="zip" type="text" id="tlf_fijo" class="form-control" name="tlf_fijo" value="" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label me-3" for="state">¿Empresa Artesanal?</label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineRadio1">No</label>
                                <input class="form-check-input" type="radio" name="artesanal" id="artesanal_no" value="No" disabled>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineRadio2">Si</label>
                                <input class="form-check-input" type="radio" name="artesanal" id="artesanal_si" value="Si" disabled>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary btn-sm">Editar datos</button>
                        </div>
                    </form>

                </div>


                <div class="tab-pane fade" id="list-representante" role="tabpanel" aria-labelledby="list-representante-list">


                </div>
            </div>
        </div>
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
           

        });
    </script>
  
@stop