@extends('Administrador.Body')
@section('body')
    <br>
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Reporte Pagos</div>
        <div class="panel-body">
            <div class="panel-body form-group ">
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-4 ">
                        <span class="col-sm-4 control-label">Estado </span>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="estado">
                                <option>Todo</option>
                                <option>Pagado</option>
                                <option>Anulado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <span class="col-sm-5 control-label">Modalidad</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control">
                                <option>Todo</option>
                                <option>Banco</option>
                                <option>Online</option>
                                <option>Ventanilla</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <div class="col-sm-6 ">
                            <select class=" form-control">
                                <option>Todo</option>
                                <option>Tramite</option>
                                <option>SubTramite</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control input-sm " name="tramite" autocomplete="off" disabled >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group ">
                    <div class="form-group-sm col-sm-4 ">
                        <span class="col-sm-4 control-label">Facultad</span>
                        <div class="col-sm-8 ">
                            <select class=" form-control" name="facultad">
                                <option>todo</option>
                                <option>Ingenieria</option>
                                <option>Medicina</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <div class="col-sm-5">
                            <input type="checkbox" value="" autocomplete="off">
                            Escuela
                        </div>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="escuela">
                                <option>Ing software</option>
                                <option>Anulado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <div class="col-sm-9">
                            <input type="checkbox" name="fuenteFin" autocomplete="off">
                            Fuente de financiamiento
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm " name="fuenteFinanciamiento" autocomplete="off" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-4 ">
                        <div class="col-sm-9">
                            <input type="checkbox" value="" autocomplete="off">
                            Tipo de recurso
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm " name="tipoDeRecurso" autocomplete="off" disabled>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <span class="col-sm-6 control-label">Fecha:  </span>
                        <div class="col-sm-6 input-group date" data-provide="datepicker">
                            <input type="text" name="fechaDesde" class="form-control" placeholder="desde" autocomplete="off">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-4 ">
                        <div class="col-sm-6 input-group date" data-provide="datepicker">
                            <input type="text" name="fechaHasta" class="form-control" placeholder="hasta" autocomplete="off">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tabla-->
                <br>
                <br>
                <div class="col-sm-12 row form-group ">
                    <br>
                    <div class="col-sm-9"></div>
                    <div class="col-sm-3">
                        <div class="col-sm-6">
                            Total :
                        </div>
                        <div class="col-sm-6">
                            Cantidad
                        </div>
                    </div>
                </div>
                <div  align="center" class="col-sm-12 row form-group " >
                    <div class="table-responsive col-sm-12" >
                        <table class="table table-bordered list-inline" >
                            <thead>
                            <!--cabecear Tabla-->
                            <tr class="active">

                                <th>
                                    <div align="center"><small>Id pago</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Tipo tramite</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>boucherl</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>fecha de pago</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>cuenta SIAF</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Cuenta contable</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Facultad</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Escuela</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Monto</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Mondalidad</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Nombre Cajero</small>
                                    </div>
                                </th>
                                <th>
                                    <div align="center">
                                        <small>Opciones</small>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <body>
                            <!--Contenido-->
                            <tr>
                                <td><h6>00001</h6></td>
                                <td><h6>125.168.129.58</h6></td>
                                <td><h6>Aw32234234</h6></td>
                                <td><h6>125.168.129.58</h6></td>
                                <td><h6>Aw32234234</h6></td>
                                <td><h6>Aw32234234</h6></td>
                                <td><h6>00001</h6></td>
                                <td><h6>125.168.129.58</h6></td>
                                <td><h6>Aw32234234</h6></td>
                                <td><h6>125.168.129.58</h6></td>
                                <td><h6>Aw32234234</h6></td>
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
                    <div class="col-sm-12 row form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <a href="/Adm" class="btn  btn-primary"><span
                                        class="glyphicon glyphicon-arrow-left"></span> Regresar
                            </a>
                        </div>

                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <button href="#" class="btn  btn-primary">Imprimir <span
                                        class="glyphicon glyphicon-print"></span></button>
                        </div>

                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop