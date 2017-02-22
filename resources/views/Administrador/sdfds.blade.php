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
    <div class="panel panel-primary">
        <div class="panel-heading">Agregar subtramite</div>
        <div class="panel-body">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
            <form class="Vertical" action="{{url('SubtramiteRegistrado')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="col-sm-8 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> Nombre Tramite</span>
                        <div class="input-group col-sm-6">
                            <input class="typeahead form-control" type="text" placeholder="Ingresa nombre de tramite .."
                                   name="nombreTramite" autocomplete="off" onkeypress="return validarLetras(event)"  required>
                            <script type="text/javascript">
                                var path = "{{ route('autocomplete')}}";
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
                <div class="col-sm-8 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> Cuenta contable</span>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" name="cuentaContable" type="text"
                                   autocomplete="off" onkeypress="return validarNum(event)" placeholder="Ejmp: 45844874" required>
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                    <div class="form-group-sm">
                        <span class="col-sm-2">Precio</span>
                        <div class="input-group col-sm-2">
                            <div class="input-group-addon ">S/.</div>
                            <input type="text" class="form-control " name="precio"
                                   autocomplete="off" onkeypress="return validarDouble(event)" placeholder="ejmp: 2.50" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> Nombre Subtramite</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="nombreSubTramite" type="text"
                                   autocomplete="off" onkeypress="return validarLetras(event)" required>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="{{url('/Layout')}}" class=" col-md-2 btn btn-sm btn-danger"><span
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