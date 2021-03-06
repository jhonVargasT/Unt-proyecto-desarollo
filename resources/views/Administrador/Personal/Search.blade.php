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
    <div class="panel-heading"><h3>Buscar personal</h3></div>
    <div style="background-color: #FFFFFF">
        @if(session()->has('true'))
            <div class="alert alert-success" role="alert">{{session('true')}} </div>
        @endif
        @if(session()->has('false'))
            <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
        @endif
        <div class="panel-body">
            <form name="form" action="{{url('PersonalBuscado')}}" role="Form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select"  id="select" onclick="activarBusqueda('select','text','buscar');">
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
                        <input name="text" class="form-control" id="text" value="@yield('buscar')" disabled required>
                        <span class="input-group-btn">
                            <button class="btn btn-sm" name="buscar" id="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert">El personal {{$nombre}} fue actualizada!!</div>
                @endif

                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
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
                                <td>{{$p->correo}}</td>
                                <td>{{$p->codPersonal}}</td>
                                <td>{{$p->cuenta}}</td>
                                <td>{{$p->password}}</td>
                                <td>{{$p->tipoCuenta}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a title="editar" href="PersonalCargar/{{$p->idPersona}}" title="editar"><span
                                                style="color:green" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'PersonalEliminar/{{$p->idPersona}}')" title="Eliminar"
                                       href=""><span
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