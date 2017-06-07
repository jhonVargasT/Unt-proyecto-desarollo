@extends('Importaciones/LayoutAdm')
@section('body')
    <!--barra de navegacion -->
    @if(  Session::has('tipoCuentaI') )
        {{csrf_field()}}
        <div class="col-sm-2 " style="background-color: #FFFFFF">
            <br>
            <div class="panel-group" id="accordion">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseProduccion">
                                <span class="fa fa-building-o">
                            </span> Sedes</a>
                        </h4>
                    </div>
                    @yield('sede')
                    <div id="collapseProduccion" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-import"></span>
                                        <a href="/impSedes">Importar Sedes</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <span class="fa fa-building-o">
                                    </span> Facultades</a>
                        </h4>
                    </div>
                    @yield('facultad')
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="/impFacultades"><span class="glyphicon glyphicon-import"></span> Importar
                                            Facultades</a>
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
                                        class="fa fa-building-o">
                            </span> Escuelas</a>
                        </h4>
                    </div>
                    @yield('escuela')
                    <div id="collapseSeven" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-import"></span>
                                        <a href="/impEscuelas">Importar Escuelas</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseEs">
                                <span class="glyphicon glyphicon-user">
                            </span> Alumnos</a>
                        </h4>
                    </div>
                    @yield('alumno')
                    <div id="collapseEs" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-import"></span>
                                        <a href="/impAlumnos">Importar Alumnos</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCl">
                                <span class="glyphicon glyphicon-plus">
                            </span> Clasificadores</a>
                        </h4>
                    </div>
                    @yield('tramite')
                    <div id="collapseCl" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-import"></span>
                                        <a href="/impTramites">Importar Clasificadores</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTa">
                                <span class="glyphicon glyphicon-plus">
                            </span> Tasas</a>
                        </h4>
                    </div>
                    @yield('tasa')
                    <div id="collapseTa" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-import"></span>
                                        <a href="/impTasas">Importar Tasas</a>
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