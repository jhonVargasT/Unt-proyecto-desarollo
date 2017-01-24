@extends('Ventanilla.Menu')
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
                            <input class="form-control input-sm " name="dni" type="text">
                        </div>
                    </div>
                    <div class="form-group-sm">
                        <span class="col-sm-2">Nombres</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="nombre" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Apellidos</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="apellido" type="text">
                        </div>
                        <span class="col-sm-2">Tipo tramite</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="tipoTramite" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Facultad</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="apellido" type="text" disabled>
                        </div>
                        <span class="col-sm-2">Escuela</span>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" name="tipoTramite" type="text" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm">
                        <span class="col-sm-2">Detalle </span>
                        <div class="col-sm-4">
                            <textarea class="form-control input-sm" name="apellido" type="text">
                                </textarea>
                        </div>

                    </div>
                </div>


            </div>
            <div class="form-group-sm">
                <span class="col-sm-2">Apellidos</span>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="apellido" type="text">
                </div>
                <span class="col-sm-2">Tipo tramite</span>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="tipoTramite" type="text">
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
