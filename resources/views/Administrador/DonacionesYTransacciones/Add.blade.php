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
            <form name="form" action="{{url('DonacionRegistrada')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <!-- Search input-->
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label"> Nombre clasificador</span>
                        <div class="col-sm-4">
                            <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                   name="nombreTramite" id="name" autocomplete="off"
                                   onkeypress="return validarLetras(event)" required>
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
                    <div class=" form-group-sm" align="right">
                        <span class="col-sm-2 control-label">Fecha </span>
                        <div class="col-sm-3">
                            <div class="col-sm-12 input-group date" data-provide="datepicker">
                                <input type="text" name="fecha" class="form-control" placeholder="obligatorio"
                                       value="<?php date_default_timezone_set('America/Lima');
                                       $date = date('m/d/Y');
                                       echo $date ?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label">Tipo de recurso </span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " name="TipoDeRecurso" type="text" id="tr" required
                                   disabled>
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
                        <div class="form-group-sm" align="right">
                            <span class="col-sm-2">Monto</span>
                            <div class="input-group col-sm-2">
                                <div class="input-group-addon ">S/.</div>
                                <input type="text" class="form-control " name="monto"
                                       autocomplete="off" onkeypress="return validarDouble(event)"
                                       placeholder="ejmp: 2.50"
                                       required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class=" col-sm-2 control-label">Descripcion </span>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="2" name="descripcion"
                                          placeholder="Agregue una breve descripcion"></textarea>
                            </div>
                            <div class="col-md-1"></div>
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label">Numero de resolucion</span>
                                <div class="col-sm-2">
                                    <input class="form-control " name="numResolucion" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)"
                                           placeholder="jmp: 124578" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label">Cuenta bancaria</span>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " name="cuentab" type="text" id="cuenta"
                                   onkeypress="return validarNum(event)" required>
                            <input id="help_button" type="button" value="Mostrar"/>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#help_button").click(function () {
                            $("#help").slideToggle(1000, function () {
                                if ($("#help_button").val() == "Mostrar") {
                                    $("#help_button").val("Cerrar");
                                }
                                else {
                                    $("#help_button").val("Mostrar");
                                }
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
                        top: 60%;
                        left: 57.5%;
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
                        background-color: #dddddd;
                    }
                </style>

                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar</a>
                    <div class="col-md-2"></div>
                    <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>
                    <div class="col-md-3"></div>
                </div>

            </form>
            <div id="help" align="center">
                <table>
                    <tr>
                        <th>Banco y cuenta</th>
                    </tr>
                    <tr1>
                        <td id="td"></td>
                    </tr1>
                    <script>
                        if ($("#help_button").val() == "Mostrar") {
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
                        }
                        else {
                            if ($("#help_button").val() == "Cerrar") {
                                $('#td').val('');
                            }
                        }
                    </script>
                </table>
            </div>
        </div>
    </div>
@stop