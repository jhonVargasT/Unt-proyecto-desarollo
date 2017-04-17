@extends('Administrador.Body')
@section('estudiante')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEstudiante" style="color: #509f0c" target="_top">Buscar Estudiantes</a>
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
@stop
@section('content')
    <div class="panel-heading"><h3>Editar Alumno</h3></div>
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
                                        <input class="form-control input-sm" name="dni" type="text"
                                               autocomplete="off" onkeypress="return validarNum(event)"
                                               placeholder="Ejem: 72978792" required>
                                    </div>
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Nombres</span>
                                        <input class="form-control input-sm" name="nombres" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)"
                                               placeholder="Ejm:Jose Carlos" required>

                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Apellidos</span>
                                        <input class="form-control input-sm" name="apellidos" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)"
                                               placeholder="Ejem: Terenas Lory" required>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Datos Alumno</div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Codigo alumno</span>
                                    <input class="form-control input-sm" name="codAlumno" type="text"
                                           autocomplete="off" placeholder="Ejm: 000104499" required>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Fecha matricula</span>
                                    <div class="col-sm-12 input-group date" data-provide="datepicker">
                                        <input type="text" name="fecha" class="form-control">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Sede</span>

                                    <input class="typeahead form-control" type="text"
                                           placeholder="Ejm: Trujillo" name="nombreSede" id="ns"
                                           onkeypress="return validarLetras(event)" autocomplete="off" required>
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
                                           onkeypress="return validarLetras(event)" required>
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
                                            min_length: 3
                                        });
                                    </script>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm " >
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
                            <div class=" row ">
                                <div class="col-md-3"></div>
                                <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                            class="glyphicon glyphicon-ban-circle"></span>
                                    Regresar
                                </a>
                                <div class="col-md-2">
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
        </div>
        @endforeach
        @endif
    </div>
@stop