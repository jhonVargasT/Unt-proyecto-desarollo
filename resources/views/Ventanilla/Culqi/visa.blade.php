<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <style>
        body {
            overflow-x: hidden !important;
        }
    </style>
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

    <script>
        window.Laravel = ' {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!}';
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
</head>
<body>
<div class="panel-body">
    <div class="panel-body" style="background-color: #FFFFFF">
        <div class="row">
            <div class="col-sm-4 col-xs-4 col-lg-4 form-group-sm ">
            </div>
            <div class="col-sm-3 col-xs-3 col-lg-3 form-group-sm ">
                <a href="http://www.unitru.edu.pe/"><img style="height: 150px;"
                                                         src="{{ asset('assets/img/universidad.png') }}"></a>
            </div>
        </div>
    </div>
</div>
<div class="panel-body">
    <form name="form" action="{{url('/visaPago')}}" role="Form" method="POST" class="Horizontal">
        {{csrf_field()}}
        <div class="panel panel-primary">
            @if(isset($form))
                <div class="panel-heading primary"><h5>Finalizar Compra</h5></div>
            @else
                <div class="panel-heading primary"><h5>Crear Compra</h5></div>
            @endif
            <div class="panel-body">
                <div class="row">
                    @if(isset($form))
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1">&nbsp;</span>
                            <select class=" form-group-sm form-control" id="select" name="select" disabled>
                                <option> @if(isset($select)){{$select}}@endif</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1">&nbsp;</span>
                            <input class="form-control input-sm " id="buscar" name="text"
                                   autocomplete="off" readonly value="@if(isset($text)){{$text}}@endif">
                        </div>
                    @else
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1  text-danger">(*)</span>
                            <select class=" form-group-sm form-control" id="select" name="select">
                                <option value="Codigo de alumno">Codigo de Matricula</option>
                                <option value="Dni"> DNI</option>
                                <option value="Ruc">RUC</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1  text-danger">(*)</span>
                            <input class="form-control input-sm " id="buscar" name="text"
                                   autocomplete="off" required>
                        </div>
                    @endif
                    <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                        <span class="col-sm-1 col-lg-1 col-xs-1">Nombres:</span>
                        <input class="form-control input-sm" name="nombres" id="nombres"
                               @if(isset($nombres)) value="{{$nombres}}" @endif readonly tabindex="-1">
                    </div>
                    <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                        <span class="col-sm-1 col-lg-1 col-xs-1">Apellidos:</span>
                        <input class="form-control input-sm" name="apellidos" id="apellidos"
                               @if(isset($apellidos))value="{{$apellidos}}" @endif
                               readonly tabindex="-1">
                    </div>
                    <script>
                        $('#buscar').change(function () {
                            var value = $('#select option:selected').attr('value');
                            if (value === 'Dni') {
                                var id = $('#buscar').val();
                                $.ajax({
                                    url: "/buscarNombresD",
                                    type: "get",
                                    data: {name: id},
                                    success: function (data) {
                                        if (data === false) {
                                            $('#nombres').val(data);
                                            $.ajax({
                                                url: '/buscarNombresDR',
                                                type: "get",
                                                data: {name: id},
                                                success: function (data) {
                                                    $('#nombres').val(data[0]);
                                                    $('#apellidos').val(data[1]);
                                                    $('#escuela').val('');
                                                    $('#facultad').val('');
                                                }
                                            });
                                        }
                                        else {
                                            $('#nombres').val(data[0]);
                                            $('#apellidos').val(data[1]);
                                            $('#escuela').val(data[2]);
                                            $('#facultad').val(data[3]);
                                        }
                                    }
                                });
                            } else {
                                if (value === 'Ruc') {
                                    $.ajax({
                                        url: '/buscarNombresR',
                                        type: "get",
                                        data: {name: $('#buscar').val()},
                                        success: function (data) {
                                            $('#nombres').val(data[0]);
                                            $('#apellidos').val(data[1]);
                                        }
                                    });
                                } else {
                                    if (value === 'Codigo de alumno') {
                                        $.ajax({
                                            url: '/buscarNombresC',
                                            type: "get",
                                            data: {name: $('#buscar').val()},
                                            success: function (data) {
                                                $('#nombres').val(data[0]);
                                                $('#apellidos').val(data[1]);
                                                $('#escuela').val(data[2]);
                                                $('#facultad').val(data[3]);
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    </script>
                </div>
                <br>
                <div class=" row ">
                    <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                        <span class="col-sm-1 col-lg-1 col-xs-1">Escuela:</span>
                        <input class="form-control input-sm" name="escuela" readonly
                               id="escuela" tabindex="-1"
                               @if(isset($escuela)) value="{{$escuela}}" @endif >
                    </div>
                    <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                        <span class="col-sm-1 col-lg-1 col-xs-1">Facultad:</span>
                        <input class="form-control input-sm" name="facultad" readonly
                               id="facultad" tabindex="-1"
                               @if(isset($facultad)) value="{{$facultad}}" @endif >
                    </div>
                </div>
                <br>
                <div class=" row ">
                    @if(isset($form))
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1">&nbsp;</span>
                            <select class=" form-group-sm form-control" id="selectt" name="selectt" disabled>
                                <option>@if(isset($selectt)){{$selectt}}@endif</option>
                            </select>
                        </div>

                    @else
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1  text-danger">(*)</span>
                            <select class=" form-group-sm form-control" id="selectt" name="selectt">
                                <option value="Codigo tasa"> Codigo Tasa</option>
                                <option value="Nombre tasa"> Nombre Tasa</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-xs-5 col-lg-3 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1  text-danger">(*)</span>
                            <input class="typeahead form-control" name="txtsub" id="ts" required>
                            <script>
                                var path = "{{ route('autocompletes') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        return $.get(path, {query: query}, function (data) {
                                            var value = $('#selectt option:selected').attr('value');
                                            if (value === 'Nombre tasa') {
                                                return process(data);
                                            }
                                        });
                                    }
                                });
                            </script>
                        </div>
                    @endif
                    <script>
                        $('#selectt').change(function () {
                            var value = $('#selectt option:selected').attr('value');
                            if (value === 'Codigo tasa') {
                                var y = document.getElementById("st");
                                y.type = "text";
                                document.getElementById("nsub").style.visibility = "visible";
                            }
                            else {
                                if (value === 'Nombre tasa') {
                                    var x = document.getElementById("st");
                                    x.type = "hidden";
                                    document.getElementById("nsub").style.visibility = "hidden";
                                }
                            }
                        });
                    </script>
                    <script>
                        $('#ts').change(function () {
                            var value = $('#selectt option:selected').attr('value');
                            if (value === 'Codigo tasa') {
                                var id = $('#ts').val();
                                $.ajax({
                                    url: "/nombreSCT",
                                    type: "get",
                                    data: {ct: id},
                                    success: function (data) {
                                        $('#st').val(data);
                                        $.ajax({
                                            url: '/precioSubtramite',
                                            type: "get",
                                            data: {name: $('#st').val()},
                                            success: function (data) {
                                                $('#bp').val(data);
                                                var val = data * 0.04;
                                                var value = (+val) + (+data);
                                                $('#total').val(value);
                                                if (value === 0 || value === '') {
                                                    $('#enviar').attr('disabled', 'disabled');
                                                }
                                                else {
                                                    $('#idt').val(id);
                                                    $('#enviar').removeAttr('disabled');
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                            else {
                                if (value === 'Nombre tasa') {
                                    $.ajax({
                                        url: '/precioSubtramite',
                                        type: "get",
                                        data: {name: $('#ts').val()},
                                        success: function (data) {
                                            var nombre = $('#ts').val();
                                            $('#st').val(nombre);
                                            $('#bp').val(data);
                                            var val = data * 0.04;
                                            var value = (+val) + (+data);
                                            $('#total').val(value);
                                            if (value === 0 || value === '') {
                                                $('#enviar').attr('disabled', 'disabled');
                                            }
                                            else {
                                                $.ajax({
                                                    url: '/codigoSubtramite',
                                                    type: "get",
                                                    data: {name: $('#ts').val()},
                                                    success: function (data) {
                                                        $('#idt').val(data);
                                                    }
                                                });
                                                $('#enviar').removeAttr('disabled');
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    </script>
                    <div class="col-sm-10 col-xs-5 col-lg-6 form-group-sm ">
                        <span class="col-sm-1 col-lg-1 col-xs-1" id="nsub">Concepto:</span>
                        <input class="form-control" name="subtramite" id="st" required readonly
                               value="@if(isset($subtramite)){{$subtramite}}@endif" tabindex="-1">
                        <input class="form-control" type="hidden" name="idt" id="idt" required readonly tabindex="-1"
                               value="@if(isset($id)){{$id}}@endif">
                    </div>
                </div>
                <br>
                <div class=" row ">
                    @if(isset($form))
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1">Detalle:</span>
                            <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                                      id="detalle" readonly>@if(isset($detalle)){{$detalle}}@endif</textarea>
                        </div>
                    @else
                        <div class="col-sm-10 col-xs-5 col-lg-2 form-group-sm ">
                            <span class="col-sm-1 col-lg-1 col-xs-1">Detalle:</span>
                            <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                                      id="detalle"></textarea>
                        </div>
                    @endif
                </div>
                <br>
                <div class=" row ">
                    <span class="col-sm-2 col-lg-2 col-xs-2">Costo S/.</span>
                    <div class="col-sm-1 col-xs-3 col-lg-1 form-group-sm ">
                        <input class="form-control " name="boletapagar" id="bp" readonly
                               value="@if(isset($boletapagar)){{$boletapagar}}@endif" tabindex="-1">
                    </div>
                </div>
                <br>
                <div class=" row ">
                    <span class="col-sm-2 col-lg-2 col-xs-2 text-danger">Pagar S/.</span>
                    <div class="col-sm-1 col-xs-3 col-lg-1 form-group-sm text-danger">
                        <input class="form-control " name="total" id="total" readonly
                               value="@if(isset($total)){{$total}}@endif" tabindex="-1">
                    </div>
                </div>
                @if(isset($form))
                @else
                    <br>
                    <div class="row">
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <label class="text-danger">(*) Campos obligatorios</label>
                    </div>
                @endif
            </div>
        </div>
        @if(isset($form))
        @else
            <div class="row">
                <div class="col-xs-3"></div>
                <div class="col-xs-4">
                    <a href="{{url('/redirect')}}" class=" col-md-6 btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </a>
                </div>
                <div class="col-xs-4">
                    <button id="enviar" disabled onclick="registrarPago()"
                            name="enviar" class="col-md-6 btn btn-sm btn-success"><span
                                class="glyphicon glyphicon-menu-right"></span> Siguiente
                    </button>
                </div>
            </div>
        @endif
    </form>
    @if(isset($form))
        <div class="row">
            <div class="col-xs-3"></div>
            <div class="col-xs-3">
                <a href="{{url('/visa')}}" class=" col-md-6 btn btn-sm btn-warning"><span
                            class="glyphicon glyphicon-menu-left"></span>
                    Regresar
                </a>
            </div>
            <div class="col-xs-4">
                {!! $form !!}
            </div>
        </div>
    @endif
</div>
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <div class="panel-heading" align="center"><img src="assets/img/logo.png"
                                                               style="width:150px;height:100px;"></div>
                <h4 class="modal-title" id="memberModalLabel" align="center">Universidad Nacional de Trujillo -
                    Tesoreria</h4>
            </div>
            <div class="modal-body">
                <p><font color="red">*IMPORTANTE*</font></p>
                <p><font color="red">LOS PAGOS ONLINE TIENEN UN COSTE ADICIONAL DEL 2.5% POR GASTOS
                        ADMINISTRATIVOS</font></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@if(isset($form))
@else
    <script>
        $(document).ready(function () {
            $('#memberModal').modal('show');
        });
    </script>
@endif
</body>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h4 class="title">Contactanos</h4>
                <p>Direccion: Av. Juan Pablo II, Trujillo, Peru</p>
                <p>Telefono: (044) 209020</p>
                <p>Correo: unt.unitru.edu.pe</p>
                <ul class="social-icon">
                    <a href="https://www.facebook.com/untlaunicaoficial/" class="social"><i class="fa fa-facebook"
                                                                                            aria-hidden="true"></i></a>
                    <a href="https://twitter.com/unitruoficial?lang=es" class="social"><i class="fa fa-twitter"
                                                                                          aria-hidden="true"></i></a>
                </ul>
            </div>
            <div class="col-sm-3">
                <h4 class="title"> Metodos de pago</h4>
                <ul class="payment">
                    <li><a href="https://www.visanet.com.pe/"><i><img style="height: 35px;"
                                                                      src="{{ asset('assets/img/visa_pos_fc.png')}}"></i></a>
                    </li>
                    <li><a href="https://www.visanet.com.pe/"><i><img style="height: 35px;"
                                                                      src="{{ asset('assets/img/vbyvisa_blu.png')}}"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>
    <script src="{{asset('assets/js/placeholder.js')}}"></script>
</footer>
<style>
    /*FOOTER START///////////////////*/
    .footer {
        padding: 1px 0 1px 0;
        background-color: #23527c;
        color: #878c94;
    }

    .footer .title {
        text-align: left;
        color: #fff;
        font-size: 25px;
    }

    .footer .social-icon a {
        display: inline-block;
        color: #fff;
        font-size: 25px;
        padding: 5px;
    }

    .footer .acount-icon a {
        display: block;
        color: #fff;
        font-size: 18px;
        padding: 5px;
        text-decoration: none;
    }

    .footer .category a {
        text-decoration: none;
        color: #fff;
        display: inline-block;
        padding: 5px 20px;
        margin: 1px;
        border-radius: 4px;
        margin-top: 6px;
        background-color: black;
        border: solid 1px #fff;
    }

    .footer .payment li {
        list-style-type: none
    }

    .footer .payment li a {
        text-decoration: none;
        display: inline-block;
        color: #fff;
        float: left;
        font-size: 25px;
        padding: 10px 10px;
    }
</style>
