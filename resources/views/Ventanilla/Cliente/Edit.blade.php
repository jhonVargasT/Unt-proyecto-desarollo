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
    <fieldset>
        <form class="Horizontal">
            <legend>Agregar cliente</legend>
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
                            <div class="col-sm-1">
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
                <div class="panel-heading">Datos cliente</div>
                <div class="panel-body">
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm " align="left">
                            <span class="col-sm-2 control-label"> Ruc:</span>
                            <div class="col-sm-4">
                                <input class="form-control input-sm" name="ruc" type="text" autocomplete="off">
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
                <a href="#" class=" col-md-2 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                <div class="col-md-3"></div>
            </div>
        </form>
    </fieldset>
@stop