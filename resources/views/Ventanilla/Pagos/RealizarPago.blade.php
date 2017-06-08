@extends('Ventanilla.Body')
@section('pago')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <i class="icomoon icon-coin"></i>
                        <a href="/ventRelizarPago" style="color: #509f0c" target="_top">Realizar pago</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="glyphicon glyphicon-list-alt"></i>
                        <a href="/ventReportPago">Mostrar pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.3.2.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel-heading "><h3>Realizar pago</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}} </div>
            @endif
            <form name="form" action="{{url('pagar')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                <div class="col-sm-12">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="right">
                            <div class="col-sm-2">
                                <select class=" form-group-sm form-control" id="select" name="select">
                                    <option value="Dni">Dni</option>
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
                                       @if(isset($nombre))value="{{$nombre}}" @endif readonly>
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
                                                        $.ajax({
                                                            url: '/buscarNombresDR',
                                                            type: "get",
                                                            data: {name: id},
                                                            success: function (data) {
                                                                $('#nombres').val(data[0]);
                                                                $('#apellidos').val(data[1]);
                                                                $('#escuela').val('');
                                                                $('#facultad').val('');
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
                                                                $("#selectP").empty();
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
                            </div>
                            <span class="col-sm-2">Escuela</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="escuela" type="text" readonly id="escuela"
                                       @if(isset($escuela)) value="{{$escuela}}" @endif >

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm">
                            <span class="col-sm-2">Facultad</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="facultad" type="text" readonly id="facultad"
                                       @if(isset($facultad)) value="{{$facultad}}" @endif >
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
                        </div>
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
                                            $('#bp').attr("readonly", true);
                                            $.ajax({
                                                url: '/precioSubtramite',
                                                type: "get",
                                                data: {name: $('#st').val()},
                                                success: function (data) {
                                                    $('#bp').val(data);
                                                    $('#aux').val(data);
                                                    if (data == 0 && $('#st').val()) {
                                                        $('#bp').attr("readonly", false);
                                                    }
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
                                                if (data == 0) {
                                                    $('#bp').attr("readonly", false);
                                                    $('#bp').val(data);
                                                    $('#aux').val(data);
                                                    var val = data * 100;
                                                    $('#p').val(val);
                                                }
                                                else {
                                                    $('#bp').attr("readonly", true);
                                                    $('#bp').val(data);
                                                    $('#aux').val(data);
                                                    var val = data * 100;
                                                    $('#p').val(val);
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        </script>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <span class="col-sm-2" id="nsub">Nombre de tasa:</span>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="subtramite" id="st" required readonly>
                        </div>
                        <div class="form-group-sm">
                            <span class="col-sm-2 required">Detalle:</span>
                            <div class="col-sm-4">
                                <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                                          id="detalle" required></textarea>
                            </div>
                            <style>
                                .required:after {
                                    content: " (*) ";
                                    color: #C00;
                                }
                            </style>
                        </div>
                        <!--<div class="form-group-sm">
                            <div class="col-sm-4">
                                <input type="checkbox" name="checkbox" value="1"> Deuda<br>
                            </div>
                        </div>-->
                    </div>
                    <div class="col-sm-12 row form-group">
                        <span class="col-sm-2 required">Produccion:</span>
                        <div class="col-sm-4">
                            <select class=" form-group-sm form-control" id="selectP" name="selectP" required disabled>
                                <option selected disabled>Seleccionar..</option>
                            </select>
                            <script>
                                $('#selectP').change(function () {
                                    var value = $('#selectP option:selected').attr('value');
                                    if (value != 'Seleccionar..') {
                                        $('#enviar').removeAttr('disabled');
                                    }
                                });
                            </script>
                            @if(isset($buscar))
                                <script>
                                    var value = $('#select option:selected').attr('value');
                                    if (value == 'Dni') {
                                        $.ajax({
                                            url: "/buscarNombresD",
                                            type: "get",
                                            data: {name: $('#buscar').val()},
                                            success: function (data) {
                                                if (data[4][0] === null) {
                                                    $("#selectP").empty();
                                                    document.getElementById("selectP").disabled = true;
                                                    document.getElementById("selectP").required = true;
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
                                        });
                                    }
                                    else {
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
                                                        $("#selectP").empty();
                                                        document.getElementById("selectP").disabled = true;
                                                        document.getElementById("selectP").required = true;
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
                                            });
                                        }
                                    }
                                </script>
                            @endif
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
                                </div>
                                <div class="col-sm-1">
                                    x
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control " name="multiplicador" id="mp">
                                    <input class="form-control " type="hidden" name="multiplicador" id="aux">
                                </div>
                                <script>
                                    $('#mp').change(function () {
                                        var n1 = $('#bp').val();
                                        var n2 = $('#mp').val();
                                        var n3 = $('#aux').val();
                                        var r = n1 * n2;
                                        if (!$('#mp').val()) {
                                            $('#bp').val(n3);
                                        }
                                        else {
                                            $('#bp').val(r);

                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm">
                            @if(isset($total))
                                <span class="col-sm-2">Costo total a pagar:</span>
                                <div class="col-sm-2">
                                    <div class="col-sm-1">
                                        S/.
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="total" id="tp" value="{{$total}}"
                                               readonly>
                                    </div>
                                </div>
                            @else
                                <span class="col-sm-2">Costo total a pagar:</span>
                                <div class="col-sm-2">
                                    <div class="col-sm-1">
                                        S/.
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="total" id="tp"
                                               readonly value="0">
                                    </div>
                                </div>
                            @endif
                            <span class="col-sm-1">Pago con:</span>
                            <div class="col-sm-1">
                                <input type="text" class="form-control " name="pagocon" id="pc">
                            </div>
                            <span class="col-sm-1">Vuelto :</span>
                            <div class="col-sm-2">
                                <div class="col-sm-1">
                                    S/.
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control " name="vuelto" id="v" readonly
                                           value="0.00">
                                </div>
                            </div>
                            <script>
                                $('#pc').change(function () {
                                    var n1 = $('#pc').val();
                                    var n2 = $('#tp').val();
                                    var r = n1 - n2;
                                    r = r.toFixed(2);
                                    $('#v').val(r);
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-5"></div>
                    <div class="col-md-2" align="center">
                        <button type="submit" name="enviar" id="enviar" class="col-md-12 btn btn-success" disabled><span
                                    class="glyphicon glyphicon-check"></span> Guardar
                        </button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </form>
        </div>
    </div>
@stop
