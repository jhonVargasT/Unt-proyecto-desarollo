@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <div>
            <legend>Buscar Donaciones y Transacciones</legend>
            <!--menu Busqueda-->
            <br>
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
                <div class="input-group col-sm-6">
                    <input type="text" class="form-control" placeholder="Ingresa datos aqui ..">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Buscar</button>
                        </span>
                </div>

            </div>

            <!--tabla-->
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr >

                        <th>Numero Resolucion</th>
                        <th>Codigo Siaf</th>
                        <th>Tipo Recurso</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Descripcion</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <body>
                    <tr >
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
    </fieldset>
@stop