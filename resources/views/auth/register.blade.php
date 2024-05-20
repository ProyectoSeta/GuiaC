@extends('layouts.app')

@section('content')

<div id="body_sesion_resgister" class="position-relative">
    <div class="px-4 py-5 px-md-5 text-center text-lg-start" id="div_body_session">
            <div class="container">
            <div class="row gx-lg-5 align-self-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-3 fw-bold ls-tight">
                    Registrate para solicitar tu<br />
                    <span class="text-primary">Guía de Circulación</span>
                </h1>
                <p style="color: hsl(0, 0%, 20.8%)">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                    quibusdam tempora at cupiditate quis eum maiores libero
                    veritatis? Dicta facilis sint aliquid ipsum atque?
                </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5 pt-4 pb-4">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('assets/logo-seta.png')}}" class="img-fluid pb-3" alt="" width="190px">
                        </div>
                        <ul class="nav nav-pills nav-justified me-5 ms-5 mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-login" data-mdb-toggle="pill" href="{{route('login')}}" role="tab"
                                aria-controls="pills-login" aria-selected="true">Login</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab-register" data-mdb-toggle="pill" href="{{route('register')}}" role="tab"
                                aria-controls="pills-register" aria-selected="false">Registrarse</a>
                            </li>
                        </ul>

                        <!-- Pills content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                <form  method="POST" action="{{route('user.store') }}">
                                @csrf
                                {{-- DATOS : SUJETO PASIVO --}}
                                <div class="text-muted fw-semibold text-center title_resgister_form">
                                    <span>Datos del Contribuyente</span>
                                </div>
                                <!-- R.I.F input -->
                                <label class="form-label" for="rif">R.I.F.</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion">
                                            <option value="G" id="rif_gubernamental">G</option>
                                            <option value="J" id="rif_juridico">J</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" autofocus value="{{ old('rif_nro') }}"/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                                    </div>
                                </div>

                                <!-- razon social input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger"> *</span>
                                    <input type="text" id="razon_social" class="form-control form-control-sm" name="razon_social" value="{{ old('razon_social') }}"/>
                                </div>

                                <!-- artesanal? input -->
                                <label class="form-label" for="razon_social">Empresa artesanal</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_no" value="No" checked disabled>
                                    <label class="form-check-label" for="artesanal_no">No</label>
                                </div>
                                <div class="form-check form-check-inline mb-2">
                                    <input class="form-check-input" type="radio" name="artesanal" id="artesanal_si" value="Si" disabled>
                                    <label class="form-check-label" for="artesanal_si">Si</label>
                                </div>

                                <!-- direccion input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="direccion">Dirección</label><span class="text-danger"> *</span>
                                    <input type="text" id="direccion" class="form-control form-control-sm" name="direccion" value="{{ old('direccion') }}"/>
                                </div>

                                <!-- tlf movil input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_movil">Teléfono Movil</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" placeholder="Ejemplo: 04125231102" value="{{ old('tlf_movil') }}"/>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>

                                <!-- tlf fijo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_fijo">Teléfono Fijo</label>
                                    <input type="number" id="tlf_fijo" class="form-control form-control-sm" name="tlf_fijo" placeholder="Ejemplo: 02432632201" value="{{ old('tlf_fijo') }}"/>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 02432632201</p>
                                </div>

                                {{-- DATOS : REPRESENTANTE --}}
                                <div class="text-muted fw-semibold text-center title_resgister_form mt-3 mb-2">
                                    <span>Datos del Representante</span>
                                </div>

                                <!-- rif:repr input -->
                                <label class="form-label" for="rif_repr">R.I.F. del Representante</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion_repr" aria-label="Default select example" name="rif_condicion_repr">
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif_nro_repr" class="form-control form-control-sm" name="rif_nro_repr" placeholder="Ejemplo: 084561221" value="{{ old('rif_nro_repr') }}"/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 084561221</p>
                                    </div>
                                </div>

                                <!-- ci:repr input -->
                                <label class="form-label" for="ci_repr">Cédula del Representante</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="ci_condicion_repr" aria-label="Default select example" name="ci_condicion_repr">
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="ci_nro_repr" class="form-control form-control-sm" name="ci_nro_repr" placeholder="Ejemplo: 8456122" value="{{ old('ci_nro_repr') }}"/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>

                                 <!-- nombre:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="name_repr">Nombre del Representante</label><span class="text-danger"> *</span>
                                    <input type="text" id="name_repr" class="form-control form-control-sm" name="name_repr" value="{{ old('name_repr') }}"/>
                                </div>

                                 <!-- tlf:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_repr">Teléfono del Representante</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_repr" class="form-control form-control-sm" name="tlf_repr" placeholder="Ejemplo: 04125231102" value="{{ old('tlf_repr') }}"/>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>

                                {{-- DATOS : USUARIO --}}
                                <div class="text-muted fw-semibold text-center title_resgister_form mt-3 mb-2">
                                    <span>Datos del Usuario</span>
                                </div>

                                <!-- correo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="name">Nombre</label><span class="text-danger"> *</span>
                                    <input type="text" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- correo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="email">Correo electrónico</label><span class="text-danger"> *</span>
                                    <input type="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="example@gmail.com" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                 <!-- pass input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="password">Contraseña</label><span class="text-danger"> *</span>
                                    <input type="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- pass input -->
                                <div class="form-outline mb-2">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                                
                                <div class="text-muted mt-4" style="font-size:14px">
                                    <span>La Contraseña debe contener:</span>
                                    <ol>
                                        <li>Mínimo 8 caracteres.</li>
                                        <li>Caracteres alfanuméricos.</li>
                                        <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &, entre otros.).</li>
                                    </ol>
                                </div>
                                

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-center">
                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mt-3 mb-3">{{ __('Registrarse') }}</button>
                                </div>
                                
                                

                                
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div> <!--cierra class.row -->
            </div> <!--cierra class.container -->

            
     </div> <!--cierra id.div_body_session -->
     <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
        <img src="{{asset('assets/gobierno.png')}}" alt="" width="150px">
        <img src="{{asset('assets/aragua.png')}}" alt="" width="75px">
        <img src="{{asset('assets/logo-seta.png')}}" alt="" class="mt-3 ms-2" width="140px">
    </div>
</div> <!--cierra id.body_sesion_register -->


@endsection



@section('js')
<script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
<script type="text/javascript">
    $(document).ready(function () {
        console.log('hol5ss');
        ///////HABILITAR EL CAMPO DE ARTESANAL
        $(document).on('change','#rif_condicion', function(e) { 
            e.preventDefault(e); 
            var value = $("#rif_condicion").val();

           if (value == 'J') {
                $("#artesanal_no").attr('disabled', false);
                $("#artesanal_si").attr('disabled', false); 
           }else{
                $("#artesanal_no").attr('disabled', true);
                $("#artesanal_si").attr('disabled', true); 
           }
        });           

    });
</script>


@stop