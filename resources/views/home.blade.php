@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')
    <div class="position-relative">
        <div>
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('assets/banner1.svg')}}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('assets/banner2.svg')}}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('assets/banner3.svg')}}" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="content" id="content-home">
            <div class="row pt-4 mb-3" style="font-size: 15px;">
                <div class="col-lg-4 text-center">
                    <span class="badge rounded-circle bg-gradient-danger fs-3 mb-2">1</span>
                    <!-- <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg> -->
                    <h4 class="fw-semibold titulo text-navy">Registrar Cantera(s)</h4>
                    <p class="text-muted">Amigo contribuyente, para relizar la solicitud de Guías de Circulación, primeramente deberá registrar las canteras adjudicadas a su empresa.</p>
                    <p><a class="btn bg-navy btn-sm" href="{{ route('cantera') }}">Registrar Cantera(s) »</a></p>
                </div><!-- /.col-lg-4 -->

                <div class="col-lg-4 text-center">
                    <span class="badge rounded-circle bg-gradient-danger fs-3 mb-2">2</span>
                    <h4 class="fw-semibold titulo text-navy">Realizar Solicitud</h4>
                    <p class="text-muted">Una vez verificadas las Canteras registradas, podrá realizar la solicitud de Guías de Circulación para cada Cantera.</p>
                    <p><a class="btn bg-navy  btn-sm" href="{{ route('solicitud') }}">Realizar Solicitud »</a></p>
                </div><!-- /.col-lg-4 -->

                <div class="col-lg-4 text-center">
                    <span class="badge rounded-circle bg-gradient-danger fs-3 mb-2">3</span>
                    <h4 class="fw-semibold titulo text-navy">Retirar Talonario</h4>
                    <p class="text-muted">Aprobada la Solicitud, se le notificará que el Talonario ya está listo para retirar (El estado de su Solicitud cambiará a "Retirar"). Este proceso llevara un tiempo estimado de 2 a 3 días hábiles.</p>
                    <p><a class="btn bg-navy  btn-sm" href="{{ route('solicitud') }}">Ver Estado »</a></p>
                </div><!-- /.col-lg-4 -->

            </div><!-- /.row -->

            <div class="row mx-5 px-5" style="font-size: 15px;">
                <div class="col-lg-6 text-center">
                    <span class="badge rounded-circle bg-gradient-danger fs-3 mb-2">4</span>
                    <h4 class="fw-semibold titulo text-navy">Registrar Guías</h4>
                    <p class="text-muted">Amigo contribuyente, debe subir todas las guías que han sido utilizadas en la(s) Cantera(s), así estas hayan sido anuladas. Para que, pueda cumplir con el deber formal.</p>
                    <p><a class="btn bg-navy  btn-sm" href="{{ route('registro_guia') }}">Registrar Guía »</a></p>
                </div><!-- /.col-lg-4 -->

                <div class="col-lg-6 text-center">
                    <span class="badge rounded-circle bg-gradient-danger fs-3 mb-2">5</span>
                    <h4 class="fw-semibold titulo text-navy">Declarar Guías de Circulación</h4>
                    <p class="text-muted">Según el calendario fiscal vigente a la fecha, deberá declarar las guías que haya utilizado en el período de tiempo establecido.</p>
                    <p><a class="btn bg-navy  btn-sm" href="{{ route('declarar') }}">Ver Estado »</a></p>
                </div><!-- /.col-lg-4 -->
            </div>
        </div>



        <!-- <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
            <img src="{{asset('assets/gobierno.png')}}" alt="" width="150px">
            <img src="{{asset('assets/aragua.png')}}" alt="" width="75px">
            <img src="{{asset('assets/logo-seta.png')}}" alt="" class="mt-3 ms-2" width="140px">
        </div> -->

    </div>
    

    




@stop

@section('footer')

    <div class="d-flex justify-content-end align-items-center pb-1 my-0"> 
        <img src="{{asset('assets/logo-seta.png')}}" class=" mt-3 me-3" alt="" width="130px">
        <img src="{{asset('assets/aragua.png')}}" class="me-3" alt="" width="75px">
        <img src="{{asset('assets/gobierno.png')}}" class="" alt="" width="140px">
    </div>
        
@stop

@section('css')
    
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>


    <script type="text/javascript">
        $(document).ready(function () {
            console.log('holiss');
            /////////////cierre de libros
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("home.libro") }}',
                success: function(response) {    
                    console.log(response);  
                    
                },
                error: function() {
                }
            });

        });
    </script>
  
@stop