@extends('Administrador.LayoutAdm')
@section('body')
    <div class="panel-heading"><h3>Editar Donaciones y
            transferencias</h3>
    </div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
            @if($donacion)
                @foreach($donacion as $d)
                    <form name="form" action="{{ url('DonacionEditada/' .$d->codDonacion )}}" role="form"
                          method="get" class="Horizontal">
                    {{csrf_field()}}
                    <!-- Search input-->
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Clasificador</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> S.I.A.F </span>
                                            <input class="typeahead form-control" type="text"
                                                   placeholder="Ingresa datos aqui .." value="{{$d->tnombre}}"
                                                   name="nombreTramite" id="name" autocomplete="off"
                                                   required onchange=" validarNombre('name','spansiaf')">
                                            <span style="color: red" class=" control-label" id="spansiaf"></span>
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
                                            <input class="form-control input-sm " name="TipoDeRecurso" type="text"
                                                   id="tr" value="{{$d->tipoRecurso}}"
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
                            <div class="panel-heading">Datos Donaciones y transcacciones</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Fecha </span>
                                            <div class="col-sm-12 input-group date" data-provide="datepicker">
                                                <input type="text" class="form-control"
                                                       value="{{$d->fechaIngreso}}" name="fecha">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class="glyphicon glyphicon-usd"> Monto</span>
                                            <input type="text" class="form-control " name="monto" value="{{$d->monto}}"
                                                   autocomplete="off" placeholder="ejmp: 2.50" id="monto"
                                                   required onchange=" validarNumeros('monto','spanmonto')">
                                            <span style="color: red" class=" control-label" id="spanmonto"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Numero de resolucion</span>
                                            <input class="form-control input-sm" name="numResolucion" id="numResolucion"
                                                   type="text" value="{{$d->numResolucion}}"
                                                   autocomplete="off" required
                                                   onchange="validarNumeros('numResolucion','spanresolucion')">
                                            <span class=" control-label" style="color:red" id="spanresolucion"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Descripcion</span>
                                            <input class="form-control input-sm" name="descripcion" id="descripcion"
                                                   type="text" {{$d->descripcion}}
                                                   autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 row form-group">
                                        <div class="form-group-sm " align="left">
                                            <div class="col-sm-3">
                                                <span class=" control-label"> Cuenta bancaria </span>
                                                <input class="form-control input-sm " name="cuenta" type="text"
                                                       id="cuenta" value="{{$d->bcuenta}}"
                                                       onchange="validarNumeros('cuenta','spancuenta')">
                                                <div class="input-group-addon"><a id="help_button"><i
                                                                class="glyphicon glyphicon-eye-open"></i></a>
                                                </div>
                                                <span class=" control-label" style="color:red" id="spancuenta"></span>
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
                                background-color: #dddddd;
                            }
                        </style>
                        <div class="col-sm-12 row form-group" align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                        <div class=" row " align="center">

                            <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Cancelar</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" id="enviar" name="enviar" class="col-md-2 btn  btn-success"><span
                                        class="glyphicon glyphicon-ok"></span> Guardar
                            </button>

                        </div>
                    </form>
                @endforeach
            @endif
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