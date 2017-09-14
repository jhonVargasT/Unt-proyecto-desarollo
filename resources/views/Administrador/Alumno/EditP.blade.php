@extends('Administrador.Body')
@section('estudiante')
    <div id="collapseTwo" class="collapse in">
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
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEstudianteProduccion">Buscar Estudiantes
                            Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEstudiante">Agregar Estudiante</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEstudianteProduccion">Agregar Estudiante
                            Produccion</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="panel-heading"><h3>Editar Alumno produccion</h3></div>
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
                                        <span class="control-label" id="spandni" style="color: red"></span>
                                    </div>
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Nombres</span>
                                        <input class="form-control input-sm" name="nombres" id="nombres" type="text"
                                               autocomplete="off" onchange="validarNombre('nombres','spannombres')"
                                               placeholder="Ejm:Jose Carlos" required value="{{$a->nombres}}">
                                        <span class="control-label" style="color: red" id="spannombres"></span>
                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Apellidos</span>
                                        <input class="form-control input-sm" name="apellidos" id="apellidos" type="text"
                                               autocomplete="off" onchange="validarNombre('apellidos','spanapellidos')"
                                               placeholder="Ejem: Terenas Lory" required value="{{$a->apellidos}}">
                                        <span class="control-label" id="spanapellidos" style="color: red"> </span>
                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Correo</span>
                                        <input class="form-control input-sm" name="correo" id="correo" type="email"
                                               autocomplete="off" onchange="validarCorreo('correo','spancorreo')"
                                               placeholder="Ejem: unt@gmail.com" required value="{{$a->correo}}">
                                        <span id="spancorreo" style="color: red" id="spancorreo"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos Alumno</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label"> Codigo alumno</span>
                                        <input class="form-control input-sm" name="codAlumno" id="codAlumno" type="text"
                                               autocomplete="off" placeholder="Ejm: 000104499" required
                                               value="{{$a->codAlumno}}" onchange="validarNumeros('codAlumno','spancodAlumno')">
                                        <span class="control-label" id="spancodAlumno" style="color: red"></span>
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
                                        <span class="control-label">Centro de produccion</span>
                                        <input class="typeahead form-control" type="text"
                                               placeholder="Ejm: UNT" name="produccion"
                                               onkeypress="return validarLetras(event)" autocomplete="off" required
                                               value="{{$a->nombre}}">
                                        <script type="text/javascript">
                                            var paths = "{{ route('autocompleteprod')}}";
                                            $('input.typeahead').typeahead({
                                                source: function (querys, processe) {
                                                    return $.get(paths, {query: querys}, function (datas) {
                                                        return processe(datas);
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" row ">
                            <div class="col-md-3"></div>
                            <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-1">
                            </div>
                            <div>
                                <button href="" type="submit" name="enviar"
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
@stop