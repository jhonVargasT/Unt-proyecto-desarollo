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
        <script src="{{asset('assets/js/js-personalizados/reporteresumido.js')}}"></script>
        <script type="text/javascript">

        </script>
        <div class="panel-heading"><h3>Reporte Pagos</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                <div class="panel-body form-group ">
                    <form id="miform" action="{{'admReporteresumido'}}" onsubmit="activarBotonreporte(event)"
                          role="form" method="POST" class="Vertical">
                        {{csrf_field()}}
                        <div class="row justify-content-center">

                            <div class=" form-group-sm col-sm-2 col-lg-2 col-xs-2">
                                <span class=" control-label text-justify">Tipo de reporte para :</span>
                                <select class="form-control " id="tipreporte" onclick="cambiartabla(event)"
                                        name="tipreporte">
                                    <option >Clasificador S.I.A.F</option>
                                    <option >Resumen total</option>
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2">
                                <span class="control-label text-justify">Buscar por :</span>
                                <select class=" form-control" name="combito" id="combito" onclick="cambiarmenu(event);">
                                    <option>Escojer</option>
                                    <option>Año</option>
                                    <option>Mes</option>
                                    <option>Dia</option>
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2" id="opc">
                            </div>
                            <div class=" text-justify form-group-sm col-sm-2 col-lg-2 col-xs-2">
                                <input type="checkbox" id="ccp"
                                       onclick="habilitarTexto(this.checked,'textbox','spantext')">
                                Unidad operativa
                                <div class="col-sm-5 col-lg-6 col-xs-5">
                                    <input type="text" class="form-control " name="textbox" id="textbox"
                                           autocomplete="off" disabled required
                                           onchange="validarNumeros('textbox','spantext')">
                                    <span class=" text-justify control-label" style="color: red" id="spantext"></span>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <button type="submit" class=" justify-content-end col-md-1 btn btn-sm btn-success" id="imp"
                                    onmouseover="activarBotonreporte(null)">
                                <span class="text-justify ion-ios7-search"> </span> buscar
                            </button>
                        </div>
                        &nbsp;
                        <div class=" col-sm-12 row form-group " align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                    </form>
                    <!--Tabla-->
                    <br>
                    <div class=" row form-group ">
                        <div class=" row   col-sm-12 row form-group ">
                                <div align="right" >
                                    Total :@if(isset($total) ) &nbsp; S/. {{$total}}
                                    @else S/. 0.00 @endif
                                </div>
                        </div>
                        <div class="table-responsive col-sm-12">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                @if(isset($resultsiaf))
                                    <thead>
                                    <!--cabecear Tabla-->
                                    <tr>
                                        <th>
                                            Unidad Operativa
                                        </th>
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
                                                CUENTA
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
                                            <td><h6 align="center">{{$r->unop}}</h6></td>
                                            <td><h6 align="center">{{$r->clasificadorsiaf}}</h6></td>
                                            <td><h6 align="left">{{$r->nombreTramite}}</h6></td>
                                            <td><h6 align="center">{{$r->codigoSubtramite }}</h6></td>
                                            <td><h6 align="left">{{$r->nombresubtramite}}</h6></td>
                                            <td><h6 align="center">{{$r-> precio}}</h6></td>
                                            <td><h6 align="center">{{$r->nurPagos }}</h6></td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @else
                                    @if(isset($resultresu))
                                        <thead>
                                        <!--cabecear Tabla-->
                                        <tr>
                                            <th>
                                                <div align="center">
                                                    CODIGO CLASIFICADOR S.I.A.F
                                                </div>
                                            </th>
                                            <th>
                                                <div align="center">
                                                    UNIDAD OPERATIVA
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
                                                <td><h6 align="center">{{$r->unop}}</h6></td>
                                                <td><h6 align="left">{{$r->nombreTramite}}</h6></td>
                                                <td><h6 align="center">{{$r->importe}}</h6></td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    @else
                                        <thead>
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
                                    <a href="excelresum/{{$tiprep}}/{{$varopc}}/{{$tiempo}}/{{$numero}}/{{$unop}}"
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
