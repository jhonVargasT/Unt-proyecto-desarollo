@extends('Administrador.Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite" style="color: #509f0c" target="_top">Buscar Tramites</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite">Agregar Tramite</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Buscar tramites</div>
        <div class="panel-body">
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Clasificador Siaf</option>
                            <option>Tipo de recurso</option>
                            <option>Nombre de tramite</option>
                            <option>Fuente de financiamiento</option>
                        </select>
                    </div>
                </div>
                <div class="input-group col-sm-6">
                    <input type="text" class="form-control" placeholder="Escribe el dato aqui .." autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Buscar</button>
                        </span>
                </div>
            </div>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <head>
                        <!--cabecear Tabla-->
                        <tr class="active">

                            <th><div align="center"><small>Clasificador Siaf</small></div></th>
                            <th><div align="center"><small>Tipo de recurso</small></div></th>
                            <th><div align="center"><small>Nombre de tramite</small></div></th>
                            <th><div align="center"><small>Fuente de financiamiento</small></div></th>
                            <th><div align="center"><small>Opciones</small></div></th>

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
    </div>
@stop