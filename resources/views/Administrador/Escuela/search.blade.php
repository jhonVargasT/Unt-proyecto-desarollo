@extends('Administrador.Body')
@section('escuela')
    <div id="collapseThree" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEscuela" style="color: #509f0c" target="_top">Buscar Escuelas</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEscuela">Agregar Escuela</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">  Buscar Escuelas  </div>
        <div class="panel-body">
            <form name="form" action="{{url('EscuelasBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option selected>Facultad</option>
                                <option>Codigo Escuela</option>
                                <option>Nombre Escuela</option>
                                <option>Cuenta Interna</option>
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
                            <button class="btn btn-sm" type="submit" name="buscar" autocomplete="off">Buscar</button>
                        </span>
                    </div>
                </div>
                <!--tabla-->
                <div class="table-responsive col-sm-12">
                    @if(isset($nombre)!=null)
                        <div class="alert alert-success" role="alert">La escuela {{$nombre}} fue actualizada!!</div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                        <!--cabecear Tabla-->
                        <tr>
                            <th>Codigo Escuela</th>
                            <th>Cuenta interna</th>
                            <th>Nombre Escuela</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <body>
                        @if(isset($escuela))
                            <!--Contenido-->
                            @foreach($escuela as $e)
                                <tr>
                                    <td>{{$e->codEscuela}}</td>
                                    <td>{{$e->nroCuenta}}</td>
                                    <td>{{$e->nombre}}</td>
                                    <td align="center">
                                        {{ csrf_field() }}
                                        <a href="EscuelaCargar/{{$e->idEscuela}}"><span
                                                    class="glyphicon glyphicon-pencil"></span> </a>
                                        <a href="EscuelaEliminar/{{$e->idEscuela}}"><span
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
            </form>
        </div>
    </div>
@stop