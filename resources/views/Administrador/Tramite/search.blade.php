@extends('Administrador/Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite" style="color: #509f0c" target="_top">Buscar Tramites</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite">Agregar Tramite</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Buscar Tramites</div>
        <div class="panel-body">
            <form name="form" action="{{url('TramitesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option>Todo </option>
                                <option>Clasificador siaf</option>
                                <option>Tipo de recurso</option>
                                <option>Nombre de tramite</option>
                                <option>Fuente de financiamiento</option>
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
                            <div align="center">Clasificador Siaf</div>
                        </th>
                        <th>
                            <div align="center">Nombre de tramite</div>
                        </th>
                        <th>
                            <div align="center">Fuente de financiamiento</div>
                        </th>
                        <th>
                            <div align="center">Tipo de recurso</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($tramite))
                        <!--Contenido-->
                        @foreach($tramite as $t)
                            <tr>
                                <td>{{$t->clasificador}}</td>
                                <td>{{$t->nombre}}</td>
                                <td>{{$t->fuentefinanc}}</td>
                                <td>{{$t->tipoRecurso}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="TramiteCargar/{{$t->codTramite}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    <a href="TramiteEliminar/{{$t->codTramite}}"><span
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