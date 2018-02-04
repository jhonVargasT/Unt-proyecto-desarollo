@extends('Administrador.Body')
@section('produccion')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarProduccion" style="color: #509f0c" target="_top">Buscar Centro de
                            Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarProduccion">Agregar Centro de
                            Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarProduccionPagos">Agregar Produccion pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Buscar Centros de Produccion</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('ProduccionBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class=" row ">
                    <div class="form-group-sm col-sm-2 ">
                        <span class="ontrol-label">Buscar por:</span>
                        <select class=" form-control" name="select" id="select"
                                onclick="activarBusqueda('select','text','buscar');">
                            <option selected>Todo</option>
                            <option>Nombre</option>
                            <option>Direccion</option>
                        </select>
                    </div>
                    <div class="form-group-sm col-sm-8">
                        <ref></ref>
                        <span class="ontrol-label"> Ingresa datos aqui</span></ref>
                        @if(isset($txt))
                            <span class="input-group-btn">
                            <input type="text" name="text" id="text" class="form-control" value="{{$txt}}" required>
                                </span>
                        @else
                            <span class="input-group-btn">
                            <input type="text" name="text" class="form-control" id="text" autocomplete="off" required
                                   disabled>
                                </span>
                        @endif
                        <span class="input-group-btn" onmouseover="buscarSearch('text','select','buscar')">
                            <button class="btn btn-sm" type="submit" name="buscar" id="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <br>
            <div class="table-responsive  col-sm-12 ">
                @if(isset($nombre)!=null)
                    <div class="alert alert-success" role="alert"> El alumno {{$nombre}} fue actualizada!!</div>
                @endif
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">Nombre</div>
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
                    @if(isset($produccion))
                        <!--Contenido-->
                        @foreach($produccion as $p)
                            <tr>
                                <td>{{$p->nombre}}</td>
                                <td>{{$p->direccion}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="ProduccionCargar/{{$p->codProduccion}}"><span
                                                class="glyphicon glyphicon-pencil" style="color: green;"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'ProduccionEliminar/{{$p->codProduccion}}/{{$p->codPersona}}/{{$p->idAlumno}}/{{$p->codProduccionAlumno}}')"
                                       title="Eliminar"
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