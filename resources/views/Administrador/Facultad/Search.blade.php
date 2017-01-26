@extends('Administrador.Body')
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
                            <select class=" form-control" name="select" >
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
                            <input type="text" name="text" class="form-control" placeholder="Ingresa datos aqui ..">
                        @endif
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="table-responsive col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <!--cabecear Tabla-->
                    <tr>
                        <th>
                            <div align="center">Codigo facultad</div>
                        </th>
                        <th>
                            <div align="center">Nombre Facultad</div>
                        </th>
                        <th>
                            <div align="center">Cuenta Interna</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($facultad))
                            <!--Contenido-->
                    @foreach($facultad as $f)
                        <tr>
                            <td>{{$f->codFacultad}}</td>
                            <td>{{$f->nombre}}</td>
                            <td>{{$f->nroCuenta}}</td>
                            <td align="center">
                                {{ csrf_field() }}
                                <a href="FacultadCargar/{{$f->idFacultad}}" ><span class="glyphicon glyphicon-pencil"></span> </a>
                                <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
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