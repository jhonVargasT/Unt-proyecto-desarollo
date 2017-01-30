@extends('Administrador.Body')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Editar tramite</div>
        <div class="panel-body">
            <form name="form" action="{{url('TramiteRegistrado')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}

                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> Clasificador Siaf</span>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" name="clasificador" type="text">
                        </div>

                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-2 control-label"> Nombre de tramite</span>
                        <div class="col-sm-4">
                            <input class="form-control" name="nombre" type="text">
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> tipo de recurso</span>
                        <div class="col-sm-1">
                            <input class="form-control input-sm" name="tipoRecurso" type="text">
                        </div>
                        <div class="col-sm-1"></div>

                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-3 control-label"> Fuente de financiamieto</span>
                        <div class="col-sm-1">
                            <input class="form-control" name="fuentefinanc" type="text">
                        </div>
                    </div>
                    glyphicon glyphicon-ok
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