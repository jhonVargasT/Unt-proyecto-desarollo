@extends('Administrador/Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite" style="color: #509f0c" target="_top">Buscar Clasificador</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite">Agregar Clasificador</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Buscar clasificador</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('TramitesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option selected=""> Todo</option>
                                <option>Codigo clasificador</option>
                                <option>Tipo de recurso</option>
                                <option>Nombre de clasificador</option>
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
                    <div class="alert alert-success" role="alert">La tasa {{$nombre}} fue actualizada!!</div>
                @endif

                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">Codigo clasificador</div>
                        </th>
                        <th>
                            <div align="center">Nombre de clasificador</div>
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
                                    <a href="TramiteCargar/{{$t->codTramite}}" title="Editar"><span
                                                style="color:green" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'TramiteEliminar/{{$t->codTramite}}')" title="Eliminar"
                                       href=""><span class="glyphicon glyphicon-trash" style="color: red;"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </body>
                </table>
                @endif
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