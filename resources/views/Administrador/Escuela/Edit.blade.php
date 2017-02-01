@extends('Administrador.Body')
@section('escuela')
    <div id="collapseThree" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEscuela" style="color: #509f0c" target="_top">Buscar Escuelas</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEscuela" >Agregar Escuela</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <form class="Vertical">
            <legend>Agregar Escuela</legend>
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group " align="left">
                    <span class="col-sm-3 control-label"> Nombre Facultad</span>
                    <div class="input-group col-sm-6">
                        <input type="text" class="form-control" name="nombreFacultad" placeholder="Ingresa Nombre de facultad aqui .." autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Buscar</button>
                        </span>
                    </div>

                </div>
            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> Codigo escuela</span>
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="codigoEscuela" type="text" autocomplete="off">
                    </div>
                  
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Cuenta interna </span>
                    <div class="col-sm-4">
                        <input class="form-control" name="nroCuenta" type="text" autocomplete="off">
                    </div>
                </div>

            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">

                    <span class="col-sm-3 control-label"> Nombre escuela</span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm" name="nombreEscuela
                       " type="text" autocomplete="off">
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