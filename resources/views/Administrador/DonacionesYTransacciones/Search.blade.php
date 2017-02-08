@extends('Administrador/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y transferencias</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones">Agregar Donaciones y transaferencias</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Buscar Donaciones y
            transferencias</div>
        <div class="panel-body">
            <form name="form" action="{{url('DonacionesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option>Fecha</option>
                                <option>Codigo siaf</option>
                                <option>Tipo de recurso</option>
                                <option>Fuente de financiamiento</option>
                                <option>Numero Resolucion</option>
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
                    <div class="alert alert-success" role="alert">El tramite {{$nombre}} fue actualizada!!</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active">
                        <th>
                            <div align="center">Numero Resolucion</div>
                        </th>
                        <th>
                            <div align="center">Codigo siaf</div>
                        </th>
                        <th>
                            <div align="center">Tipo de Recurso</div>
                        </th>
                        <th>
                            <div align="center">Fuente de Financiamiento</div>
                        </th>
                        <th>
                            <div align="center">Fecha</div>
                        </th>
                        <th>
                            <div align="center">Monto</div>
                        </th>
                        <th>
                            <div align="center">Descripcion</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($donacion))
                        <!--Contenido-->
                        @foreach($donacion as $d)
                            <tr>
                                <td>{{$d->numResolucion}}</td>
                                <td>{{$d->clasificador}}</td>
                                <td>{{$d->tipoRecurso}}</td>
                                <td>{{$d->fuentefinanc}}</td>
                                <td>{{$d->fechaIngreso}}</td>
                                <td>{{$d->monto}}</td>
                                <td>{{$d->descripcion}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="DonacionCargar/{{$d->codDonacion}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    <a href="DonacionEliminar/{{$d->codDonacion}}"><span
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
        </div>
    </div>
@stop