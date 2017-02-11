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


    <div class="panel panel-primary ">
        <div class="panel-heading "> Realizar pago</div>
        <div class="panel-body">
            <form>
                <div class="col-sm-12">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="right">
                            <div class="col-sm-2 ">
                                <select class=" form-group-sm form-control" id="select">
                                    <option value="Dni"> Dni</option>
                                    <option value="Ruc">Ruc</option>
                                    <option value="Codigo de alumno">Codigo de alumno</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="buscar" name="text" type="text">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <span class="col-sm-2">Nombres</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="nombres" type="text" id="nombres" disabled>
                                <script>
                                    $('#buscar').change(function () {
                                        var value = $('#select option:selected').attr('value');
                                        if (value == 'Dni') {
                                            $.ajax({
                                                url: '/buscarNombresD',
                                                type: "get",
                                                data: {name: $('#buscar').val()},
                                                success: function (data) {
                                                    $('#nombres').val(data);
                                                }
                                            });
                                        }
                                        else {
                                            if (value == 'Ruc') {
                                                $.ajax({
                                                    url: '/buscarNombresR',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#nombres').val(data);
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
                                       disabled>
                                <script>
                                    $('#buscar').change(function () {
                                        var value = $('#select option:selected').attr('value');
                                        if (value == 'Dni') {
                                            $.ajax({
                                                url: '/buscarApellidosD',
                                                type: "get",
                                                data: {name: $('#buscar').val()},
                                                success: function (data) {
                                                    $('#apellidos').val(data);
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
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <span class="col-sm-2">Subtramite</span>
                            <div class="col-sm-4">
                                <input class="typeahead form-control" type="text" name="subtramite" id="st"
                                       onkeypress="return validarLetras(event)">
                                <script type="text/javascript">
                                    var path = "{{ route('autocompletes') }}";
                                    $('input.typeahead').typeahead({
                                        source: function (query, process) {
                                            return $.get(path, {query: query}, function (data) {
                                                return process(data);
                                            });
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
                                <input class="form-control input-sm" name="facultad" type="text" disabled id="facultad">
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
                            <span class="col-sm-2">Escuela</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="escuela" type="text" disabled id="escuela">
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
                            <span class="col-sm-2">Detalle </span>
                            <div class="col-sm-4">
                                <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"></textarea>
                            </div>
                        </div>
                        <span class="col-sm-2">Pago con:</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control " name="pagocon" id="pc">
                        </div>
                    </div>
                    <div class="col-sm-9 row form-group">
                        <span class="col-sm-3">Total Boleta:</span>
                        <div class="input-group col-sm-4">
                            <div class="input-group-addon ">S/.</div>
                            <input type="text" class="form-control " name="boletapagar" id="bp" disabled>
                            <script>
                                $('#st').change(function () {
                                    $.ajax({
                                        url: '/precioSubtramite',
                                        type: "get",
                                        data: {name: $('#st').val()},
                                        success: function (data) {
                                            $('#bp').val(data);
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-9 row form-group">
                        <span class="col-sm-3">Total Pagar:</span>
                        <div class="input-group col-sm-4">
                            <div class="input-group-addon ">S/.</div>
                            <input type="text" class="form-control " name="totalpagar" id="tp" disabled>
                        </div>
                    </div>
                    <div class="col-sm-9 row form-group">
                        <span class="col-sm-3">Vuelto:</span>
                        <div class="input-group col-sm-4">
                            <div class="input-group-addon ">S/.</div>
                            <input type="text" class="form-control " name="vuelto" id="v" disabled>
                        </div>
                        <script>
                            $('#pc').change(function () {
                                $.ajax({
                                    success: function () {
                                        var n1 = $('#pc').val();
                                        var n2 = $('#tp').val();
                                        var r = n1 - n2;
                                        $('#v').val(r);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-2"></div>
                    <a href="#" class=" col-md-2 btn btn-sm btn-info"><span
                                class="glyphicon glyphicon-print"></span>
                        Imprimir</a>
                    <div class="col-md-1"></div>
                    <button type="submit" name="agregar" class="col-md-2 btn btn-warning"><span
                                class="glyphicon glyphicon-plus"></span> Agregar
                    </button>
                    <div class="col-md-1"></div>
                    <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                                class="glyphicon glyphicon-usd"></span> Pagar
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
