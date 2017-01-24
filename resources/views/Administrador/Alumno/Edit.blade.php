@extends('Administrador.Body')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Editar estudiante</div>
        <div class="panel-body">
            <form name="form" action="{{url('AlumnoRegistrado')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">Datos persona</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="right">
                                <span class="col-sm-2 control-label"> Numero de Dni</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="dni" type="text">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <span class="col-sm-2">Nombres</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="nombres" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm">
                                <span class="col-sm-2">Apellidos</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="apellidos" type="text">
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
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-3 control-label"> Codigo matricula</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="codMatricula" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Fecha matricula</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="fecha" type="text">
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
@stop