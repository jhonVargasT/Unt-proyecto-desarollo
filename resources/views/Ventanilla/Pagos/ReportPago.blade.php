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
        <div class="panel-heading"> Reportar Pago</div>
        <div class="panel-body">
            <form name="form" action="{{url('PagosBuscados')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="selected">
                                <option>Todo</option>
                                <option>Dni</option>
                                <option>Codigo alumno</option>
                                <option>Ruc</option>
                                <option>Codigo pago</option>
                                <option>Codigo personal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        @if(isset($txt))
                            <input type="text" name="text" class="form-control" value="{{$txt}}">
                        @else
                            <input type="text" name="text" class="form-control" placeholder="Ingresa datos aqui .."
                                   autocomplete="off" value=" ">
                        @endif
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
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
                                <small>Subtramite</small>
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
                                    <a href="PagoImprimir/{{$p->codPago}}"><span
                                                class="glyphicon glyphicon-print"></span> </a>
                                    <a href="PagoEliminar/{{$p->codPago}}"><span
                                                class="glyphicon glyphicon-trash"></span> </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </body>
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
                        <a href="pdf/{{$txt}}/{{$select}}" class="btn btn-sm btn-primary"><span
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