@extends('RegistroTecnico.Body')
@section('estudiante')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/regActualizarEstudiante">Actualizar Estudiantes</a>
                    </td>
                </tr>
                <!--<tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEstudianteProduccion">Buscar Estudiantes
                            Produccion</a>
                    </td>
                </tr>-->
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/regRegistrarEstudiante" style="color: #509f0c" target="_top">Agregar Estudiante</a>
                    </td>
                </tr>
                <!--<tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEstudianteProduccion">Agregar Estudiante
                            Produccion</a>
                    </td>
                </tr>-->
            </table>
        </div>
    </div>
@stop

@section('content')
    @if( Session::has('tipoCuentaRT'))
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <div class="panel-heading"><h3>Agregar Estudiante</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <form name="form"
                      onsubmit="activarbotonform(event,['spandni','spannombre','spanapellidos','spancodalumno','spancodalumno','spansede','spanescuela'],'enviar','mensaje')"
                      action="{{url('AlumnoRegistrado')}}" role="form" method="POST" class="Horizontal">
                    {{csrf_field()}}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos personales</div>
                        <div class="panel-body">
                            <div class=" row ">
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Numero de Dni</span>
                                    <input class="form-control input-sm" name="dni" type="text"
                                           autocomplete="off" onchange=" validarDni('dni','spandni')"
                                           placeholder="Ejem: 72978792" required id="dni">
                                    <span style="color: red" class=" control-label" id="spandni"> </span>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Nombres</span>
                                    <input class="form-control input-sm" name="nombres" type="text"
                                           autocomplete="off" onchange="validarNombre('nombres','spannombre')"
                                           placeholder="Ejm:Jose Carlos" required id="nombres">
                                    <span style="color: red" class=" control-label" id="spannombre"> </span>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Apellidos</span>
                                    <input class="form-control input-sm" name="apellidos" type="text"
                                           autocomplete="off" onchange="validarNombre('apellidos','spanapellidos')"
                                           placeholder="Ejem: Terenas Lory" required id="apellidos">
                                    <span style="color: red" class=" control-label" id="spanapellidos"> </span>
                                </div>
                                <!--<div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Correo</span>
                                    <input class="form-control input-sm" name="correo" type="email" id="email"
                                           autocomplete="off" onchange="validarCorreo('email','spanemail')" required>
                                    <span style="color: red" class=" control-label" id="spanemail"> </span>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos Alumno</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Codigo alumno</span>
                                    <input class="form-control input-sm" name="codAlumno" type="text"
                                           onchange="validarNumeros('codAlumno','spancodalumno')"
                                           autocomplete="off" placeholder="Ejm: 000104499" required id="codAlumno">
                                    <span style="color: red" class=" control-label" id="spancodalumno"> </span>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Fecha matricula</span>
                                    <div class="col-sm-12 input-group date" data-provide="datepicker">
                                        <input type="text" name="fecha" class="form-control"
                                               value="<?php date_default_timezone_set('America/Lima');
                                               $date = date('m/d/Y');
                                               echo $date ?>" id="fecha" required>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Sede</span>
                                    <input class="typeahead form-control"
                                           placeholder="Ejm: Trujillo" name="nombreSede" id="ns"
                                           autocomplete="off" required onchange="validarNombre('ns','spansede')">
                                    <span style="color: red" class=" control-label" id="spansede"> </span>
                                    <script type="text/javascript">
                                        var paths = "{{ route('autocompletesede')}}";
                                        $('input.typeahead').typeahead({
                                            source: function (querys, processe) {
                                                return $.get(paths, {query: querys}, function (datas) {
                                                    return processe(datas);
                                                });
                                            }
                                        });
                                    </script>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Escuela</span>
                                    <input class="form-control input-sm" type="text"
                                           placeholder="Ejm: Mecanica" name="nombreEscuela" id="ne"
                                           required disabled onchange="validarNombre('ne','spanescuela')">
                                    <span style="color: red" class=" control-label" id="spanescuela"> </span>
                                    <script>
                                        src = "{{ route('searchajax') }}";
                                        $("#ne").autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    url: src,
                                                    type: 'get',
                                                    dataType: "json",
                                                    data: {
                                                        term: $('#ne').val(),
                                                        sede: $('#ns').val()
                                                    },
                                                    success: function (data) {
                                                        response(data);
                                                    }
                                                });
                                            },
                                            min_length: 1
                                        });
                                    </script>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Facultad</span>
                                    <input class="form-control input-sm" name=" " type="text" id="f" readonly>
                                    <script>
                                        $('#ne').change(function () {
                                            $.ajax({
                                                url: '/facultad',
                                                type: "get",
                                                data: {name: $('#ne').val()},
                                                success: function (data) {
                                                    $('#f').val(data);
                                                }
                                            });
                                        });
                                    </script>
                                    <script>
                                        $('#ns').on('input', function () {
                                            if ($(this).val().length)
                                                $('#ne').prop('disabled', false);
                                            else
                                                $('#ne').prop('disabled', true);
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group" align="center">
                        <span id="mensaje" class="control-label" style="color: red"></span>
                    </div>
                    <div class="row " align="center">

                        <a href="{{url('/Adm')}}" class="  btn btn-sm btn-danger"><span
                                    class="glyphicon glyphicon-ban-circle"></span>
                            Cancelar</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit"
                                onmouseover="activarbotonform(null,['spandni','spannombre','spanapellidos','spancodalumno','spancodalumno','spansede','spanescuela'],'enviar','mensaje')"
                                name="enviar" id="enviar" class=" btn btn-sm btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        @include("index")
    @endif
@stop
