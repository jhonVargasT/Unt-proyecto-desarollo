@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <form name="form" action="{{url('ClienteRegistrado')}}" role="form" method="POST" class="Horizontal">
            {{csrf_field()}}
            <legend>Agregar cliente</legend>
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
                            <div class="col-sm-1">
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
                <div class="panel-heading">Datos cliente</div>
                <div class="panel-body">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Ruc:</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="ruc" type="text">
                            </div>
                        </div>
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Razon social</span>
                            <textarea class="col-sm-4" name="razonSocial">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar</a>
                <div class="col-md-2"></div>
                <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Guardar</button>
                <div class="col-md-3"></div>
            </div>

        </form>
    </fieldset>
@stop