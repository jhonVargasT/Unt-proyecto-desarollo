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
    @if(session()->has('true'))
        <div class="alert alert-success" role="alert">{{session('true')}} </div>
    @endif
    @if(session()->has('false'))
        <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
    @endif
    <div class="panel-heading"><h3> Buscar Facultades</h3></div>
    <div  style="background-color: #FFFFFF" >

        <div class="panel-body">
            <form name="form" action="{{url('FacultadesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">}
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
                            <input type="text" name="text" class="form-control" value="{{$txt}}" autocomplete="off">
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
                    <div class="alert alert-success" role="alert">La facultad {{$nombre}} fue actualizada!!</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active">
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
                                    {{ csrf_field() }}
                                    <a href="FacultadCargar/{{$f->idFacultad}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="FacultadEliminar/{{$f->idFacultad}}"><span
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