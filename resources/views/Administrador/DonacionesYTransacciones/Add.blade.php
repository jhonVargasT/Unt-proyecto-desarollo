@extends('Administrador/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones">Buscar Donaciones y transaferencias</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones" style="color: #509f0c" target="_top">Agregar Donaciones y
                            transferencias</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Agregar Donaciones y
            transferencias</h3>
    </div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
            <form name="form"
                  onsubmit="activarbotonform(event,['spansiaf','spanmonto','spanresolucion','spancuenta'],'enviar','mensaje')"
                  action="{{url('DonacionRegistrada')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <!-- Search input-->
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Clasificador</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> S.I.A.F </span>
                                    <input class="typeahead form-control" type="text"
                                           placeholder="Ingresa datos aqui .."
                                           name="nombreTramite" id="name" autocomplete="off"
                                           required onchange=" validarNombre('name','spansiaf')">
                                    <span style="color: red" class=" control-label" id="spansiaf"> </span>
                                    <script type="text/javascript">
                                        var path = "{{ route('autocompletet') }}";
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
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Tipo de recurso</span>
                                    <input class="form-control input-sm " name="TipoDeRecurso" type="text" id="tr"
                                           readonly>
                                    <script>
                                        $('#name').change(function () {
                                            $.ajax({
                                                url: '/tipoRecurso',
                                                type: "get",
                                                data: {name: $('#name').val()},
                                                success: function (data) {
                                                    $('#tr').val(data);
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Donaciones y Transacciones</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Fecha </span>
                                    <div class="col-sm-12 input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control"
                                               value="<?php date_default_timezone_set('America/Lima');
                                               $date = date('m/d/Y');
                                               echo $date ?>" name="fecha">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-2">
                                    <span class=" control-label">Monto</span>
                                    <div class="input-group col-sm-12">
                                        <div class="input-group-addon ">S/.</div>
                                        <input class="form-control " name="monto" type="text"
                                               autocomplete="off" required id="monto"
                                               onchange="decimales('monto','spanmonto')">
                                    </div>
                                    <span class=" control-label" style="color:red" id="spanmonto"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Numero de resolución</span>
                                    <input class="form-control input-sm" name="numResolucion" id="numResolucion"
                                           type="text"
                                           autocomplete="off" required
                                           onchange="validarNumeros('numResolucion','spanresolucion')">
                                    <span class=" control-label" style="color:red" id="spanresolucion"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Descripción</span>
                                    <input class="form-control input-sm" name="descripcion" id="descripcion"
                                           type="text"
                                           autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <div class="col-sm-3">
                                        <span class=" control-label"> Cuenta bancaria</span>
                                        <div class="input-group col-sm-12">
                                            <input class="form-control input-sm " name="cuenta" type="text" id="cuenta"
                                                   onchange="validarNumeros('cuenta','spancuenta')">
                                            <div class="input-group-addon"><a id="help_button"><i
                                                            class="glyphicon glyphicon-eye-open"></i></a>
                                            </div>
                                        </div>
                                        <span class=" control-label" style="color:red" id="spancuenta"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <script>
                    $(document).ready(function () {
                        $("#help_button").click(function () {
                            $("#help").slideToggle(1000, function () {
                            });
                        });
                    });
                </script>
                <style>
                    #help {
                        background-color: lightblue;
                        width: 300px;
                        height: auto;
                        display: none;
                        position: fixed;
                        top: 50%;
                        left: 80%;
                        margin: -150px 0 0 -150px;
                    }

                    table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }

                    tr:nth-child(even) {
                        /*background-color: #dddddd;*/
                    }
                </style>
                <div class="col-sm-12 row form-group" align="center">
                    <span id="mensaje" class="control-label" style="color: red"></span>
                </div>
                <div class=" row " align="center">

                    <a href="{{url('/Adm')}}" class=" btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit"
                            onmouseover="activarbotonform(null,['spansiaf','spanmonto','spanresolucion','spancuenta'],'enviar','mensaje')"
                            name="enviar" class="btn btn-sm  btn-success" id="enviar"><span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>

                </div>
            </form>
        </div>
    </div>
    <div id="help" align="center">
        <table>
            <tr>
                <th>Banco y cuenta</th>
            </tr>
            <tr>
                <td id="td"></td>
            </tr>
            <script>
                $.ajax({
                    url: '/banco',
                    type: "get",
                    data: '',
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            $('#td').append("" + data[i], "<br>");
                        }
                    }
                });
            </script>
        </table>
    </div>
@stop