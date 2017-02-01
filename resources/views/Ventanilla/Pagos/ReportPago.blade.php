@extends('Ventanilla.Body')
@section('pago')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <i class="icomoon icon-coin"></i>
                        <a href="/ventRelizarPago">Realizar pago</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="glyphicon glyphicon-list-alt"></i>
                        <a href="/ventReportPago" style="color: #509f0c" target="_top">Mostrar pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Reportar pago</div>
        <div class="panel-body">
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
                    <tr>

                        <th><div align="center"><small>Codigo de pago</small></div></th>
                        <th><div align="center"><small>Dni</small></div></th>
                        <th><div align="center"><small>Nombres y apellidos</small></div></th>
                        <th><div align="center"><small>Tipo tramite</small></div></th>
                        <th><div align="center"><small>Fecha de pago</small></div></th>
                        <th><div align="center"><small>Monto</small></div></th>
                        <th><div align="center"><small>Modalidad</small></div></th>
                        <th><div align="center"><small>Nombre cajero</small></div></th>
                        <th><div align="center"><small>Opcion</small></div></th>
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
                        <td>Aw32234234</td>
                        <td>00001</td>
                        <td>125.168.129.58</td>
                        <td align="center">
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
                <div class="col-sm-2"></div>
                <div class="col-sm-2">
                    <br>
                    <div class="col-sm-6" align="right">
                        Total :
                    </div>
                    <div class="col-sm-6" align="left">
                        Cantidad
                    </div>
                </div>

            </div>
            <div class="col-sm-12">
                <br>
                <div class="col-sm-5">
                </div>
                <div class="col-sm-2">
                    <button href="#" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-print"></span>
                        Imprimir
                    </button>
                </div>
                <div class="col-sm-5">

                </div>
            </div>
        </div>
    </div>
@stop