@extends('Administrador.Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y transacciones</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones">Agregar Donaciones y transacciones</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">

        <div class="panel-heading">Buscar Donaciones y Transacciones</div>
        <!--menu Busqueda-->
        <div class="panel-body">
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Fecha</option>
                            <option>Codigo Siaf</option>
                            <option>Tipo de recurso</option>
                            <option>Fecha</option>
                            <option>Numero Resolucion</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-sm input-group col-sm-6">
                    <input type="text" class="form-control" placeholder="Ingresa datos aqui .." autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="button">Buscar</button>
                        </span>
                </div>
            </div>
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active">
                        <th><div align="center"><small>Numero Resolucion</small></div></th>
                        <th><div align="center"><small>Codigo Siaf</small></div></th>
                        <th><div align="center"><small>Tipo Recurso</small></div></th>
                        <th><div align="center"><small>Fecha</small></div></th>
                        <th><div align="center"><small>Monto</small></div></th>
                        <th><div align="center"><small>Descripcion</small></div></th>
                        <th><div align="center"><small>Opciones</small></div></th>
                    </tr>
                    </thead>
                    <body>
                    <tr>
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td>A</td>
                        <td>10/01/2017</td>
                        <td>250</td>
                        <td> asdqwkeqweoñqiw askdlkwqeopiqweioqwiea sdkqwoeiopqwiepoiqwoepi</td>
                        <td>
                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
                    </tr>
                    <tr>
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td>A</td>
                        <td>10/01/2017</td>
                        <td>250</td>
                        <td> asdqwkeqweoñqiw askdlkwqeopiqweioqwiea sdkqwoeiopqwiepoiqwoepi</td>
                        <td>
                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
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