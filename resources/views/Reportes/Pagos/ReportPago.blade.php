@extends('Reportes.Body')
@section('pago')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <a href="/repReportesResumido" ><span
                                    class="glyphicon glyphicon-book"></span> Reporte Resumido</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/repReportes" > <span class="glyphicon glyphicon-list-alt"></span> Reporte pagos
                            detallado</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="glyphicon glyphicon-list-alt"></i>
                        <a href="/repReportPago" style="color: #509f0c" target="_top">Mostrar pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3> Reportar Pago</h3></div>
    <div style="background-color: #FFFFFF">

        <div class="panel-body">
            <form name="form" action="{{url('PagosBuscados')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-3 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="selected" id="selected">
                                <option value="Dni">Dni</option>
                                <option value="Codigo alumno">Codigo alumno</option>
                                <option value="Ruc">Ruc</option>
                                <option value="Codigo pago">Codigo pago</option>
                                <option value="Codigo personal">Reporte diario</option>
                                <option value="Todo">Todo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        <input type="text" name="text" class="form-control" @if(isset($txt)) value="{{$txt}}"
                               @endif id="text" required>
                        <script>
                            $('#text').prop('required', true);
                            document.getElementById("text").value = "";
                            $('#selected').change(function () {
                                var value = $('#selected option:selected').attr('value');
                                if (value == 'Todo') {
                                    var x = document.getElementById("text");
                                    x.setAttribute("type", "text");
                                    $('#text').prop('required', false);
                                    document.getElementById("text").value = " ";
                                }
                            });
                        </script>
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-7 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <div class="col-sm-7 ">
                            <input type="checkbox" name="checkbox" value="1"> Deudas<br>
                        </div>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert">El alumno {{$nombre}} fue actualizada!!</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">
                                <small>Codigo de pago</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Dni</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Nombres y apellidos</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Tasa</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Fecha de pago</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Monto</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Modalidad</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Detalle</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Nombre cajero</small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small>Opcion</small>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($pagos))
                        @foreach($pagos as $p)
                            <tr>
                                <td>{{$p->codPago}}</td>
                                <td>{{$p->p1dni}}</td>
                                <td>{{$p->p1nombres}} {{$p->p1apellidos}}</td>
                                <td>{{$p->nombre}}</td>
                                <td>{{$p->pfecha}}</td>
                                <td>{{$p->precio}}</td>
                                <td>{{$p->modalidad}}</td>
                                <td>{{$p->detalle}}</td>
                                <td>{{$p->pnombres}} {{$p->papellidos}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    @if($p->pnombres)
                                        <a href="PagoImprimir/{{$p->codPago}}/{{$p->estadodeuda}}"><span
                                                    class="glyphicon glyphicon-print"></span> </a>
                                    @else
                                        <a href="PagoImprimirR/{{$p->codPago}}/{{$p->estadodeuda}}"><span
                                                    class="glyphicon glyphicon-print"></span> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </body>
                    @endif
                </table>
            </div>
            <div class="col-sm-12 row">
                <div class="col-sm-4"></div>
                <!--paginadro-->
                <div class="col-sm-4">

                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2">
                    <br>
                    @if(isset($total))
                        <div class="col-sm-12" align="left">
                            <td>Cantidad Total:</td> {{$total}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <br>
                <div class="col-sm-5">
                </div>
                <div class="col-sm-2">
                    <!--Contenido-->
                    @if(isset($pagos))
                        <?php $var = 1; ?>
                        @foreach($pagos as $p)
                            @if($p->estadodeuda==0)
                                <?php $var = 0; ?>
                            @endif
                        @endforeach
                        <a href="excel/{{$txt}}/{{$select}}/{{ $var }}" class="btn btn-sm btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir
                        </a>
                    @endif
                </div>
                <div class="col-sm-5">
                </div>
            </div>
        </div>
    </div>
@stop