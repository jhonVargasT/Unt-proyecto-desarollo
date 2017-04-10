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
        <br>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <div class="panel panel-primary">
            <div class="panel panel-heading"> Reporte Pagos</div>
            <div class="panel-body">
                <div class="panel-body form-group ">
                    <form id="miform" action="{{'admReporteresumido'}}" role="form" method="POST" class="Vertical">
                        {{csrf_field()}}
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm col-sm-4 ">
                                <span class="col-sm-5 control-label">Tipo de reporte para :</span>
                                <div class="col-sm-7 ">
                                    <select class="form-control" name="tipreporte">

                                        <option>Codigo S.I.A.F</option>
                                        <option>Resumen total</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group-sm col-sm-4 ">
                                <span class="col-sm-3 control-label">Buscar por :</span>
                                <div class="col-sm-9 ">
                                    <div class="col-sm-6">
                                        <select class=" form-control" name="tiempo">
                                            <option>Año</option>
                                            <option>Mes</option>
                                            <option>Dia</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control input-sm" type="text" @if(isset($fecha) )
                                        value="{{$fecha}}"
                                               @endif name="fecha" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-sm col-sm-1">
                                <button type="submit" class="btn  btn-success" id="imp"><span
                                            class="glyphicon glyphicon-repeat"></span> Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--Tabla-->

                    <div align="center" class="col-sm-12 row form-group ">
                        <div class="col-sm-12 row form-group ">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
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
                            <table class="table table-bordered list-inline">
                                @if(isset($resultsiaf))
                                    <thead align="center">
                                    <!--cabecear Tabla-->
                                    <tr class="active">

                                        <th>
                                            <div align="center">
                                                <small>CLASIFICADOR S.I.A.F</small>
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                <small>NOMBRE DE TASA</small>
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                <small>CUENTA</small>
                                            </div>
                                        </th>

                                        <th>
                                            <div align="center">
                                                <small>NOMBRE DE SUBTASA</small>
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                <small>IMPORTE</small>
                                            </div>
                                        </th>
                                        <th>
                                            <div align="center">
                                                <small>NRO PAGOS</small>
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
                                        <thead align="center">
                                        <!--cabecear Tabla-->
                                        <tr class="active">

                                            <th>
                                                <div align="center">
                                                    <small>CLASIFICADOR S.I.A.F</small>
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    <small>NOMBRE DE TASA</small>
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    <small>IMPORTE</small>
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
                                                <td><h6 align="center">{{$r-> importe}}</h6></td>

                                            </tr>
                                        </tbody>
                                        @endforeach
                                    @else
                                        <thead align="center">
                                        <!--cabecear Tabla-->
                                        <tr class="active">

                                            <th>
                                                <div align="center">
                                                    <small>NINGUNA TABLA</small>
                                                </div>
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--Contenido-->

                                        <tr>
                                            <td><h6 align="center"></h6>ningun dato</td>
                                        </tr>
                                        </tbody>
                                    @endif
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
                            <div class="col-md-2">
                                <!--Contenido-->
                                @if(isset($tiprep))
                                    <a href="excelresum/{{$tiprep}}/{{$tiempo}}/{{$fecha }}"
                                       class="btn btn-sm btn-primary"><span
                                                class="glyphicon glyphicon-print"></span> Imprimir
                                    </a>
                                @else
                                    <a class="btn btn-sm btn-primary"><span
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
