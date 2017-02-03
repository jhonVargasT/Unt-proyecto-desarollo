@extends('Administrador/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones" style="color: #509f0c" target="_top" >Buscar Donaciones y transacciones</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones" >Agregar Donaciones y transacciones</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <form class="form-Vertical">
            <!-- Form Name -->
            <legend>Editar Donaciones y Transacciones</legend>
            <!-- Search input-->
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-2 control-label"  > Clasificador Siaf </span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm" name="clasificadorSiaf" type="text" >
                    </div>
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Fecha </span>
                    <div class="col-sm-3">
                        <input class="form-control" name="fechaDeIngreso" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group" >
                <div class="form-group-sm " align="left">
                    <span class="col-sm-2 control-label">Tipo de recurso </span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm "name="TipoDeRecurso" type="text">
                    </div>
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Monto </span>
                    <div class="col-sm-3">
                        <input class="form-control" name="monto" type="text">
                    </div>
                </div>
            </div>
            <br>
            <div class="col-sm-12 row form-group" align="left">
                <div >
                    <span class=" col-sm-2 control-label">Descripcion </span>
                    <div class="col-sm-5">
                        <textarea class="form-control " rows="5" name="descripcion" >
                            </textarea>
                    </div>
                </div>
                <div class="form-group-sm ">
                    <span class="col-sm-2 control-label">Numero de resolucion </span>
                    <div class="col-sm-3">
                        <input class="form-control " name="numeroResolucion" type="text">
                    </div>
                </div>

            </div>
            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                <div class="col-md-2"></div>
                <a href="#" class=" col-md-2 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                <div class="col-md-3"> </div>
            </div>

        </form>
    </fieldset>


@stop