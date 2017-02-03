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
    <div class="panel panel-primary">
        <div class="panel-heading"> Editar Alumno</div>
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
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos persona</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="right">
                                        <span class="col-sm-2 control-label"> Numero de Dni</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="dni" type="text"
                                                   autocomplete="off" onkeypress="return validarNum(event)"
                                                   value="{{$a->dni}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm">
                                        <span class="col-sm-2">Nombres</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="nombres" type="text"
                                                   autocomplete="off" onkeypress="return validarLetras(event)"
                                                   value="{{$a->nombres}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm">
                                        <span class="col-sm-2">Apellidos</span>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" name="apellidos" type="text"
                                                   autocomplete="off" onkeypress="return validarLetras(event)"
                                                   value="{{$a->apellidos}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos Alumno</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <span class="col-sm-2 control-label"> Codigo alumno</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="codAlumno" type="text"
                                                   autocomplete="off" value="{{$a->codAlumno}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <span class="col-sm-3 control-label"> Codigo matricula</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="codMatricula" type="text"
                                                   autocomplete="off" value="{{$a->codMatricula}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <span class="col-sm-2 control-label"> Fecha matricula</span>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" name="fecha" type="text"
                                                   autocomplete="off" value="{{$a->fecha}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="col-md-3"></div>
                            <a href="{{url('/Layout')}}" class=" col-md-2 btn btn-sm btn-danger"><span
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