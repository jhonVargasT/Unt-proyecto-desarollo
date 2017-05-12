@extends('Administrador.Body')
@section('reportes')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <a href="/admReportres" style="color: #509f0c" target="_top"><span
                                    class="glyphicon glyphicon-book"></span> Reporte Resumido</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/admReportes"> <span class="glyphicon glyphicon-list-alt"></span> Reporte pagos
                            detallado</a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaA'))

        <script type="text/javascript">
            $(document).ready(function () {
                $(".contenido").hide();
                $("#combito").change(function () {
                    $(".contenido").hide();
                    $("#div_" + $(this).val()).show();
                });

            });

            function agregarMenu(val) {
                if (val === 1) {
                    document.getElementById('opc').innerHTML("<input class='form-control input-sm' type='text' @if(isset($fecha) ) value='{{$fecha}}' @endif name='fecha' required> ");
                }
            }
        </script>
        <div class="panel-heading"><h3>Reporte Pagos</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                <div class="panel-body form-group ">
                    <form id="miform" action="{{'admReporteresumido'}}" role="form" method="POST" class="Vertical">
                        {{csrf_field()}}
                        <div class="row ">

                            <div class="form-group-sm col-sm-3 col-lg-3 col-xs-3">
                                <span class=" control-label">Tipo de reporte para :</span>
                                <select class="form-control" name="tipreporte">

                                    <option>Clasificador S.I.A.F</option>
                                    <option>Resumen total</option>
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2">
                                <span class="control-label">Buscar por :</span>
                                <select class=" form-control" name="combito" id="combito">
                                    <option>Escojer</option>
                                    <option value="1">Año</option>
                                    <option value="2">Mes</option>
                                    <option value="3">Dia</option>
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2" id="opc">
                                <div id="div_1" class="contenido">
                                    <span class=" control-label">Año :</span>

                                    <input type="text" class="form-control input-sm " id="año1" name="año1"
                                           autocomplete="off">

                                </div>
                                <div id="div_2" class="row contenido">
                                    <div class="col-sm-6 col-lg-6 col-xs-6">
                                        <span class=" control-label">Año :</span>
                                        <input type="text" class="form-control input-sm " id="trinp" name="año2"
                                               autocomplete="off">
                                    </div>
                                    <div class="col-sm-6 col-lg-6 col-xs-6">
                                        <span class=" control-label">Mes :</span>
                                        <input type="text" class="form-control input-sm " id="trinp" name="mes2"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div id="div_3" class="contenido ">
                                    <span class=" control-label">Elija fecha :</span>
                                    <div class="input-group date " data-provide="datepicker">
                                        <input type="dia" name="fecha" class="form-control"
                                               autocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group-sm col-sm-1 col-lg-1 col-xs-1">
                                <span class=" control-label">.  </span>
                                <button type="submit" class="btn btn-sm btn-success s-b-5" id="imp"><i
                                            class="ion-ios7-search"> </i> buscar
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--Tabla-->
                    <br>
                    <div class=" row form-group ">
                        <div class="col-sm-12 row form-group ">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    Total :
                                </div>
                                <div class="col-sm-4">
                                    @if(isset($total) )
                                        S./ {{$total}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive col-sm-12">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                @if(isset($resultsiaf))
                                    <thead>
                                    <!--cabecear Tabla-->
                                    <tr>

                                        <th>
                                            <div align="center">
                                                CLASIFICADOR S.I.A.F
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                NOMBRE DE CLASIFICADOR
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                UENTA
                                            </div>
                                        </th>

                                        <th>
                                            <div align="center">
                                                NOMBRE DE TASA
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                IMPORTE
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                NRO PAGOS
                                            </div>
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--Contenido-->

                                    @foreach($resultsiaf as $r)
                                        <tr>
                                            <td><h6 align="center">{{$r->clasificadorsiaf}}</h6></td>
                                            <td><h6 align="left">{{$r->nombreTramite}}</h6></td>
                                            <td><h6 align="center">{{$r->cuenta }}</h6></td>
                                            <td><h6 align="left">{{$r->nombresubtramite}}</h6></td>
                                            <td><h6 align="center">{{$r-> precio}}</h6></td>
                                            <td><h6 align="center">{{$r->nurPagos }}</h6></td>
                                        </tr>
                                    </tbody>
                                    @endforeach

                                @else
                                    @if(isset($resultresu))
                                        <thead >
                                        <!--cabecear Tabla-->
                                        <tr>

                                            <th>
                                                <div align="center">
                                                    CODIGO CLASIFICADOR S.I.A.F
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    NOMBRE DE CLASIFICADOR
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    IMPORTE
                                                </div>
                                            </th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--Contenido-->

                                        @foreach($resultresu as $r)
                                            <tr>
                                                <td><h6 align="center">{{$r->clasificadorsiaf}}</h6></td>
                                                <td><h6 align="left">{{$r->nombreTramite}}</h6></td>
                                                <td><h6 align="center">{{$r->importe}}</h6></td>

                                            </tr>
                                        </tbody>
                                        @endforeach
                                    @else
                                        <thead >
                                        <!--cabecear Tabla-->
                                        <tr>

                                            <th>
                                                <div align="center">
                                                    CODIGO CLASIFICADOR S.I.A.F
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    NOMBRE DE CLASIFICADOR
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    IMPORTE
                                                </div>
                                            </th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--Contenido-->

                                        </tbody>
                                    @endif
                                @endif


                            </table>
                        </div>
                        <div class="col-sm-12 row form-group">
                        </div>
                        <div class=" row ">
                            <div class="col-md-4"></div>
                            <div class="col-md-2">
                                <a href="{{url('/Adm')}}" class="btn btn-sm s-b-5  btn-primary"><span
                                            class="glyphicon glyphicon-arrow-left"></span> Regresar
                                </a>
                            </div>
                            <div class="col-md-2">
                                <!--Contenido-->
                                @if(isset($tiprep))
                                    <a href="excelresum/{{$tiprep}}/{{$varopc}}/{{$tiempo}}/{{$numero}}"
                                       class="btn btn-sm s-b-5  btn-primary"><span
                                                class="glyphicon glyphicon-print"></span> Imprimir
                                    </a>
                                @else
                                    <a class="btn btn-sm s-b-5  btn-primary"><span
                                                class="glyphicon glyphicon-print"></span> Imprimir
                                    </a>
                                @endif
                            </div>

                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include("index")
    @endif
@stop
@section('scripts')
    <script type="text/javascript">

        function habilitarff(value) {
            if (value == true) {
                document.getElementById("ff").disabled = false;
            } else if (value == false) {
                document.getElementById("ff").disabled = true;
            }
        }
        function habilitartr(value) {
            if (value == true) {
                document.getElementById("trinp").disabled = false;
            } else if (value == false) {
                document.getElementById("trinp").disabled = true;
            }
        }
        function habilitarsed(value) {
            if (value == true) {
                document.getElementById("sede").disabled = false;
            } else if (value == false) {
                document.getElementById("sede").disabled = true;
            }
        }
        function habilitarfac(value) {

            if (value == true) {
                document.getElementById("sed").checked = true;
                document.getElementById("fac").disabled = false;
                document.getElementById("sede").disabled = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("fac").disabled = true;
                document.getElementById("sede").disabled = true;
            }
        }
        function habilitaresc(value) {
            if (value == true) {
                document.getElementById("sed").checked = true;
                document.getElementById("cfac").checked = true;
                document.getElementById("fac").disabled = false;
                document.getElementById("sede").disabled = false;
                document.getElementById("esc").disabled = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("esc").disabled = true;
                document.getElementById("fac").disabled = true;
                document.getElementById("sede").disabled = true;
            }
        }
    </script>

@endsection
