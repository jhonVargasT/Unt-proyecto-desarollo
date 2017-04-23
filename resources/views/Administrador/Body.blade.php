@extends('Administrador/LayoutAdm')
@section('body')
    <!--barra de navegacion -->
    @if(  Session::has('tipoCuentaA') )
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

                                                <a href="/admReportres"><span class="glyphicon glyphicon-book"></span> Reporte Resumido</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="/admReportes"> <span class="glyphicon glyphicon-list-alt"></span> Reporte pagos detallado</a>
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
                                                <a href="/admBuscarEstudiante">Buscar Estudiantes</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarEstudiante">Agregar Estudiante</a>
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
                                                <a href="/admBuscarCliente">Buscar Clientes</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarCliente">Agregar Clientes</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThrees">
                                        <span class="fa fa-building-o"></span>
                                        Facultades</a>
                                </h4>
                            </div>
                            @yield('facultad')
                            <div id="collapseThrees" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarFacultad">Buscar Facultades</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarFacultad">Agregar Facultad</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSede">
                                        <span class="fa fa-building-o"></span>
                                        Sedes</a>
                                </h4>
                            </div>
                            @yield('sede')
                            <div id="collapseSede" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarSede">Buscar Sedes</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarSede">Agregar Sede</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                        <span class="glyphicon glyphicon-tower"></span>
                                        Escuelas</a>
                                </h4>
                            </div>
                            @yield('escuela')
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarEscuela">Buscar Escuelas</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarEscuela">Agregar Escuela</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span
                                                class="fa fa-users">
                            </span> Personal</a>
                                </h4>
                            </div>
                            @yield('personal')
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarPersonal">Buscar Personal</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarPersonal">Agregar Personal</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                        <span class="glyphicon glyphicon-pushpin"></span>
                                        </span>  Clasificador</a>
                                </h4>
                            </div>
                            @yield('tramite')
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarTramite">Buscar Clasificador</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarTramite">Agregar Clasificador</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                                <span class="glyphicon glyphicon-pushpin">
                            </span> Tasa</a>
                                </h4>
                            </div>
                            @yield('subtramite')
                            <div id="collapseSix" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-search"></span>
                                                <a href="/admBuscarSubtramite">Buscar Tasa</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarSubtramite">Agregar Tasa</a>
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
                                                <a href="/admBuscarDonaciones">Buscar Donaciones y transferencias</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admRegistrarDonaciones">Agregar Donaciones y transferencias</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseExcel"><span
                                                class="fa fa-file">
                            </span> Importar Pagos</a>
                                </h4>
                            </div>
                            @yield('excel')
                            <div id="collapseExcel" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <span class="glyphicon glyphicon-plus"></span>
                                                <a href="/admImportarExcel"> Importar Pagos</a>
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
                patron = /[A-Za-z ]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
            function validarCodigoSiaf(e) {
                tecla = (document.all) ? e.keyCode : e.which;

                if (tecla == 8) {
                    return true;
                }
                patron = /[0-9.]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
            function validarDouble(e) {
                tecla = (document.all) ? e.keyCode : e.which;

                if (tecla == 8) {
                    return true;
                }
                patron = /[0-9.]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
        </script>
    @else
        @include("index")
    @endif
@stop