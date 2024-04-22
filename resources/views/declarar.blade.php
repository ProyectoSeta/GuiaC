@extends('adminlte::page')

@section('title', 'Declaración')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3">Declarar Guías</h2>
            <div class="mb-3">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold btn-sm btn_declarar" data-bs-toggle="modal" data-bs-target="#modal_declarar_guias">Declarar</button>
            </div>
        </div>

        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:14px">
                <thead>
                    <th>#</th>
                    <th>Fecha emisión</th>
                    <th>Mes de pago</th>
                    <th>Guías utilizadas</th>
                    <th>UCD</th>
                    <th>Monto (Bs)</th>
                    <th>Referencia</th> 
                    <th>Estado</th> 
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                
                   
                </tbody> 
                
            </table>
            
        </div>
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- *********  ******** -->
    <div class="modal" id="modal_declarar_guias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <!-- <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i> -->
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff">Declaración - Guías de Circulación</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:15px;" id="content_modal_declarar">
                
                   

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
       ///////MODAL: INFO DECLARAR
       $(document).on('click','.btn_declarar', function(e) { 
            e.preventDefault(e); 
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("declarar.info_declarar") }}',
                success: function(response) {    
                    // console.log(response);  
                    if (response.success) {
                        $('#content_modal_declarar').html(response.html);

                        if (response.actividad == 'no') {
                            $("#actividad").removeClass('d-none');
                            $("#referencia").attr('disabled', true);
                            $(".btn_form_declarar").attr('disabled', false);
                        }else{
                            $("#actividad").addClass('d-none');
                        }
                    } else {
                        alert(response.nota);
                    }  
                    
                },
                error: function() {
                }
            });
        });

        ////////HABILITAR EL BUTTON PARA GENERAR LA SOLICITUD
        $(document).on('change','#referencia', function(e) {
            e.preventDefault(); 
            $('.btn_form_declarar').attr('disabled', false);
        });

    });

    function declararGuias(){
        var formData = new FormData(document.getElementById("form_declarar_guias"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("declarar.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    alert(response);
                    console.log(response);
                    if (response.success) {
                        alert('DECLARACIÓN REALIZADA CORRECTAMENTE');
                        window.location.href = "{{ route('declarar')}}";
                    } else {
                        alert('Ha ocurrido un error al declarar las guías.');
                    }    

                },
                error: function(error){
                    
                }
            });
    }
</script>


  
@stop