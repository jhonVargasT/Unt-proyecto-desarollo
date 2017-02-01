@extends('Administrador.Body')
@section('subtramite')
    <div id="collapseSix" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSubtramite" style="color: #509f0c" target="_top">Buscar SubTramites</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSubtramite" >Agregar SubTramite</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <div class="panel-heading">Editar subtramite</div>
        <div class="panel-body">
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> Nombre Tramite</span>
                    <div class="input-group col-sm-6">
                        <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                               name="nombreTramite" autocomplete="off">
                        <script type="text/javascript">
                            var path = "{{ route('autocomplete') }}";
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
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> Cuenta contable</span>
                    <div class="col-sm-3">
                        <input class="form-control input-sm" name="cuentaContable" type="text" autocomplete="off">
                    </div>
                    <div class="col-sm-1">

                    </div>
                </div>
                <div class="form-group-sm">
                    <span class="col-sm-2">Precio</span>
                    <div class="input-group col-sm-2">
                        <div class="input-group-addon ">S/.</div>
                        <input type="text" class="form-control " name="precio" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> Nombre Subtramite</span>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" name="nombreSubTramite" type="text" autocomplete="off">
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar</a>
                <div class="col-md-2"></div>
                <a href="#" class=" col-md-2 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
@stop