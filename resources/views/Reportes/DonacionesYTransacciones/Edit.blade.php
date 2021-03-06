@extends('Administrador/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y
                            transacciones</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones">Agregar Donaciones y transacciones</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
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
                        <div class="row ">
                            <div class="form-group-sm col-sm-2">
                                <span class="control-label"> Nombre clasificador</span>
                                <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                       name="nombreTramite" id="name" autocomplete="off"
                                       onkeypress="return validarLetras(event)" required value="{{$d->tnombre}}">
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
                            <div class="col-sm-2">
                                <span class=" control-label">Tipo de recurso </span>
                                <input class="form-control input-sm " name="TipoDeRecurso" type="text" id="tr" required
                                       disabled value="{{$d->tipoRecurso}}">
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
                            <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                <span class="control-label"> Fecha</span>
                                <div class="col-sm-12 input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control"
                                           value="{{$d->fechaIngreso}}" name="fecha">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-2  form-group-sm">
                                <span class="control-label">Monto</span>
                                <div class="input-group ">
                                    <div class="input-group-addon ">S/.</div>
                                    <input type="text" class="form-control " name="monto"
                                           autocomplete="off" onkeypress="return validarDouble(event)"
                                           placeholder="ejmp: 2.50"
                                           required value="{{$d->monto}}">
                                </div>
                            </div>
                            <div class=" col-sm-2 form-group-sm">
                                <span class="control-label">Numero de resolucion</span>
                                <input class="form-control " name="numResolucion" type="text"
                                       autocomplete="off" onkeypress="return validarNum(event)"
                                       placeholder="jmp: 124578" required value="{{$d->numResolucion}}">
                            </div>
                        </div>
                        <div class="row ">
                            <div class=" col-sm-4">
                                <span class="control-label">Descripcion </span>
                                <textarea class="form-control" rows="2" name="descripcion"
                                          placeholder="Agregue una breve descripcion">{{$d->descripcion}}</textarea>

                            </div>
                            <div class="col-sm-2 form-group-sm ">
                                <span class="control-label">Cuenta bancaria</span>
                                <div class="input-group">
                                    <input class="form-control input-sm " name="cuenta" type="text" id="cuenta"
                                           onkeypress="return validarNum(event)" required value="{{$d->bcuenta}}">
                                    <div class="input-group-addon"><a id="help_button"><i
                                                    class="glyphicon glyphicon-eye-open"></i></a>
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

                        <div class="col-sm-12 row form-group">
                            <div class="col-md-3"></div>
                            <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Cancelar</a>
                            <div class="col-md-2"></div>
                            <button type="submit" name="enviar" class="col-md-2 btn  btn-success"><span
                                        class="glyphicon glyphicon-ok"></span> Guardar
                            </button>
                            <div class="col-md-3"></div>
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