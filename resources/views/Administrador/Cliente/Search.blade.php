@extends('Administrador.Body')
@section('cliente')
    <div id="collapseClie" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarCliente" style="color: #509f0c" target="_top">Buscar Clientes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarCliente">Agregar Clientes</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel  panel-primary">
        <div class="panel-heading"> Buscar cliente</div>
        <div class="panel-body">

            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Dni</option>
                            <option>Nombres y apellidos</option>
                            <option>Codigo personal</option>
                            <option>Ruc</option>
                            <option>Razon social</option>
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

            <!--tabla-->
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active" >

                        <th><div align="center"><small>Dni</small></div></th>
                        <th><div align="center"><small>Nombres</small></div></th>
                        <th><div align="center"><small>Apellidos</small></div></th>
                        <th><div align="center"><small>Codigo personal</small></div></th>
                        <th><div align="center"><small>Ruc</small></div></th>
                        <th><div align="center"><small>Razon social</small></div></th>
                        <th><div align="center"><small>Opciones</small></div></th>
                    </tr>
                    </thead>
                    <body>
                    <!--Contenido-->
                    <tr>
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td>Aw32234234</td>
                        <td>125.168.129.58</td>
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
    </div>
@stop