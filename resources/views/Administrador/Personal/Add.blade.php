@extends('Administrador/Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarPersonal">Buscar Personal</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarPersonal" style="color: #509f0c" target="_top">Agregar Personal</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Agregar personal</div>
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('PersonalRegistrado')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">Datos persona</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Numero de Dni</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="dni" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)" placeholder="ejmp:75879887" required>
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <span class="col-sm-2">Nombres</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="nombres" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)" placeholder="ejmp:Juan Fernando"required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm">
                                <span class="col-sm-2">Apellidos</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="apellidos" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)" placeholder="ejmp: Benites Alaya" required>
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
                                <span class="col-sm-2 control-label">Tipo de cuenta</span>
                                <div class="col-sm-3">
                                    <select class="form-control " name="tipocuenta">
                                        <option>Administrador</option>
                                        <option>Ventanilla</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <span class="col-sm-2">Codigo personal</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="codigoPersonal" type="text" onkeypress="return validarNum(event)" placeholder="ejmp: 00025487" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Cuenta</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="cuenta" type="text">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <span class="col-sm-2">Contraseña</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="contraseña" type="password">
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