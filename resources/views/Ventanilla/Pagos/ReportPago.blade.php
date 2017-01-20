@extends('Ventanilla.Menu')
@section('content')
    <fieldset>
        <div>
            <legend>Buscar estudiante</legend>
            <!--menu Busqueda-->
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Dni</option>
                            <option>Codigo alumno</option>
                            <option>Ruc</option>
                            <option>Codigo pago</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-sm input-group col-sm-6">
                    <input type="text" class="form-control" placeholder="Ingresa datos aqui ..">
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="button">Buscar</button>
                        </span>
                </div>

            </div>

            <!--tabla-->
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr >

                        <th>Codigo de pago</th>
                        <th>Dni</th>
                        <th>Nombres y apellidos</th>
                        <th>Codigo alumno</th>
                        <th>Codigo Matricula</th>
                        <th>Fecha Matricula</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <body>
                    <!--Contenido-->
                    <tr >
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td>Aw32234234</td>
                        <td>125.168.129.58</td>
                        <td>Aw32234234</td>
                        <td>Aw32234234</td>

                        <td align="center">
                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
                        </td>

                    </tr>

                    </body>
                </table>
            </div>
            <div class="col-sm-12 row">
                <div class="col-sm-4"></div>
                <!--paginadro-->
                <div class="col-sm-4" align="center">
                    <ul class="pagination  pagination-sm">
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                    </ul>
                </div>
                <div class="col-sm-4"></div>

            </div>

        </div>
    </fieldset>
@stop