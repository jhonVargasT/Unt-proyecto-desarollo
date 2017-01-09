@extends('Administrador\LayoutAdm')
@section('header.title')
    Título que se parará al padre
@stop
@section('content')
    <fieldset>
        <form class="form-Vertical">
            <!-- Form Name -->
            <legend>Agregar Donaciones y Transacciones</legend>
            <!-- Search input-->
            <div class="col-sm-12 row form-group">
                <div class="form-group has-success has-feedback">
                    <label class="control-label" for="inputSuccess4">Input with success</label>
                    <input type="text" class="form-control" id="inputSuccess4" aria-describedby="inputSuccess4Status">
                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                    <span id="inputSuccess4Status" class="sr-only">(success)</span>
                </div>
                <div class=" form-group-sm">
                    <label class="col-sm-2 control-label">Fecha :</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm ">
                    <label class="col-sm-3 control-label">Tipo de recurso :</label>
                    <div class="col-sm-4">
                        <input class="form-control search-query" type="text">
                    </div>
                </div>
                <div class=" form-group-sm">
                    <label class="col-sm-2 control-label">Monto :</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm ">
                    <label class="col-sm-3 control-label">N° resolucion:</label>
                    <div class="col-sm-4">
                        <input class="form-control search-query" type="text">
                    </div>
                </div>

            </div>
            <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
            <a href="#" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
        </form>
    </fieldset>


@stop