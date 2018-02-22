@extends('RegistroTecnico.LayoutRegistro')
@section('body')
    <!--barra de navegacion -->
    @if(  Session::has('tipoCuentaRT') )
        <div class="col-sm-2 " style="background-color: #FFFFFF ; height:100%">
            <br>
            <div class="panel-group" id="accordion">
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
                                <!--<tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/venBuscarEstudianteProduccion">Buscar Estudiantes
                                            Produccion</a>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit"></span>
                                        <a href="/regActualizarEstudiante">Actualizar Alumno</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/regRegistrarEstudiante">Registrar Alumno</a>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/venRegistrarEstudianteProduccion">Agregar Estudiante Produccion</a>
                                    </td>
                                </tr>-->

                            </table>
                        </div>
                    </div>
                </div>
            <!--<div class="panel panel-primary">
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
                </div>-->
            <!--<div class="panel panel-primary">
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
            </div>-->
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