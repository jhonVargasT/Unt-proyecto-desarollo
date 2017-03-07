@extends('Ventanilla.Body')
@section('estudiante')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/ventBuscarEstudiante">Buscar Estudiantes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/ventRegistrarEstudiante" style="color: #509f0c" target="_top">Agregar Estudiante</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop

@section('content')
    @if(  Session::has('tipoCuentaV') )
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

        <div class="panel panel-primary">
            <div class="panel-heading"> Agregar Estudiante</div>
            <div class="panel-body">
                <form name="form" action="{{url('AlumnoRegistrado')}}" role="form" method="POST" class="Horizontal">
                    {{csrf_field()}}
                    <div class="panel panel-default">
                        <div class="panel-heading">Datos persona</div>
                        <div class="panel-body">
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label"> Numero de Dni</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="dni" type="text"
                                               autocomplete="off" onkeypress="return validarNum(event)">
                                    </div>
                                </div>
                                <div class="form-group-sm" align="right">
                                    <span class="col-sm-2">Nombres</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="nombres" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm" align="left">
                                    <span class="col-sm-2">Apellidos</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="apellidos" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Datos Alumno</div>
                        <div class="panel-body">
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label"> Codigo alumno</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="codAlumno" type="text">
                                    </div>
                                </div>
                                <div class="form-group-sm " align="right">
                                    <span class="col-sm-2 control-label"> Codigo matricula</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="codMatricula" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label"> Fecha matricula</span>
                                    <div class="col-sm-3">
                                        <div class="col-sm-12 input-group date" data-provide="datepicker">
                                            <input type="text" name="fecha" class="form-control"
                                                   value="<?php date_default_timezone_set('America/Lima');
                                                   $date = date('m/d/Y');
                                                   echo $date ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group-sm " align="right">
                                    <span class="col-sm-2 control-label">Escuela</span>
                                    <div class="col-sm-3">
                                        <input class="typeahead form-control" type="text"
                                               placeholder="Ingresa datos aqui .." name="nombreEscuela" id="ne"
                                               onkeypress="return validarLetras(event)">
                                        <script type="text/javascript">
                                            var path = "{{ route('escuela') }}";
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
                                    <span class="col-sm-2 control-label">Facultad</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name=" " type="text" id="f" disabled>
                                        <script>
                                            $('#ne').change(function () {
                                                $.ajax({
                                                    url: '/facultad',
                                                    type: "get",
                                                    data: {name: $('#ne').val()},
                                                    success: function (data) {
                                                        $('#f').val(data);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </form>
            </div>
        </div>
    @else
        @include("index")
    @endif
@stop
