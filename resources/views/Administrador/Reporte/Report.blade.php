@extends('Administrador/Body')
@section('body')
    <br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Reporte Pagos</div>
        <div class="panel-body">
            <div class="panel-body form-group ">
                <form action="{{'reportePago'}}" role="form" method="POST" class="Vertical">
                    <input type="hidden" name="_token" value="{{csrf_token() }}"/>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-4 control-label">Estado </span>
                            <div class="col-sm-8 ">
                                <select class="form-control" name="estado">
                                    <option>Pagado</option>
                                    <option>Anulado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-5 control-label">Modalidad</span>
                            <div class="col-sm-7 ">
                                <select class=" form-control" name="modalidad">
                                    <option>Todo</option>
                                    <option>Banco</option>
                                    <option>Online</option>
                                    <option>Ventanilla</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-5 control-label">Tipo de persona</span>
                            <div class="col-sm-7 ">
                                <select class=" form-control" name="tipPersona" id="tipPerson">
                                    <option>Todo</option>
                                    <option>Clientes</option>
                                    <option>Alumnos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group ">
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-4 control-label">Facultad</span>
                            <div class="col-sm-8 ">
                                <select class=" form-control" name="facultad" id="fac">
                                    <option>Todo</option>

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
                                    $('#cb').change(function () {
                                        var value = $('#select option:selected').attr('value');
                                        if (value == 'Dni') {
                                            var id = $('#buscar').val();
                                            $.ajax({
                                                url: "/buscarNombresD",
                                                type: "get",
                                                data: {name: id},
                                                success: function (data) {
                                                    if (data == false) {
                                                        $('#nombres').val(data);
                                                        $.ajax({
                                                            url: '/buscarNombresDR',
                                                            type: "get",
                                                            data: {name: id},
                                                            success: function (data) {
                                                                $('#nombres').val(data)
                                                            }
                                                        });
                                                    }
                                                    else {
                                                        $('#nombres').val(data);
                                                    }
                                                }
                                            });
                                        } else {
                                            if (value == 'Ruc') {
                                                $.ajax({
                                                    url: '/buscarNombresR',
                                                    type: "get",
                                                    data: {name: $('#buscar').val()},
                                                    success: function (data) {
                                                        $('#nombres').val(data)
                                                    }
                                                });
                                            } else {
                                                if (value == 'Codigo de alumno') {
                                                    $.ajax({
                                                        url: '/buscarNombresC',
                                                        type: "get",
                                                        data: {name: $('#buscar').val()},
                                                        success: function (data) {
                                                            $('#nombres').val(data);
                                                        }
                                                    });
                                                }
                                            }
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
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-4">
                                <input type="checkbox" id="cbtr">
                                Tipo de recurso
                            </div>
                            <div class="col-sm-2">
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
                            <div class="col-sm-4">
                                <input type="checkbox" id="cbff" autocomplete="off">
                                Fuente de financiamiento
                            </div>
                            <div class="col-sm-2">
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

                        <div class="form-group-sm col-sm-1 ">
                            <span class="col-sm-12 control-label">Fecha:  </span>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaDesde" class="form-control" placeholder="desde"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaHasta" class="form-control"
                                       placeholder="hasta"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class=" col-sm-5"></div>
                        <div class="col-md-2">

                            <button type="submit" name="enviar" class="col-lg-6 btn btn-success"><span
                                        class="glyphicon glyphicon-search"></span> Buscar
                            </button>
                        </div>
                        <div class="col-sm-5"></div>
                    </div>
                </form>
                <!--Tabla-->
                <br>
                <br>
                <div class="col-sm-12 row form-group ">
                    <br>
                    <div class="col-sm-9"></div>
                    <div class="col-sm-3">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-3">
                            Total :
                        </div>
                        <div class="col-sm-2">
                            @if(isset($total) )
                                {{$total}}
                            @endif
                        </div>
                    </div>
                </div>
                <div align="center" class="col-sm-12 row form-group ">
                    <div class="table-responsive col-sm-12">
                        <table class="table table-bordered list-inline">
                            @if(isset($tipo)=='Clientes' )
                                <thead align="center">
                                <!--cabecear Tabla-->
                                <tr class="active">

                                    <th>
                                        <div align="center">
                                            <small>Id pago</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Tramite</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Tipo tramite</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>cuenta SIAF</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Mondalidad</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Fecha</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Monto</small>
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
                                @foreach($result as $r)
                                    <tr>
                                        <td><h6 align="center">{{$r->codPago}}</h6></td>
                                        <td><h6 align="center">{{$r-> nombreTramite}}</h6></td>
                                        <td><h6 align="center">{{$r-> nombreSubTramite}}</h6></td>
                                        <td><h6 align="center">{{$r->clasificadorSiaf}}</h6></td>
                                        <td><h6 align="center">{{$r->modalidad}}</h6></td>
                                        <td><h6 align="center">{{$r-> fechaPago}}</h6></td>
                                        <td><h6 align="center">{{$r-> precio}}</h6></td>
                                        <td align="center">
                                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
                                        </td>

                                    </tr>
                                @endforeach
                                </body>
                            @elseif(isset($tipo)=='Alumnos')
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
                            @else
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
                            @endif
                        </table>
                    </div>
                    <div class="col-sm-12 row form-group">
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <a href="{{url('/Adm')}}" class="btn  btn-primary"><span
                                        class="glyphicon glyphicon-arrow-left"></span> Regresar
                            </a>
                        </div>

                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <button href="#" class="btn  btn-primary" id="imp">Imprimir <span
                                        class="glyphicon glyphicon-print"></span></button>
                        </div>

                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
           $('#fac').click(function () {
               $(get('LlenarFacultad',data,function (result) {
                   alert('123123');
               }));
           });
        });

        $('#fac').change(function () {
            $.ajax({
                url: 'LlenarFacultad',
                type: "get",
                data: {name: $('#fac').val()},
                success: function (data) {
                    $('#fac').val(data);
                }
            });
        });
    </script>

@endsection