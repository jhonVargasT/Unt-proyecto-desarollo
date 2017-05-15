@extends('Ventanilla/LayoutVenta')
@section('body')
    <!--barra de navegacion -->
    @if(  Session::has('tipoCuentaV') )
        <div class="col-sm-2 " style="background-color: #FFFFFF ; height:100%">
            <br>
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
                                        <a href="/venBuscarEstudiante">Buscar Estudiantes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/venBuscarEstudianteProduccion">Buscar Estudiantes
                                            Produccion</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/venRegistrarEstudiante">Agregar Estudiante</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/venRegistrarEstudianteProduccion">Agregar Estudiante Produccion</a>
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
        <div class="col-sm-10" style="align-items: center">
            <br>
            @yield('content')
        </div>
        <script>
            function validarNum(e) {
                tecla = (document.all) ? e.keyCode : e.which;

                if (tecla == 8) {
                    return true;
                }
                patron = /[0-9]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
            function validarLetras(e) {
                tecla = (document.all) ? e.keyCode : e.which;

                if (tecla == 8) {
                    return true;
                }
                patron = /[A-Za-z]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
        </script>
    @else
        @include("index")
    @endif
@stop