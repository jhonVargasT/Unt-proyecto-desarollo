@extends('Administrador.LayoutAdm')

@section('body')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="form-control col-sm-12">
        <br>
        @if($alumno)
            @foreach($alumno as $a)
                <div class="panel-heading">
                    <h3>Editar datos del alumno : {{$a->nombres.' '.$a->apellidos}}</h3></div>
            @endforeach
        @endif
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                @if($alumno)
                    @foreach($alumno as $a)
                        <form name="form" action="{{ url('AlumnoEditado/' .$a->codPersona ) }}" role="form" method="Get"
                              class="Vertical">
                            {{csrf_field()}}
                            <div class="panel panel-primary">
                                <div class="panel-heading">Datos persona</div>
                                <div class="panel-body">
                                    <div class=" row ">
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                            <span class="control-label"> Numero de Dni</span>
                                            <input class="form-control input-sm" name="dni" id="dni" type="text"
                                                   autocomplete="off" onchange="validarDni('dni','spandni')"
                                                   placeholder="Ejem: 72978792" required value="{{$a->dni}}">
                                            <span style="color: red" class=" control-label" id="spandni"> </span>
                                        </div>
                                        <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Nombres</span>
                                            <input class="form-control input-sm" name="nombres" id="nombres" type="text"
                                                   autocomplete="off" onchange="validarNombre('nombres','spannombre')"
                                                   placeholder="Ejm:Jose Carlos" required value="{{$a->nombres}}">
                                            <span style="color: red" class=" control-label" id="spannombre"> </span>
                                        </div>
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Apellidos</span>
                                            <input class="form-control input-sm" name="apellidos" type="text"
                                                   autocomplete="off" id="apellidos"
                                                   onmouseover="validarNombre('apellidos','spanapellidos')"
                                                   placeholder="Ejem: Terenas Lory" required value="{{$a->apellidos}}">
                                            <span style="color: red" class=" control-label" id="spanapellidos"> </span>
                                        </div>
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Correo</span>
                                            <input class="form-control input-sm" id="correo" name="correo" type="email"
                                                   autocomplete="off" onchange="validarCorreo('correo','spanemail')"
                                                   required value="{{$a->correo}}">
                                            <span style="color: red" class=" control-label" id="spanemail"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">

                                <div class="panel-heading">Datos Alumno</div>
                                <div class="panel-body">
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label"> Codigo alumno</span>
                                        <input class="form-control input-sm" name="codAlumno" id="codAlumno" type="text"
                                               autocomplete="off" onchange="validarNumeros('codAlumno','spancodalumno')"
                                               placeholder="Ejm: 000104499" required
                                               value="{{$a->codAlumno}}">
                                        <span style="color: red" class=" control-label" id="spancodalumno"> </span>
                                    </div>
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label"> Fecha matricula</span>
                                        <div class="col-sm-12 input-group date" data-provide="datepicker">
                                            <input type="text" name="fecha" class="form-control" value="{{$a->fecha}}">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label">Sede</span>
                                        <input class="typeahead form-control" type="text"
                                               placeholder="Ejm: Trujillo" name="nombreSede" id="ns"
                                               autocomplete="off" required
                                               value="{{$a->nombresede}}">
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
                                               required value="{{$a->enombre}}">
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
                                        <input class="form-control input-sm" name=" " type="text" id="f" readonly
                                               value="{{$a->fnombre}}">
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
                            <div class="col-sm-12 row form-group" align="center">
                                <span id="mensaje" class="control-label" style="color: red"></span>
                            </div>
                            <div class=" row ">
                                <div class="col-md-3"></div>
                                <a href="{{url('/admBuscarEstudiante')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                            class="glyphicon glyphicon-ban-circle"></span>
                                    Regresar
                                </a>
                                <div class="col-md-2">
                                </div>
                                <div>
                                    <button href="" type="submit" name="enviar" id="enviar"
                                            class="col-md-2 btn btn-sm btn-success"><span
                                                class="glyphicon glyphicon-ok"></span> Guardar
                                    </button>
                                </div>
                                <div class="col-md-3"></div>
                            </div>

                        </form>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop