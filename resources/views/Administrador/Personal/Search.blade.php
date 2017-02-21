@extends('Administrador/Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarPersonal" style="color: #509f0c" target="_top">Buscar Personal</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarPersonal">Agregar Personal</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Buscar personal</div>
        <div class="panel-body">
            <form name="form" action="{{url('PersonalBuscado')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                            <div class="col-sm-7 ">
                                <select class=" form-control" name="select">
                                    <option selected>Todo</option>
                                    <option>Dni</option>
                                    <option>Apellidos</option>
                                    <option>Codigo personal</option>
                                    <option>Cuenta</option>
                                    <option>Tipo de cuenta</option>
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
                            <div align="center">Codigo personal</div>
                        </th>
                        <th>
                            <div align="center">Cuenta</div>
                        </th>
                        <th>
                            <div align="center">Contraseña</div>
                        </th>
                        <th>
                            <div align="center">Tipo cuenta</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($personal))
                            <!--Contenido-->
                    @foreach($personal as $p)
                        <tr>
                            <td>{{$p->dni}}</td>
                            <td>{{$p->nombres}} {{$p->apellidos}}</td>
                            <td>{{$p->codPersonal}}</td>
                            <td>{{$p->cuenta}}</td>
                            <td>{{$p->password}}</td>
                            <td>{{$p->tipoCuenta}}</td>
                            <td align="center">
                                {{ csrf_field() }}
                                <a href="PersonalCargar/{{$p->idPersona}}"><span
                                            class="glyphicon glyphicon-pencil"></span> </a>
                                <a href="PersonalEliminar/{{$p->idPersona}}"><span
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