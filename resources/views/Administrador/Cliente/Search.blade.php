@extends('Administrador.Body')
@section('cliente')
    <div id="collapseClie" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarCliente" style="color: #509f0c" target="_top">Buscar Clientes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarCliente">Agregar Clientes</a>
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
    <div class="panel-heading"><h3> Buscar Clientes</h3></div>
    <div style="background-color: #FFFFFF" >
        <div class="panel-body">
            <form name="form" action="{{url('ClientesBuscados')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option>Dni</option>
                                <option>Apellidos</option>
                                <option>Ruc</option>
                                <option>Razon social</option>
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
                    <div class="alert alert-success" role="alert">El cliente {{$nombre}} fue actualizada!!</div>
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
                            <div align="center">Ruc</div>
                        </th>
                        <th>
                            <div align="center">Razon Social</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($cliente))
                        <!--Contenido-->
                        @foreach($cliente as $c)
                            <tr>
                                <td>{{$c->dni}}</td>
                                <td>{{$c->nombres}} {{$c->apellidos}}</td>
                                <td>{{$c->ruc}}</td>
                                <td>{{$c->razonSocial}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="ClienteCargar/{{$c->codPersona}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    <a href="ClienteEliminar/{{$c->codPersona}}"><span
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

                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
@stop