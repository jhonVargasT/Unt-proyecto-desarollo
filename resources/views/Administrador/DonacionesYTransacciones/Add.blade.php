@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <form name="form" action="{{url('DonacionRegistrada')}}" role="form" method="POST" class="Horizontal">
        {{csrf_field()}}
            <!-- Form Name -->
            <legend>Agregar Donaciones y Transacciones</legend>
            <!-- Search input-->
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