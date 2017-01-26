@extends('Administrador.Body')
@section('content')
    <fieldset>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <form name="form" action="{{url('EscuelaRegistrada')}}" role="form" method="POST" class="Vertical">
            {{csrf_field()}}
            <legend>Agregar Escuela</legend>
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group " align="left">
                    <span class="col-sm-3 control-label"> Nombre Facultad</span>
                    <div class="input-group col-sm-6">
                        <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .." name="nombreFacultad">
                        <script type="text/javascript">
                            var path = "{{ route('autocompletee') }}";
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
                    <span class="col-sm-3 control-label"> Codigo escuela</span>
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="codEscuela" type="text">
                    </div>

                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Cuenta interna </span>
                    <div class="col-sm-4">
                        <input class="form-control" name="nroCuenta" type="text">
                    </div>
                </div>

            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">

                    <span class="col-sm-3 control-label"> Nombre escuela</span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm" name="nombre" type="text">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar</a>
                <div class="col-md-2"></div>
                <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                            class="glyphicon glyphicon-ok"></span> Guardar
                </button>
                <div class="col-md-3"></div>
            </div>
        </form>
    </fieldset>
@stop