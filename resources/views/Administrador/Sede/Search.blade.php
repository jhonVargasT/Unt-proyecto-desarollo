@extends('Administrador/Body')
@section('sede')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSede " style="color: #509f0c">Buscar Sedes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSede" target="_top">Agregar Sede</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"> <h3>Buscar Sedes</h3></div>
    <div style="background-color: #FFFFFF" >
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('SedesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option selected>Todo</option>
                                <option>Nombre Sede</option>
                                <option>Codigo Sede</option>
                                <option>Direccion</option>
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
                    <div class="alert alert-success" role="alert">La sede {{$nombre}} fue actualizada!!</div>
                @endif
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr >
                        <th>
                            <div align="center">Codigo Sede</div>
                        </th>
                        <th>
                            <div align="center">Nombre Sede</div>
                        </th>
                        <th>
                            <div align="center">Direccion</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($sede))
                        <!--Contenido-->
                        @foreach($sede as $s)
                            <tr>
                                <td>{{$s->codigosede}}</td>
                                <td>{{$s->nombresede}}</td>
                                <td>{{$s->direccion}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="SedeCargar/{{$s->codSede}}" title="Editar"><span
                                                style="color:green" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'SedeEliminar/{{$s->codSede}}')" title="Eliminar" href=""><span
                                                class="glyphicon glyphicon-trash" style="color: red;"></span> </a>
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