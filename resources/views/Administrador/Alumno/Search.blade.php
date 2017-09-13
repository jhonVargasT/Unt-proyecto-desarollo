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
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEstudianteProduccion" >Buscar Estudiantes
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
                        <a href="/admRegistrarEstudianteProduccion" >Agregar Estudiante
                            Produccion</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

@stop
@section('content')
    @if(session()->has('true'))
        <div class="alert alert-success" role="alert">{{session('true')}} </div>
    @endif
    @if(session()->has('false'))
        <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
    @endif
    <div class="panel-heading"><h3>Buscar Alumnos</h3></div>
    <div style="background-color: #FFFFFF">

        <div class="panel-body">
            <form name="form" action="{{url('AlumnosBuscados')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}

                <div class=" row col-sm-12" >
                    <div class="form-group-sm col-sm-2 ">
                        <span class="ontrol-label">Buscar por:</span>
                        <select class=" form-control" name="select" id="select" onclick='activarBusqueda("select","text","buscar");'>
                            <option>Todo</option>
                            <option>Dni</option>
                            <option>Apellidos</option>
                            <option>Codigo alumno</option>
                            <option>Escuela</option>
                            <option>Facultad</option>
                        </select>
                    </div>
                    <div class="form-group-sm col-sm-8">
                        <ref></ref>
                        <span class="ontrol-label"> Ingresa datos aqui</span></ref>

                            <span class="input-group-btn">
                            <input type="text" name="text" disabled id="text" class="form-control"
                                   autocomplete="off" onkeypress='buscarSearch("text","select","buscar")'>
                                </span>

                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" onmouseover='buscarSearch("text","select","buscar")' id="buscar" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->

            <div class="table-responsive  col-sm-12 ">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert"> El alumno {{$nombre}} fue actualizada!!</div>
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
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <br>
                    <body>
                    @if(isset($alumno))
                        <!--Contenido-->
                        @foreach($alumno as $a)
                            <tr>
                                <td>{{$a->dni}}</td>
                                <td>{{$a->nombres}} {{$a->apellidos}}</td>
                                <td>{{$a->correo}}</td>
                                <td>{{$a->codAlumno}}</td>
                                <td>{{$a->fecha}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="AlumnoCargar/{{$a->codPersona}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="AlumnoEliminar/{{$a->codPersona}}"><span
                                                class="glyphicon glyphicon-trash"></span> </a>
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