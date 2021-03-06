<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            overflow-x: hidden !important;
        }
    </style>
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

    <script>window.Laravel = '<?php echo json_encode([
            'csrfToken' => csrf_token(),]); ?>';
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="css/boleta.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</head>
<body style="background-color: #ccd0d2">
<div class="row  ">
    <div class="row " style="background-color: #FFFFFF">
        <br>
        <div class="col-sm-1 col-xs-1 col-lg-1"></div>
        <div class="col-sm-1 col-xs-1 col-lg-1">
            <img style="width: 200px;" src="{{ asset('assets/img/logo.png') }}">
        </div>
        <div class="col-sm-10 col-xs-10 col-lg-10" align="center">
            <div>
                <h1>UNIVERSIDAD NACIONAL DE TRUJILLO</h1>
            </div>
            <div>
                <h3>Pago online</h3>
            </div>
        </div>
    </div>
</div>
<div class="row " style="margin: 20px">
    <br>
    <div class="panel panel-primary" style="background-color: #FFFFFF">
        <div class="panel-heading "> Pago con tarjeta</div>
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}} </div>
            @endif
            <div class="row form-group">
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <select class=" form-group-sm form-control" id="select" name="select">
                        <option value="Dni"> Dni</option>
                        <option value="Ruc">Ruc</option>
                        <option value="Codigo de alumno">Codigo de alumno</option>
                    </select>
                </div>
                @if(isset($buscar))
                    <div class="col-sm-2 col-lg-2 col-xs-2">
                        <input class="form-control input-sm " id="buscar" name="text" type="text"
                               autocomplete="off" value="{{$buscar}}" required>input class="form-control input-sm "
                    </div>
                @else
                    <div class="col-sm-2 col-lg-2 col-xs-2">
                        <input class="form-control input-sm " id="buscar" name="text" type="text"
                               autocomplete="off" required>
                    </div>
                @endif
                <span class="col-sm-2 col-lg-2 col-xs-2">Nombres :</span>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <input class="form-control input-sm" name="nombres" type="text" id="nombres"
                           @if(isset($nombre)) value="{{$nombre}}" @endif readonly>
                    <input type="hidden" id="names">
                    <script>
                        $('#buscar').change(function () {
                            var value = $('#select option:selected').attr('value');
                            if (value == 'Dni') {
                                var id = $('#buscar').val();
                                $.ajax({
                                    url: "/buscarNombresD",
                                    type: "get",
                                    data: {name: id},
                                    success: function (data) {
                                        if (data == false) {
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
                                                    $("#selectP").empty('');
                                                    document.getElementById("selectP").disabled = true;
                                                    document.getElementById("selectP").required = false;
                                                }
                                            });
                                        }
                                        else {
                                            $('#nombres').val(data[0]);
                                            $('#apellidos').val(data[1]);
                                            $('#escuela').val(data[2]);
                                            $('#facultad').val(data[3]);
                                            if (data[4][0] === null) {
                                                $("#selectP").empty();
                                                $('#selectP').append($('<option disabled selected>').text('Seleccionar..'));
                                                document.getElementById("selectP").disabled = true;
                                                document.getElementById("selectP").required = false;
                                            }
                                            else {
                                                $("#selectP").empty();
                                                $('#selectP').append($('<option disabled selected>').text('Seleccionar..'));
                                                for (i = 0; i < data[4].length; i++) {
                                                    document.getElementById("selectP").disabled = false;
                                                    $('#selectP').append($('<option>').text(data[4][i]));
                                                }
                                            }
                                        }
                                    }
                                });
                            } else {
                                if (value == 'Ruc') {
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
                                    if (value == 'Codigo de alumno') {
                                        $.ajax({
                                            url: '/buscarNombresC',
                                            type: "get",
                                            data: {name: $('#buscar').val()},
                                            success: function (data) {
                                                $('#nombres').val(data[0]);
                                                $('#apellidos').val(data[1]);
                                                $('#escuela').val(data[2]);
                                                $('#facultad').val(data[3]);
                                                if (data[4][0] === null) {
                                                    $('#selectP').append($('<option disabled selected>').text('Seleccionar..'));
                                                    document.getElementById("selectP").disabled = true;
                                                    document.getElementById("selectP").required = false;
                                                }
                                                else {
                                                    for (i = 0; i < data[4].length; i++) {
                                                        document.getElementById("selectP").disabled = false;
                                                        $('#selectP').append($('<option>').text(data[4][i]));
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    </script>
                </div>
                <span class="col-sm-2 col-lg-2 col-xs-2">Apellidos :</span>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <input class="form-control input-sm" name="apellidos" type="text" id="apellidos"
                           @if(isset($apellidos))value="{{$apellidos}}" @endif
                           readonly>
                    <input type="hidden" id="lastname">
                </div>
            </div>
            <div class="row form-group">
                <span class="col-sm-2 col-lg-2 col-xs-2">Escuela :</span>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <input class="form-control input-sm" name="escuela" type="text" readonly
                           id="escuela"
                           @if(isset($escuela)) value="{{$escuela}}" @endif >
                </div>
                <div class="form-group-sm">
                    <span class="col-sm-2 col-lg-2 col-xs-2">Facultad :</span>
                    <div class="col-sm-2 col-lg-2 col-xs-2">
                        <input class="form-control input-sm" name="facultad" type="text" readonly
                               id="facultad"
                               @if(isset($facultad)) value="{{$facultad}}" @endif >
                    </div>
                </div>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <select class=" form-group-sm form-control" id="selectt" name="selectt">
                        <option value="Codigo tasa"> Codigo tasa</option>
                        <option value="Nombre tasa"> Nombre tasa</option>
                    </select>
                </div>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <input class="typeahead form-control" type="text" name="txtsub" id="ts" required>
                    <script>
                        var path = "{{ route('autocompletes') }}";
                        $('input.typeahead').typeahead({
                            source: function (query, process) {
                                return $.get(path, {query: query}, function (data) {
                                    var value = $('#selectt option:selected').attr('value');
                                    if (value == 'Nombre tasa') {
                                        return process(data);
                                    }
                                });
                            }
                        });
                    </script>
                </div>
                <script>
                    $('#selectt').change(function () {
                        var value = $('#selectt option:selected').attr('value');
                        if (value == 'Codigo tasa') {
                            var y = document.getElementById("st");
                            y.type = "text";
                            document.getElementById("nsub").style.visibility = "visible";
                        }
                        else {
                            if (value == 'Nombre tasa') {
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
                        if (value == 'Codigo tasa') {
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
                                            $('#p').val(value * 100);
                                            $('#total').val(value);
                                        }
                                    });
                                }
                            });
                        }
                        else {
                            if (value == 'Nombre tasa') {
                                $.ajax({
                                    url: '/precioSubtramite',
                                    type: "get",
                                    data: {name: $('#ts').val()},
                                    success: function (data) {
                                        $('#bp').val(data);
                                        var val = data * 0.04;
                                        var value = (+val) + (+data);
                                        $('#p').val(value * 100);
                                        $('#total').val(value);
                                    }
                                });
                            }
                        }
                    });
                </script>
            </div>
            <div class="row form-group">
                <span class="col-sm-2 col-lg-2 col-xs-2" id="nsub">Nombre de tasa :</span>
                <div class="col-sm-2 col-lg-2 col-xs-2">
                    <input class="form-control" type="text" name="subtramite" id="st" required readonly>
                </div>
                <!--<span class="col-sm-2 required ">Produccion :</span>
                <div class="col-sm-2">
                    <!--<select class=" form-group-sm form-control" id="selectP" name="selectP" required disabled>
                        <option selected disabled>Seleccionar..</option>
                    </select>
                    <script>
                        $('#selectP').change(function () {
                            var value = $('#selectP option:selected').attr('value');
                            if (value != 'Seleccionar..') {
                                $('#buyButton').removeAttr('disabled');
                            }
                        });
                    </script>
                </div>-->
                <span class="col-sm-2 required ">Detalle :</span>
                <div class="col-sm-2 ">
                    <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                              id="detalle"></textarea>
                </div>
                <style>
                    .required:after {
                        content: " (*) ";
                        color: #C00;
                    }
                </style>
                <script>
                    $(document).ready(function () {
                        $('#buyButton').attr('disabled', true);
                        $('#detalle').keyup(function () {
                            if ($(this).val().length != 0) {
                                $('#buyButton').attr('disabled', false);
                            }
                            else {
                                $('#buyButton').attr('disabled', true);
                            }
                        })
                    });
                </script>
            </div>
            <div class="row form-group">
                <span class="col-sm-2 col-lg-2 col-xs-2">Costo:</span>
                <div class=" col-sm-2 col-lg-2 col-xs-2">
                    <div class="col-sm-2 col-lg-2 col-xs-2">
                        S/.
                    </div>
                    <div class="col-sm-8 col-lg-8 col-xs-8">
                        <input class="form-control " name="boletapagar" id="bp" readonly>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <span class="col-sm-1 col-lg-2 col-xs-2">Total a pagar <font color="red">(+4%)</font>:</span>
                <div class=" col-sm-2 col-lg-2 col-xs-2">
                    <div class="col-sm-2 col-lg-2 col-xs-2">
                        S/.
                    </div>
                    <div class="col-sm-8 col-lg-8 col-xs-8">
                        <input class="form-control " name="total" id="total" readonly>
                        <input type="hidden" id="p" readonly>
                        <script>
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-lg-2 col-xs-4"></div>
            <a href="http://www.google.com.pe" class=" btn btn-danger col-sm-2"> <span
                        class="glyphicon glyphicon-ban-circle"></span> Cancelar
            </a>
            <div class="col-sm-1"></div>
            <button id="buyButton" type="submit" name="enviar" class="col-sm-2 btn btn-success" disabled><span
                        class="glyphicon glyphicon-check"></span> Pagar
            </button>
            <div class="col-sm-1"></div>
            <a class=" btn btn-warning col-sm-2" style="display: none;" id="print" onclick="action()"><span
                        class="glyphicon glyphicon-print"></span> Imprimir</a>
        </div>
        <div class="row">
            <footer class="footer row col-sm-12 col-lg-12 col-xs-12">
                <p align="right">© 2016 ÑuxtuSoft, S.A.C.</p>
            </footer>
        </div>
    </div>
    <!-- Incluyendo .js de Culqi Checkout-->
    <script src="https://checkout.culqi.com/v2"></script>
    <!-- Configurando el checkout-->
    <script>
        Culqi.publicKey = 'pk_test_kenUEv1GL5NAM7OO';
    </script>
    <!-- Configurando el checkout-->
    <script>
        $('#detalle').change(function () {
            if ($('#st').val()) {
                var x = document.getElementById("st").value;
            }
            else {
                var x = document.getElementById("ts").value;
            }
            Culqi.settings({
                title: 'Tesoreria UNT',
                currency: 'PEN',
                description: x,
                amount: $('#p').val()
            });
        });
    </script>
    <script>
        $('#buyButton').on('click', function (e) {
            // Abre el formulario con las opciones de Culqi.settings
            Culqi.open();
            e.preventDefault()
        });
    </script>
    <script>
        function culqi() {
            if (Culqi.token) { // ¡Token creado exitosamente!
                // Get the token ID:
                var token = Culqi.token.id;
                //alert('Se ha creado un token:'+token);
                $.ajax({
                    url: 'pagoculqi',
                    type: "post",
                    datatype: 'json',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        token: token,
                        buscar: $('#buscar').val(),
                        precio: $('#p').val(),
                        select: $('#select').val(),
                        subtramite: $('#st').val(),
                        nombres: $('#names').val(),
                        apellidos: $('#lastname').val(),
                        detalle: $('#detalle').val(),
                        selectP: $('#selectP').val(),
                        text: $('#ts').val(),
                        email: Culqi.token.email
                    },
                    success: function (data) {
                        if (data != 'bad') {
                            alert('Se guardo pago, imprima su boleta');
                            document.getElementById("print").style.display = "";
                            document.getElementById("print").href = '/BoletaVirtual/' + data + '';
                        }
                        else {
                            if (data == 'bad') {
                                document.getElementById("print").style.display = "none";
                                document.getElementById("print").href = "#";
                                alert('No se guardo pago');
                            }
                        }
                    }
                });
            } else { // ¡Hubo algún problema!
                // Mostramos JSON de objeto error en consola
                console.log(Culqi.error);
                alert(Culqi.error.mensaje);
            }
        }
    </script>
    <script>
        function action() {
            if (document.getElementById("print").style.display !== "none") {
                document.getElementById('print').style.display = 'none';
            }
        }
    </script>
    <!-- Modal -->
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
                    <p><font color="red">LOS PAGOS ONLINE TIENEN UN COSTE ADICIONAL DEL 4% POR GASTOS
                            ADMINISTRATIVOS</font></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#memberModal').modal('show');
        });
    </script>
    <!-- /#wrapper -->
    <!-- /#wrapper -->
    <!-- /#wrapper -->
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="{{asset('assets/js/morris/raphael-2.1.0.min.js')}}"></script>
    <script src="{{asset('assets/js/morris/morris.js')}}"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <!-- Extra JavaScript/CSS added manually in "Settings" tab -->
    <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <!-- Javascript -->
    <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>

    <!--[if lt IE 10]>
    <script src="{{asset('assets/js/placeholder.js')}}"></script>
    <![endif]-->
</div>
</div>
</body>
</html>