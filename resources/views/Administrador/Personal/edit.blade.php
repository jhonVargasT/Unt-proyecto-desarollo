@extends('Administrador/Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarPersonal" style="color: #509f0c" target="_top">Buscar Personal</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarPersonal">Agregar Personal</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Editar personal</h3></div>
    <div  style="background-color: #FFFFFF" >
        @if(session()->has('true'))
            <div class="alert alert-success" role="alert">{{session('true')}} </div>
        @endif
        @if(session()->has('false'))
            <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
        @endif

        <div class="panel-body">
            @if($personal)
                @foreach($personal as $per)
                    <form name="form" action="{{ url('PersonalEditado/' .$per->codPersona ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos persona</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <span class="col-sm-2 control-label"> Numero de Dni</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="dni" type="text"
                                                   autocomplete="off" onkeypress="return validarNum(event)"
                                                   value="{{$per->dni}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm"align="right">
                                        <span class="col-sm-2">Nombres</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="nombres" type="text"
                                                   autocomplete="off" onkeypress="return validarLetras(event)"
                                                   value="{{$per->nombres}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm">
                                        <span class="col-sm-2">Apellidos</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="apellidos" type="text"
                                                   autocomplete="off" onkeypress="return validarLetras(event)"
                                                   value="{{$per->apellidos}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm" align="right">
                                        <span class="col-sm-2">Correo</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="correo" type="email"
                                                   autocomplete="off"
                                                   placeholder="Ejem: unt@gmail.com" required value="{{$per->correo}}">
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
                                                <option>Reportes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group-sm" align="right">
                                        <span class="col-sm-2">Codigo personal</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="codigoPersonal" type="text"
                                                   placeholder="ejmp: 00025487"
                                                   required value="{{$per->codPersonal}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <span class="col-sm-2 control-label"> Cuenta</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="cuentaAgregar" type="text"
                                                   value="{{$per->cuenta}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm" align="right">
                                        <span class="col-sm-2">Contraseña</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="contraseñaAgregar" type="password"
                                                   value="{{$per->password}}">
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
                @endforeach
            @endif
        </div>
    </div>
@stop