@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <form class="Vertical">
            <legend>Editar facultad</legend>
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-2 control-label"> Codigo Facultad</span>
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="codigoFacultad" type="text">
                    </div>
                    <div class="col-sm-1">

                    </div>
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label"> </span>
                    <span class="col-sm-2 control-label">Cuenta interna </span>
                    <div class="col-sm-3">
                        <input class="form-control" name="nroCuenta" type="text">
                    </div>
                </div>

            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">

                    <span class="col-sm-2 control-label"> Nombre facultad</span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm" name="nombreFacultad" type="text">
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