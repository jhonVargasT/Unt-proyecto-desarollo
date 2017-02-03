@extends('Administrador/Body')
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
        <div class="panel panel-primary">
            <div class="panel-heading"> Editar Personal</div>
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                @if($personal)
                    @foreach($personal as $p)
                        <form name="form" action="{{ url('PersonalEditado/' .$p->codPersona ) }}" role="form" method="Get"
                              class="Vertical">
                            {{csrf_field()}}
                            <div class="panel panel-default">
                                <div class="panel-heading">Datos persona</div>
                                <div class="panel-body">
                                    <div class="col-sm-12 row form-group">
                                        <div class="form-group-sm " align="right">
                                            <span class="col-sm-2 control-label"> Numero de Dni</span>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" name="dni" type="text"
                                                       autocomplete="off" onkeypress="return validarNum(event)"
                                                       value="{{$p->dni}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm">
                                            <span class="col-sm-2">Nombres</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="nombres" type="text"
                                                       autocomplete="off" onkeypress="return validarLetras(event)"
                                                       value="{{$p->nombres}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 row form-group">
                                        <div class="form-group-sm">
                                            <span class="col-sm-2">Apellidos</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="apellidos" type="text"
                                                       autocomplete="off" onkeypress="return validarLetras(event)"
                                                       value="{{$p->apellidos}}">
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
                                                <input class="form-control input-sm" name="codigoPersonal" type="text"
                                                       autocomplete="off" value="{{$p->codPersonal}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm row col-sm-6">
                                            <span class="col-sm-2 control-label">Tipo de Cuenta</span>
                                            <div class="col-sm-6">
                                                <select class="form-control " name="tipoDeCuenta">
                                                    <option>{{$p->tipoCuenta}}</option>
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
                                                <input class="form-control input-sm" name="cuenta" type="text"
                                                       autocomplete="off" value="{{$p->cuenta}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm">
                                            <span class="col-sm-2">Contraseña</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="contraseña" type="text"
                                                       autocomplete="off" value="{{$p->password}}">
                                            </div>
                                        </div>
                                    </div>
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
                                    <button href="" type="submit" name="enviar"
                                            class="col-md-2 btn btn-sm btn-success"><span
                                                class="glyphicon glyphicon-ok"></span> Guardar
                                    </button>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </form>
            </div>
            @endforeach
            @endif
        </div>
    </fieldset>
@stop