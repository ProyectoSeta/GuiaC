
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info - QR</title>
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
</head>
<body>
    <div class="my-5 d-flex align-items-center justify-content-center flex-column">
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column text-center">
                <i class="bx bx-barcode-reader fs-1" style="color:#0c82ff"  ></i>           
                <h1 class="fs-3 fw-bold">Información del <span style="color: #0c82ff;">Talonario</span></h1>
            </div>
        </div>

        <div>
            <table class="table " style="font-size:15px;">
                <tr>
                    <th>Talonario Nro.</th>
                    <td>{{$talonario->id_talonario}}</td>
                </tr>
                <tr>
                    <th>Generado de la Solicitud Nro.</th>
                    <td>{{$talonario->id_solicitud}}</td>
                </tr>
                <tr>
                    <th>Pertenece a la Cantera</th>
                    <td>{{$talonario->nombre}}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{$talonario->lugar_aprovechamiento}}</td>
                </tr>
            </table>
        </div>

        <span class="fw-bold fs-4 my-2">Correlativo de <span style="color: #0c82ff;">Guías</span></span>

        <div>
            <table class="table mb-2" style="font-size:15px;">
                <tr>
                    <th>Desde</th>
                    @php
                        $length = 6;
                        $formato_desde = substr(str_repeat(0, $length).$talonario->desde, - $length);
                        $formato_hasta = substr(str_repeat(0, $length).$talonario->hasta, - $length);
                    @endphp
                    <td>{{$formato_desde}}</td>
                </tr>
                <tr>
                    <th>Hasta</th>
                    <td>{{$formato_hasta}}</td>
                </tr>
            </table>
        </div>

        <span class="fw-bold fs-4 my-2">Datos del <span style="color: #0c82ff;">Contribuyente</span></span>
        
        <div>
            <table class="table mb-2" style="font-size:15px;">
                <tr>
                    <th>Razon Social</th>
                    <td>{{$talonario->razon_social}}</td>
                </tr>
                <tr>
                    <th>R.I.F.</th>
                    <td>{{$talonario->rif_condicion}}-{{$talonario->rif_nro}}</td>
                </tr>
            </table>
        </div>

    </div>
    




</body>
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>

    
    

