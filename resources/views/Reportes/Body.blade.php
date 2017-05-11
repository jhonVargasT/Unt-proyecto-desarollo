@extends('Reportes/LayoutAdm')
@section('body')
        <!--barra de navegacion -->
@if(Session::has('tipoCuentaR') )
    <div class="col-sm-2 " style="background-color: #FFFFFF">
        <br>
        <div class="panel-group" id="accordion">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <span class="fa fa-pie-chart">
                                    </span> Reportes</a>
                    </h4>
                </div>
                @yield('reportes')
                <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>
                                    <a href="/repReportesResumido"><span class="glyphicon glyphicon-book"></span>
                                        Reporte
                                        Resumido</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="/repReportes"> <span class="glyphicon glyphicon-list-alt"></span>
                                        Reporte pagos detallado</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven"><span
                                    class="fa fa-money">
                            </span> Donaciones y transferencias</a>
                    </h4>
                </div>
                @yield('donaciones')
                <div id="collapseSeven" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>
                                    <span class="glyphicon glyphicon-search"></span>
                                    <a href="/repBuscarDonaciones">Buscar Donaciones y transferencias</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="glyphicon fa fa-money"></span>
                                    <a href="/repAgregarDonaciones">Registrar Donaciones y transferencias</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseBanco">
                                <span class="fa fa-building-o">
                            </span> Banco</a>
                    </h4>
                </div>
                @yield('banco')
                <div id="collapseBanco" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>
                                    <span class="glyphicon glyphicon-search"></span>
                                    <a href="/buscarreBanco">Buscar cuenta bancaria</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fa fa-building-o"></span>
                                    <a href="/agregarreBanco">Agregar cuenta bancaria</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePago">
                                <span class="glyphicon glyphicon-credit-card">
                            </span> Pago Online</a>
                    </h4>
                </div>
                @yield('pagoonline')
                <div id="collapsePago" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>
                                    <span class="glyphicon glyphicon-credit-card"></span>
                                    <a href="/pagoonline">Pago Online</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-10  " style="background-color:#ccd0d2">
        <br>
        @yield('content')
    </div>

@else
    @include("index")
@endif
@stop