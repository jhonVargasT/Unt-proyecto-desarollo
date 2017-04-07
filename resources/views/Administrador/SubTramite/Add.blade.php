@extends('Administrador/Body')
@section('subtramite')
    <div id="collapseSix" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSubtramite">Buscar SubTramites</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSubtramite" style="color: #509f0c" target="_top">Agregar SubTramite</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <div class="panel panel-primary">
        <div class="panel panel-heading"> Agregar Subtramite</div>
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('SubtramiteRegistrado')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">Datos Tramite</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label">Nombre Tramite</span>
                                <div class="col-sm-3">
                                    <input class="typeahead form-control input-sm" type="text"
                                           placeholder="ejmp : Carnet"
                                           name="nombreTramite"
                                           autocomplete="off" required>
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
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Datos Subtramite</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label">Cuenta contable</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="cuentaContable" type="text"
                                           autocomplete="off" onkeypress="return validarCodigoSiaf(event)"
                                           placeholder="Ejm: 0729787548">
                                </div>
                            </div>
                            <div class="form-group-sm" align="right">
                                <span class="col-sm-2">Precio</span>
                                <div class="input-group col-sm-2">
                                    <div class="input-group-addon ">S/.</div>
                                    <input type="text" class="form-control " name="precio"
                                           autocomplete="off" onkeypress="return validarDouble(event)"
                                           placeholder="ejmp: 2.50" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 row form-group">
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Nombre Subtramite</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="nombreSubTramite" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)" required
                                           placeholder="ejmp: Biblioteca">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Regresar
                    </a>
                    <div class="col-md-2">
                    </div>
                    <div>
                        <button type="submit" name="enviar" class="col-md-2 btn btn-sm btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
@stop