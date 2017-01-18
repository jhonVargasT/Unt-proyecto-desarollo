@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <form class="Horizontal">
            <legend>Agregar Alumno</legend>
            <br>
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
                                <input class="form-control input-sm" name="nombre" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm">
                            <span class="col-sm-2">Apellidos</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="apellido" type="text">
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
                                <input class="form-control input-sm" name="codigoAlumno" type="text">
                            </div>
                        </div>
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-3 control-label"> Codigo matricula</span>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" name="codigoMatricula" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Fecha matricula</span>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" name="fechaDeMatricula" type="text">
                            </div>
                        </div>

                    </div>

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
        </form>
    </fieldset>
@stop