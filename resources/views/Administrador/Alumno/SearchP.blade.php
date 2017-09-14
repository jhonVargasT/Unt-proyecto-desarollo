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
                        <a href="/admBuscarEstudianteProduccion" style="color: #509f0c" target="_top">Buscar Estudiantes
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

    <div class="panel-heading"><h3>Buscar Alumnos Produccion</h3></div>
    <div style="background-color: #FFFFFF">

        <div class="panel-body">
            <div class="col-sm-12">
            <form name="form" action="{{url('AlumnosBuscadosP')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class=" row ">
                    <div class="form-group-sm col-sm-2 ">
                        <span class="ontrol-label">Buscar por:</span>
                        <select class=" form-control" name="select" id="select" onclick="activarBusqueda('select','text','buscar');">
                            <option>Todo</option>
                            <option>Dni</option>
                            <option>Apellidos</option>
                            <option>Codigo alumno</option>
                            <option>Centro produccion</option>
                        </select>
                    </div>
                    <div class="form-group-sm col-sm-8">
                        <ref></ref>
                        <span class="ontrol-label"> Ingresa datos aqui</span>

                            <span class="input-group-btn">
                            <input type="text" disabled name="text" class="form-control"
                                   autocomplete="off" id="text">
                                </span>

                        <span class="input-group-btn"  onmouseover="buscarSearch('text','select','buscar')">
                            <button class="btn btn-sm" type="submit"  id="buscar" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            </div>

            <!--tabla-->

            <div class="table-responsive  col-sm-12 ">
                <br>
                <br>
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">Dni</div>
                        </th>
                        <th>
                            <div align="center">Nombres y apellidos</div>
                        </th>
                        <th>
                            <div align="center">Correo</div>
                        </th>
                        <th>
                            <div align="center">Codigo alumno</div>
                        </th>
                        <th>
                            <div align="center">Fecha de matricula</div>
                        </th>
                        <th>
                            <div align="center">Centro de Produccion</div>
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
                                <td>{{$a->correo}}</td>
                                <td>{{$a->codAlumno}}</td>
                                <td align="center">{{$a->fecha}}</td>
                                <td>{{$a->nombre}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a title="Editar" href="AlumnoCargarP/{{$a->codPersona}}/{{$a->codProduccion}}"><span
                                               style="color: green;" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;
                                    <a title="Eliminar" href="" onclick="eliminar(event,'AlumnoEliminarP/{{$a->codPersona}}')"><span
                                               style="color: red" class="glyphicon glyphicon-trash"></span> </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </body>
                </table>
            </div>
        </div>
    </div>
@stop