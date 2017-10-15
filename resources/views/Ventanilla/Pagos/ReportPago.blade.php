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
    <div class="panel-heading"><h3> Reportar Pago</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <form name="form" action="{{url('PagosBuscados')}}" role="Form" method="POST" class="Vertical">
                {{ csrf_field() }}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-3 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="selected" id="selected">
                                <option value="Dni">Dni</option>
                                <option value="Codigo alumno">Codigo alumno</option>
                                <option value="Ruc">Ruc</option>
                                <option value="Codigo pago">Codigo pago</option>
                                <option value="Reporte diario">Reporte diario</option>
                                <!--<option value="Todo">Todo</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        <input type="Text" name="text" class="form-control" @if(isset($txt)) value="{{$txt}}"
                               @endif id="text" required>
                        <script>
                            $('#text').prop('required', true);
                            document.getElementById("text").value = "";
                            $('#selected').change(function () {
                                var value = $('#selected option:selected').attr('value');
                                if (value === 'Todo') {
                                    var x = document.getElementById("text");
                                    x.setAttribute("type", "text");
                                    $('#text').prop('required', false);
                                    document.getElementById("text").value = " ";
                                    $('#text').prop('readonly', true);
                                }
                                else {
                                    if (value === 'Reporte diario') {
                                        var x = document.getElementById("text");
                                        x.setAttribute("type", "hidden");
                                        document.getElementById("text").value = '{{Session::get('codPersonal')}}';
                                    }
                                    else {
                                        var x = document.getElementById("text");
                                        x.setAttribute("type", "text");
                                        document.getElementById("text").value = '';
                                        $('#text').prop('required', true);
                                    }
                                }
                            });
                        </script>
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
                <!--<div class="col-sm-7 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <div class="col-sm-7 ">
                            <input type="checkbox" name="checkbox" value="1"> Deudas<br>
                        </div>
                    </div>
                </div>-->
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert">El alumno {{$nombre}} fue actualizada!!</div>
                @endif
                <br>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">
                                Cod. pago
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Dni
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Nombres y apellidos
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Tasa
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Fecha pago
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Monto
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Modalidad
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Detalle
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Nombre cajero
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                Opcion
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
                                    @if($p->estadodeuda == 1)
                                        <a href="PagoDeuda/{{$p->codPago}}"><span
                                                    class="glyphicon glyphicon-usd"></span> </a>
                                    @endif
                                    @if($p->pnombres)
                                        <a title="Imprimir"
                                           onclick="imprimir(event,'PagoImprimir/{{$p->codPago}}/{{$p->estadodeuda}}')"
                                           href=""><span
                                                    class="glyphicon glyphicon-print"></span> </a>
                                    @else
                                        <a title="Imprimir"
                                           onclick="imprimir(event,'PagoImprimirO/{{$p->codPago}}/{{$p->estadodeuda}}')"
                                           href=""><span
                                                    class="glyphicon glyphicon-print"></span> </a>
                                    @endif&nbsp;&nbsp;&nbsp;
                                    @if($p->modalidad=='Online'||$p->modalidad=='Banco')
                                        <a><span class="glyphicon glyphicon-trash"></span> </a>
                                    @else
                                        <a title="Devolver" onclick="devolver(event,'DevolucionPago/{{$p->codPago}}')"
                                           href=""><span
                                                    class="glyphicon glyphicon-minus" style="color: orange "></span>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="" title="Eliminar"
                                           onclick="eliminar(event,'PagoEliminar/{{$p->codPago}}')"><span
                                                    class="glyphicon glyphicon-trash" style="color: red"></span> </a>
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
                <div align="center">
                    <!--Contenido-->
                    @if(isset($pagos))
                        <?php $var = 1; ?>
                        @foreach($pagos as $p)
                            @if($p->estadodeuda==0)
                                <?php $var = 0; ?>
                            @endif
                        @endforeach
                        <a href="excel/{{$txt}}/{{$select}}/{{ $var }}" class="btn btn-sm btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir reporte
                        </a>
                    @endif
                </div>
                <div class="col-sm-5">
                </div>
            </div>
        </div>
    </div>
@stop