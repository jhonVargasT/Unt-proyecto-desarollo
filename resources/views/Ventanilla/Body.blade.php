@extends('Ventanilla/LayoutVenta')
@section('body')
        <!--barra de navegacion -->
<div class=" col-sm-12 ">
    <br>
    <div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="fa fa-money"></span>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                                Pagos</a>
                        </h4>
                    </div>
                    @yield('pago')
                    <div id="collapseOne" class="panel-collapse collapse">
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
                                        <a href="/ventReportPago">Mostrar pagos</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                <span class="glyphicon glyphicon-user">
                            </span> Estudiantes</a>
                        </h4>
                    </div>
                    @yield('estudiante')
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/ventBuscarEstudiante">Buscar Estudiantes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/ventRegistrarEstudiante">Agregar Estudiante</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseClie">
                                <span class="glyphicon glyphicon-user">
                            </span> Clientes</a>
                        </h4>
                    </div>
                    @yield('cliente')
                    <div id="collapseClie" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/ventBuscarCliente">Buscar Clientes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/ventRegistrarCliente">Agregar Clientes</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-sm-9  ">
            @yield('content')
        </div>
    </div>
</div>
@stop