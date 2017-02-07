@extends('Ventanilla.Body')
@section('pago')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <i class="icomoon icon-coin"></i>
                        <a href="/ventRelizarPago" style="color: #509f0c" target="_top">Realizar pago</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="glyphicon glyphicon-list-alt"></i>
                        <a href="/ventReportPago">Mostrar pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')

    <div class="panel panel-primary ">
        <div class="panel-heading "> Realizar pago</div>
        <div class="panel-body">
            <div class="col-sm-12">
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="right">
                        <div class="col-sm-3 ">
                            <select class=" form-group-sm form-control" name="Seleccion">
                                <option> Dni</option>
                                <option> Ruc</option>
                                <option> Codigo de alumno</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="buscar" name="dni" type="text" autocomplete="off">
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
                        <span class="col-sm-2">Tipo tramite</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="tipoTramite" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Facultad</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="apellido" type="text" autocomplete="off"
                                   disabled>
                        </div>
                        <span class="col-sm-2">Escuela</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="tipoTramite" type="text" autocomplete="off"
                                   disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Detalle </span>
                        <div class="col-sm-4">
                            <textarea class="form-control input-sm" name="apellido" type="text" autocomplete="off">
                                </textarea>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 row form-group">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-8">Total boleta : 59 soles:</div>

                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-8">Total pagar : 59 soles:</div>

                </div>
            </div>

            <div class="col-sm-12">
                <br>
                <div class="col-sm-5">
                </div>
                <div class="col-sm-2">
                    <button href="#" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-print"></span>
                        Pagar
                    </button>
                </div>
                <div class="col-sm-5">

                </div>
            </div>

        </div>

    </div>

@stop
