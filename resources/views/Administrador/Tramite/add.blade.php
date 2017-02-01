@extends('Administrador.Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite">Buscar Tramites</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite" style="color: #509f0c" target="_top">Agregar Tramite</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Agregar tramite</div>
        <div class="panel-body">
            <form name="form" action="{{url('TramiteRegistrado')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}

                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> Clasificador Siaf</span>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" name="clasificador" type="text" autocomplete="off">
                        </div>

                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-2 control-label"> Nombre de tramite</span>
                        <div class="col-sm-4">
                            <input class="form-control" name="nombre" type="text" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-3 control-label"> tipo de recurso</span>
                        <div class="col-sm-1">
                            <input class="form-control input-sm" name="tipoRecurso" type="text" autocomplete="off">
                        </div>
                        <div class="col-sm-1"></div>

                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-3 control-label"> Fuente de financiamieto</span>
                        <div class="col-sm-1">
                            <input class="form-control" name="fuentefinanc" type="text" autocomplete="off">
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="/Adm" class=" col-md-2 btn btn-sm btn-danger"><span
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