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
    <div class="panel panel-primary">
        <div class="panel-heading">Agregar Donaciones y
            transferencias</div>
        <div class="panel-body">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
            <form name="form" action="{{url('DonacionRegistrada')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                <!-- Search input-->
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label"> Clasificador Siaf </span>
                        <div class="col-sm-5">
                            <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                   name="nombreTramite" id="name" autocomplete="off"
                                   onkeypress="return validarLetras(event)">
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
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-2 control-label">Fecha </span>
                        <div class="col-sm-3">
                            <input class="form-control" name="fechaIngreso" type="text"
                                   autocomplete="off" onkeypress="return validarNumS(event)">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label">Tipo de recurso </span>
                        <div class="col-sm-5 ">
                            <input class="form-control input-sm " name="TipoDeRecurso" type="text" id="tr" disabled>
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
                        <div class=" form-group-sm" align="left">
                            <span class="col-sm-2 control-label">Monto </span>
                            <div class="col-sm-3">
                                <input class="form-control" name="monto" type="text"
                                       autocomplete="off" onkeypress="return validarNumP(event)">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class=" col-sm-2 control-label">Descripcion </span>
                            <div class="col-sm-5">
                        <textarea class="form-control " rows="5" name="descripcion">
                            </textarea>
                            </div>
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label">Numero de resolucion </span>
                                <div class="col-sm-3">
                                    <input class="form-control " name="numResolucion" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 row form-group">
                        <div class="col-md-3"></div>
                        <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span
                                    class="glyphicon glyphicon-ban-circle"></span>
                            Cancelar</a>
                        <div class="col-md-2"></div>
                        <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop