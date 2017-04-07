@extends('Ventanilla.Body')
@section('cliente')
    <div id="collapseClie" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/ventBuscarCliente">Buscar Clientes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/ventRegistrarCliente" style="color: #509f0c" target="_top">Agregar Clientes</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if(session()->has('true'))
        <div class="alert alert-success" role="alert">{{session('true')}} </div>
    @endif
    @if(session()->has('false'))
        <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
    @endif
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Agregar cliente</div>
        <div class="panel-body">
            <form name="form" action="{{url('ClienteRegistrado')}}" role="form" method="POST" class="Horizontal">
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
                                <div class="col-sm-1">
                                </div>
                            </div>
                            <div class="form-group-sm" >
                                <span class="col-sm-1">Nombres</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="nombres" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm">
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
                    <div class="panel-heading">Datos cliente</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Ruc:</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="ruc" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)">
                                </div>
                            </div>
                            <div class="form-group-sm " align="right">
                                <span class="col-sm-2 control-label"> Razon social</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="razonSocial" onkeypress="return validarLetras(event)">
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