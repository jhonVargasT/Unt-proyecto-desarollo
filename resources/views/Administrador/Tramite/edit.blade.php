@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <form class="Vertical">
            <legend>Editar tramite</legend>
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> Clasificador Siaf</span>
                    <div class="col-sm-3">
                        <input class="form-control input-sm" name="clasificadorSiaf" type="text">
                    </div>

                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label"> Nombre de tramite</span>
                    <div class="col-sm-4">
                        <input class="form-control" name="nombreTramite" type="text">
                    </div>
                </div>

            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-3 control-label"> tipo de recurso</span>
                    <div class="col-sm-1">
                        <input class="form-control input-sm" name="tipoDeRecurso" type="text">
                    </div>
                    <div class="col-sm-1"></div>

                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-3 control-label"> Fuente de financiamieto</span>
                    <div class="col-sm-1">
                        <input class="form-control" name="fuenteFinaciamiento" type="text">
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