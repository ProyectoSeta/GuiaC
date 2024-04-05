@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')

    <div class="row pt-4" style="font-size: 15px;">
        <div class="col-lg-4 text-center">
            <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg>
            <h4 class="fw-normal">Registrar Cantera(s)</h4>
            <p>Amigo contribuyente, para relizar la solicitud de Guías de Circulación, primeramente deberá registrar las canteras adjudicadas a su empresa.</p>
            <p><a class="btn btn-secondary btn-sm" href="{{ route('cantera') }}">Registrar Cantera(s) »</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4 text-center">
            <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg>
            <h4 class="fw-normal">Realizar Solicitud</h4>
            <p>Una vez verificadas las Canteras registradas, podrá realizar la solicitud de Guías de Circulación para cada Cantera.</p>
            <p><a class="btn btn-secondary  btn-sm" href="{{ route('solicitud') }}">Realizar Solicitud »</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4 text-center">
            <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg>
            <h4 class="fw-normal">Retirar Talonario</h4>
            <p>Aprobada la Solicitud, se le notificará que el Talonario ya está listo para retirar (El estado de su Solicitud cambiará a "Retirar"). Este proceso llevara un tiempo estimado de 2 a 3 días hábiles.</p>
            <p><a class="btn btn-secondary  btn-sm" href="{{ route('solicitud') }}">Ver Estado »</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

    <div class="row mx-5 px-5" style="font-size: 15px;">
        <div class="col-lg-6 text-center">
            <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg>
            <h4 class="fw-normal">Registrar Guías</h4>
            <p>Amigo contribuyente, debe subir todas las guías que han sido utilizadas en la(s) Cantera(s), así estas hayan sido anuladas. Para que, pueda cumplir con el deber formal.</p>
            <p><a class="btn btn-secondary  btn-sm" href="{{ route('registro_guia') }}">Registrar Guía »</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-6 text-center">
            <svg class=" rounded-circle text-bg-primary bg-gradient" width="60" height="60"></svg>
            <h4 class="fw-normal">Declarar Guías de Circulación</h4>
            <p>Según el calendario fiscal vigente a la fecha, deberá declarar las guías que haya utilizado en el período de tiempo establecido.</p>
            <p><a class="btn btn-secondary  btn-sm" href="#">Ver Estado »</a></p>
        </div><!-- /.col-lg-4 -->
    </div>




@stop

@section('css')
    
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <!-- <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script>
        const myCarouselElement = document.querySelector('#infoCarousel');
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 4000,
            touch: false
        });

        // const carousel = bootstrap.Carousel.getInstance(myCarouselElement); // Retrieve a Carousel instance

        myCarouselElement.addEventListener('slid.bs.carousel', event => {
            carousel.to('2'); // Will slide to the slide 2 as soon as the transition to slide 1 is finished
        })

        carousel.to('1'); // Will start sliding to the slide 1 and returns to the caller
        carousel.to('2'); // !! Will be ignored, as the transition to the slide 1 is not finished !!
    </script> -->
    
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <!-- <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script> -->
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
@stop