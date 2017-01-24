@extends('Administrador.Body')
@section('content')
    <fieldset>
        <div>
            <legend>Buscar escuelas</legend>
            <!--menu Busqueda-->
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Facultad</option>
                            <option>Codigo Escuela</option>
                            <option>Nombre escuela</option>
                            <option>Cuenta interna</option>
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
                    <head>
                        <!--cabecear Tabla-->
                        <tr>

                            <th>Codigo Escuela</th>
                            <th>Facultad</th>
                            <th>Cuenta interna</th>
                            <th>Nombre Escuela</th>
                            <th>Opciones</th>

                        </tr>
                    </head>
                    <body>
                    <tr>
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td>1546568</td>
                        <td>10/01/2017</td>

                        <td>
                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>

                        </td>
                    </tr>
                    <tr>
                        <td>00002</td>
                        <td>125.168.129.58</td>
                        <td>5648665</td>
                        <td>10/01/2017</td>

                        <td>
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