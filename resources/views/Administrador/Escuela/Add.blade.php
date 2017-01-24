@extends('Administrador.Body')
@section('content')
    <fieldset>
        <form name="form" action="{{url('EscuelaRegistrada')}}" role="form" method="POST" class="Vertical">
            {{csrf_field()}}
            <legend>Agregar Escuela</legend>
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group " align="left">
                    <span class="col-sm-3 control-label"> Nombre Facultad</span>
                    <div class="input-group col-sm-6">
                        <input type="text" class="form-control" name="nombreFacultad"
                               placeholder="Ingresa Nombre de facultad aqui ..">

                        <select name="nombreFacultad">
                            <?php
                            use App\facultadmodel;
                            $facultad = new facultadmodel();
                            $valores = $facultad->consultarNombreFacultades();
                            foreach ($valores as $val) {
                                echo "<option>" . $val . "</option>";
                            }
                            ?>
                        </select>
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
                        <input class="form-control input-sm" name="codEscuela" type="text">
                    </div>

                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Cuenta interna </span>
                    <div class="col-sm-4">
                        <input class="form-control" name="nroCuenta" type="text">
                    </div>
                </div>

            </div>

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">

                    <span class="col-sm-3 control-label"> Nombre escuela</span>
                    <div class="col-sm-5">
                        <input class="form-control input-sm" name="nombre" type="text">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar</a>
                <div class="col-md-2"></div>
                <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                            class="glyphicon glyphicon-ok"></span> Guardar
                </button>
                <div class="col-md-3"></div>
            </div>
        </form>
    </fieldset>
@stop