@extends('Ventanilla.BodyCulqi')
<meta name="_token" content="{{ csrf_token() }}">
<title>Pago Tarjeta</title>
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel panel-primary ">
        <div class="panel-heading "> Realizar pago tarjeta</div>
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}} </div>
            @endif
            <div class="col-sm-12">
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="right">
                        <div class="col-sm-2 ">
                            <select class=" form-group-sm form-control" id="select" name="select">
                                <option value="Dni"> Dni</option>
                                <option value="Ruc">Ruc</option>
                                <option value="Codigo de alumno">Codigo de alumno</option>
                            </select>
                        </div>
                        @if(isset($buscar))
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="buscar" name="text" type="text"
                                       autocomplete="off" value="{{$buscar}}" required>
                            </div>
                        @else
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="buscar" name="text" type="text"
                                       autocomplete="off" required>
                            </div>
                        @endif
                    </div>
                    <div class="form-group-sm">
                        <span class="col-sm-2">Nombres</span>
                        <div class="col-sm-4">
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
                                                            $('#nombres').val(data);
                                                            $('#names').val(data);
                                                        }
                                                    });
                                                }
                                                else {
                                                    $('#nombres').val(data);
                                                    $('#names').val(data)
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
                                                    $('#nombres').val(data)
                                                    $('#names').val(data)
                                                }
                                            });
                                        } else {
                                            if (value == 'Codigo de alumno') {
                                                $.ajax({
                                                    url: '/buscarNombresC',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#nombres').val(data);
                                                        $('#names').val(data)
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Apellidos</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="apellidos" type="text" id="apellidos"
                                   @if(isset($apellidos))value="{{$apellidos}}" @endif
                                   readonly>
                            <input type="hidden" id="lastname">
                            <script>
                                $('#buscar').change(function () {
                                    var value = $('#select option:selected').attr('value');
                                    if (value == 'Dni') {
                                        var id = $('#buscar').val();
                                        $.ajax({
                                            url: '/buscarApellidosD',
                                            type: "get",
                                            data: {name: id},
                                            success: function (data) {
                                                if (data == false) {
                                                    $('#apellidos').val(data)
                                                    $.ajax({
                                                        url: '/buscarApellidosDR',
                                                        type: "get",
                                                        data: {name: id},
                                                        success: function (data) {
                                                            $('#apellidos').val(data);
                                                            $('#lastname').val(data);
                                                        }
                                                    });
                                                }
                                                else {
                                                    $('#apellidos').val(data);
                                                    $('#lastname').val(data);
                                                }
                                            }
                                        });
                                    } else {
                                        if (value == 'Ruc') {
                                            $.ajax({
                                                url: '/buscarApellidosR',
                                                type: "get",
                                                data: {name: $('#buscar').val()},
                                                success: function (data) {
                                                    $('#apellidos').val(data);
                                                    $('#lastname').val(data);
                                                }
                                            });
                                        } else {
                                            if (value == 'Codigo de alumno') {
                                                $.ajax({
                                                    url: '/buscarApellidosC',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#apellidos').val(data);
                                                        $('#lastname').val(data);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <span class="col-sm-2">Escuela</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="escuela" type="text" readonly id="escuela"
                                   @if(isset($escuela)) value="{{$escuela}}" @endif >
                            <script>
                                $('#buscar').change(function () {
                                    var value = $('#select option:selected').attr('value');
                                    if (value == 'Dni') {
                                        $.ajax({
                                            url: '/buscarEscuelaD',
                                            type: "get",
                                            data: {name: $('#buscar').val()},
                                            success: function (data) {
                                                $('#escuela').val(data);
                                            }
                                        });
                                    } else {
                                        if (value == 'Ruc') {
                                            $.ajax({
                                                success: function () {
                                                    $('#escuela').val('');
                                                }
                                            });
                                        } else {
                                            if (value == 'Codigo de alumno') {
                                                $.ajax({
                                                    url: '/buscarEscuelaC',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#escuela').val(data);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Facultad</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="facultad" type="text" readonly id="facultad"
                                   @if(isset($facultad)) value="{{$facultad}}" @endif >
                            <script>
                                $('#buscar').change(function () {
                                    var value = $('#select option:selected').attr('value');
                                    if (value == 'Dni') {
                                        $.ajax({
                                            url: '/buscarFacultadD',
                                            type: "get",
                                            data: {name: $('#buscar').val()},
                                            success: function (data) {
                                                $('#facultad').val(data);
                                            }
                                        });
                                    } else {
                                        if (value == 'Ruc') {
                                            $.ajax({
                                                success: function () {
                                                    $('#facultad').val('');
                                                }
                                            });
                                        }
                                        else {
                                            if (value == 'Codigo de alumno') {
                                                $.ajax({
                                                    url: '/buscarFacultadC',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#facultad').val(data);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-2 ">
                        <select class=" form-group-sm form-control" id="selectt" name="selectt">
                            <option value="Codigo tasa"> Codigo tasa</option>
                            <option value="Nombre tasa"> Nombre tasa</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
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
                                                var val = data * 100;
                                                $('#p').val(val);
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
                                            var val = data * 100;
                                            $('#p').val(val);
                                        }
                                    });
                                }
                            }
                        });
                    </script>
                </div>
                <div class="col-sm-12 row form-group">
                    <span class="col-sm-2" id="nsub">Nombre de subtramite :</span>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="subtramite" id="st" required readonly>
                    </div>
                    <div class="form-group-sm">
                        <span class="col-sm-2">Detalle </span>
                        <div class="col-sm-4">
                                <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                                          id="detalle"></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2 ">Costo de boleta:</span>
                        <div class=" col-sm-4">
                            <div class="col-sm-1">
                                S/.
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control " name="boletapagar" id="bp" readonly>
                                <input type="hidden" id="p" readonly>
                                <script>
                                    $('#st').load(function () {
                                        $.ajax({
                                            url: '/precioSubtramite',
                                            type: "get",
                                            data: {name: $('#st').val()},
                                            success: function (data) {
                                                $('#bp').val(data);
                                                var val = data * 100;
                                                $('#p').val(val);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" align="center">
                    <div class="col-md-5"></div>
                    <button id="buyButton" type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                                class="glyphicon glyphicon-check"></span> Pagar ahora
                    </button>
                </div>
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
                Culqi.settings({
                    title: 'Tesoreria UNT',
                    currency: 'PEN',
                    description: $('#st').val(),
                    amount: $('#p').val()
                });
            });
        </script>
        <script>
            $('#buyButton').on('click', function (e) {
                // Abre el formulario con las opciones de Culqi.settings
                Culqi.open();
                e.preventDefault();
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
                            detalle: $('#detalle').val()
                        },
                        success: function (data) {
                            if (data == 'ok')
                                alert('Se guardo pago');
                            else
                                alert('No se guardo pago');
                        }
                    });
                } else { // ¡Hubo algún problema!
                    // Mostramos JSON de objeto error en consola
                    console.log(Culqi.error);
                    alert(Culqi.error.mensaje);
                }
            }
        </script>
    </div>
@stop