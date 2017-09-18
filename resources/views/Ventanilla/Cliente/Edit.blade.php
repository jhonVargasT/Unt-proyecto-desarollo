@extends('Ventanilla.Body')
@section('cliente')
    <div id="collapseClie" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/ventBuscarCliente" style="color: #509f0c" target="_top">Buscar Clientes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/ventRegistrarCliente">Agregar Clientes</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <div class="panel-heading"><h3>Editar Cliente</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if($cliente)
                    @foreach($cliente as $c)
                        <form name="form" action="{{ url('ClienteEditado/' .$c->codPersona ) }}" role="form"
                              method="get"
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
                                                       placeholder="Ejm:72978754" required value="{{$c->dni}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm" align="right">
                                            <span class="col-sm-2">Nombres</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="nombres" type="text"
                                                       autocomplete="off" onkeypress="return validarLetras(event)"
                                                       placeholder="Ejm: Jose Fernando" required
                                                       value="{{$c->nombres}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 row form-group">
                                        <div class="form-group-sm">
                                            <span class="col-sm-2">Apellidos</span>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" name="apellidos" type="text"
                                                       autocomplete="off" onkeypress="return validarLetras(event)"
                                                       placeholder="Terenas Lory" value="{{$c->apellidos}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm" align="right">
                                            <span class="col-sm-2">Correo</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="correo" type="email"
                                                       autocomplete="off"
                                                       placeholder="Ejem: unt@gmail.com" required
                                                       value="{{$c->correo}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Datos cliente</div>
                                <div class="panel-body">
                                    <div class="col-sm-12 row form-group">
                                        <div class="form-group-sm " align="left">
                                            <span class="col-sm-2 control-label"> Ruc:</span>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" name="ruc" type="text"
                                                       autocomplete="off" onkeypress="return validarNum(event)"
                                                       placeholder="Ejm: 0729787548" value="{{$c->ruc}}">
                                            </div>
                                        </div>
                                        <div class="form-group-sm " align="right">
                                            <span class="col-sm-2 control-label"> Razon social</span>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" name="razonSocial" placeholder="Ejm:
                                                    PRICEWATERHOUSE  " onkeypress="return validarLetras(event)"
                                                       value="{{$c->razonSocial}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="col-md-3"></div>
                                <a href="{{url('/Vent')}}" class=" col-md-2 btn btn-sm btn-danger"><span
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
                    @endforeach
                @endif
            </div>
        </div>
    </fieldset>
@stop