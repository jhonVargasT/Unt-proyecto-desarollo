@extends('Administrador.Body')
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
    <div class="panel panel-primary">
        <div class="panel-heading">
            Buscar Facultades
        </div>
        <div class="panel-body">
            <form name="form" action="{{url('FacultadesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select">
                                <option>Codigo facultad</option>
                                <option selected>Cuenta Interna</option>
                                <option>Nombre Facultad</option>
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
                    <div class="alert alert-success" role="alert">La facultad {{$nombre}} fue actualizada!!</div>
                @endif
                @if(isset($delete)==true)
                    <div class="alert alert-success" role="alert"> Facultad eliminada!!</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr class="active">
                        <th>
                            <div align="center">
                                <small><strong>Codigo facultad</strong></small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small><strong>Nombre Facultad</strong></small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small><strong>Cuenta Interna</strong></small>
                            </div>
                        </th>
                        <th>
                            <div align="center">
                                <small><strong>Opciones</strong></small>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($facultad))
                            <!--Contenido-->
                    @foreach($facultad as $f)
                        <tr>
                            <td>
                                <small>{{$f->codFacultad}}</small>
                            </td>
                            <td>
                                <small>{{$f->nombre}}</small>
                            </td>
                            <td>
                                <small>{{$f->nroCuenta}}</small>
                            </td>
                            <td align="center">
                                {{ csrf_field() }}
                                <a href="FacultadCargar/{{$f->idFacultad}}"><span
                                            class="glyphicon glyphicon-pencil"></span> </a>
                                <a href="FacultadEliminar/{{$f->idFacultad}}"><span
                                            class="glyphicon glyphicon-trash"></span> </a>

                            </td>
                        </tr>
                    @endforeach

                    </body>

                    @endif
                </table>
            </div>
            <div class="col-sm-12 row">


            </div>
        </div>
    </div>

@stop