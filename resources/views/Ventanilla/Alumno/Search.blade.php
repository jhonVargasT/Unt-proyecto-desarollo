@extends('Ventanilla.Body')
@section('estudiante')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/ventBuscarEstudiante" style="color: #509f0c" target="_top" >Buscar Estudiantes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/ventRegistrarEstudiante">Agregar Estudiante</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Buscar Alumnos</div>
        <div class="panel-body">
            <form name="form" action="{{url('AlumnosBuscados')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option>Dni</option>
                                <option>Apellidos</option>
                                <option>Codigo alumno</option>
                                <option>Codigo Matricula</option>
                                <option>Fecha de Matricula</option>
                                <option>Escuela</option>
                                <option>Facultad</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        @if(isset($txt))
                            <input type="text" name="text" class="form-control" value="{{$txt}}">
                        @else
                            <input type="text" name="text" class="form-control" placeholder="Ingresa datos aqui .."
                                   autocomplete="off">
                        @endif
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert">El alumno {{$nombre}} fue actualizada!!</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active">
                        <th>
                            <div align="center">Dni</div>
                        </th>
                        <th>
                            <div align="center">Nombres y apellidos</div>
                        </th>
                        <th>
                            <div align="center">Codigo alumno</div>
                        </th>
                        <th>
                            <div align="center">Codigo matricula</div>
                        </th>
                        <th>
                            <div align="center">Fecha de matricula</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($alumno))
                        <!--Contenido-->
                        @foreach($alumno as $a)
                            <tr>
                                <td>{{$a->dni}}</td>
                                <td>{{$a->nombres}} {{$a->apellidos}}</td>
                                <td>{{$a->codAlumno}}</td>
                                <td>{{$a->codMatricula}}</td>
                                <td>{{$a->fecha}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="AlumnoCargar/{{$a->codPersona}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    <a href="AlumnoEliminar/{{$a->codPersona}}"><span
                                                class="glyphicon glyphicon-trash"></span> </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </body>
                </table>
            </div>
            <div class="col-sm-12 row">
                <div class="col-sm-4"></div>
                <!--paginadro-->
                <div class="col-sm-4" align="center">
                    <ul class="pagination  pagination-sm">
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                    </ul>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
@stop