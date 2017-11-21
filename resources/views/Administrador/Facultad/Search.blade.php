@extends('Administrador/Body')
@section('facultad')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarFacultad " style="color: #509f0c">Buscar Facultades</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarFacultad" target="_top">Agregar Facultad</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3> Buscar Facultades</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('FacultadesBuscadas')}}" role="Form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select" id="select"
                                    onclick="activarBusqueda('select','text','buscar');">
                                <option selected>Todo</option>
                                <option>Codigo Facultad</option>
                                <option>Cuenta Interna</option>
                                <option>Nombre Facultad</option>
                                <option>Sede</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        @if(isset($txt))
                            <input name="text" class="form-control" value="{{$txt}}" autocomplete="off" id="text"
                                   required>
                        @else
                            <input name="text" class="form-control" placeholder="Ingresa datos aqui .."
                                   autocomplete="off" id="text" disabled required>
                        @endif
                        <span class="input-group-btn">
                            <button class="btn btn-sm" name="buscar" id="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert">La facultad {{$nombre}} fue actualizada!!</div>
                @endif
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">Sede</div>
                        </th>
                        <th>
                            <div align="center">Codigo facultad</div>
                        </th>
                        <th>
                            <div align="center">Nombre Facultad</div>
                        </th>
                        <th>
                            <div align="center">Cuenta Interna</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($facultad))
                        <!--Contenido-->
                        @foreach($facultad as $f)
                            <tr>
                                <td>{{$f->nombresede}}</td>
                                <td>{{$f->codFacultad}}</td>
                                <td>{{$f->nombre}}</td>
                                <td>{{$f->nroCuenta}}</td>
                                <td align="center">
                                    {{ csrf_field()}}
                                    <a href="FacultadCargar/{{$f->idFacultad}}" title="Editar"><span
                                                style="color:green" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'FacultadEliminar/{{$f->idFacultad}}')" title="Eliminar"
                                       href=""><span class="glyphicon glyphicon-trash" style="color: red;"></span></a>
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