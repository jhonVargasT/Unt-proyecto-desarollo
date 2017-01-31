@extends('Administrador.LayoutAdm')
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <span class="fa fa-pie-chart">
                                    </span> Reportes</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="/Reportes">Reporte Pagos</a>
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
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarEstudiante">Buscar Estudiantes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarEstudiante">Agregar Estudiante</a>
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
                    <div id="collapseClie" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarCliente">Buscar Clientes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarCliente">Agregar Clientes</a>
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
                                <spam class="fa fa-building-o"></spam>
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
                                        <a href="/BuscarFacultad" >Buscar Facultades</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarFacultad">Agregar Facultad</a>
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
                                <spam class="fa fa-graduation-cap"></spam>
                                Escuelas</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarEscuela">Buscar Escuelas</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarEscuela">Agregar Escuela</a>
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
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarPersonal">Buscar Personal</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarPersonal">Agregar Personal</a>
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
                                </span> Tramites</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarTramite">Buscar Tramites</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarTramite">Agregar Tramite</a>
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
                            </span> SubTramites</a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarSubtramite">Buscar SubTramites</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarSubtramite">Agregar SubTramite</a>
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
                            </span> Donaciones y Transacciones</a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="/BuscarDonaciones">Buscar Donaciones y transacciones</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="/RegistrarDonaciones">Agregar Donaciones y transacciones</a>
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
<script>
    function validarNum(e){
        tecla = (document.all) ? e.keyCode : e.which;

        if (tecla==8){
            return true;
        }
        patron =/[0-9]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }
    function validarLetras(e){
        tecla = (document.all) ? e.keyCode : e.which;

        if (tecla==8){
            return true;
        }
        patron =/[A-Za-z]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }
</script>
@stop