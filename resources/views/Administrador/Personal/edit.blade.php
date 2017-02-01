@extends('Administrador.Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarPersonal" style="color: #509f0c" target="_top" autocomplete="off">Buscar Personal</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarPersonal" >Agregar Personal</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <form class="Horizontal">
            <legend>Agregar personal</legend>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Datos persona</div>
                <div class="panel-body">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="right">
                            <span class="col-sm-2 control-label"> Numero de Dni</span>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" name="dni" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <span class="col-sm-2">Nombres</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="nombre" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm">
                            <span class="col-sm-2">Apellidos</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="apellido" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Datos usuario</div>
                <div class="panel-body">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Codigo personal</span>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" name="codigoPersonal" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group-sm row col-sm-6">
                            <label class="col-sm-6" for="sel1">Tipo de Cuenta</label>
                            <div class="col-sm-6">
                                <select class="form-control " name="tipoDeCuenta">
                                    <option>Administrador</option>
                                    <option>Ventanilla</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Cuenta</span>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" name="cuenta" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <span class="col-sm-2">Contraseña</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="contraseña" type="text" autocomplete="off">
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