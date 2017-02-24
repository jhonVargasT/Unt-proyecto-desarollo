@extends('Administrador/Body')
@section('body')
    <br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Reporte Pagos</div>
        <div class="panel-body">
            <div class="panel-body form-group ">
                <form  action=""  role="form" method="POST" class="Vertical">
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
                                <select class=" form-control" id="select" name="select">
                                    <option value="Todo">Todo</option>
                                    <option value="tramite">Tramite</option>
                                    <option value="subtramite">SubTramite</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm " id="input" name="input">
                                <script>
                                    var $select = $('#select'), $input = $('#input');
                                    $select.change(function () {
                                        if ($select.val() == 'tramite' || $select.val() == 'subtramite') {
                                            $input.removeAttr('disabled');
                                        } else {
                                            $input.attr('disabled', 'disabled').val('');
                                        }
                                    }).trigger('change');
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group ">
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-4 control-label">Facultad</span>
                            <div class="col-sm-8 ">
                                <select class=" form-control" name="facultad">
                                    <option>Todo</option>
                                    <?php
                                    use App\facultadmodel;
                                    $facultad = new facultadmodel();
                                    $facultadbd = $facultad->llenarFacultadReporte();
                                    foreach ($facultadbd as $f) {
                                        echo '<option>' . $f->nombre . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cb">
                                Escuela
                            </div>
                            <div class="col-sm-7 ">
                                <script>
                                    $('#cb').change(function () {
                                        if ($(this).is(':checked')) {
                                            $('#es').prop('disabled', false);
                                        } else {
                                            $('#es').prop('disabled', true);
                                        }
                                    });
                                </script>
                                <select class=" form-control" id="es" disabled="true">
                                    <option selected disabled>Seleccionar..</option>
                                    <option>Todo</option>
                                    <?php
                                    use App\escuelamodel;
                                    $escuela = new escuelamodel();
                                    $escuelabd = $escuela->llenarEscuelaReporte();
                                    foreach ($escuelabd as $e) {
                                        echo '<option>' . $e->nombre . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-9">
                                <input type="checkbox" id="cbff" autocomplete="off">
                                Fuente de financiamiento
                            </div>
                            <div class="col-sm-3">
                                <script>
                                    $('#cbff').change(function () {
                                        if ($(this).is(':checked')) {
                                            $('#ff').prop('disabled', false);
                                        } else {
                                            $('#ff').prop('disabled', true);
                                        }
                                    });
                                </script>
                                <input type="text" class="form-control input-sm " id="ff"
                                       autocomplete="off" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-9">
                                <input type="checkbox" id="cbtr">
                                Tipo de recurso
                            </div>
                            <div class="col-sm-3">
                                <script>
                                    $('#cbtr').change(function () {
                                        if ($(this).is(':checked')) {
                                            $('#tr').prop('disabled', false);
                                        } else {
                                            $('#tr').prop('disabled', true);
                                        }
                                    });
                                </script>
                                <input type="text" class="form-control input-sm " id="tr" autocomplete="off"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-6 control-label">Fecha:  </span>
                            <div class="col-sm-6 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaDesde" class="form-control" placeholder="desde"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-6 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaHasta" class="form-control" placeholder="hasta"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                <div align="center" class="col-sm-12 row form-group ">
                    <div class="table-responsive col-sm-12">
                        <table class="table table-bordered list-inline">
                            <thead>
                            <!--cabecear Tabla-->
                            <tr class="active">

                                <th>
                                    <div align="center">
                                        <small>Id pago</small>
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
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
                                <td><h6></h6></td>
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