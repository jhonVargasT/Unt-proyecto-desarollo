@extends('Administrador.Body')
@section('sede')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSede">Buscar Sedes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSede" style="color: #509f0c" target="_top">Agregar Sede</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Agregar sede</div>
        <div class="panel-body">
            <form name="form" action="{{url('SedeRegistrada')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label"> Sede </span>
                        <div class="col-sm-4">
                            <div class="input-group col-sm-12">
                                <input class="form-control input-sm" name="nombreSede" type="text" autocomplete="off"
                                       placeholder="ejmp: Trujillo"
                                       onkeypress="return validarLetras(event)" required>
                            </div>
                        </div>
                        <span class="col-sm-2 control-label"> Codigo Sede</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="codigoSede" type="text" autocomplete="off"
                                   placeholder="ejmp: 0002548"
                                   onkeypress="return validarNum(event)" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label"> Direccion</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="direccion" type="text" autocomplete="off"
                                   placeholder="ejmp: Juan Pablo II"
                                   required>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <div class="col-sm-5">
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
                        <button type="submit" name="enviar" class="col-md-2 btn btn-sm btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
@stop