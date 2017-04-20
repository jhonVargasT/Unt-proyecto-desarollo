@extends('Reportes/Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/repBuscarPersonal" style="color: #509f0c" target="_top">Buscar Personal</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"> <h3>Buscar personal</h3></div>
    <div  style="background-color: #FFFFFF" >
        @if(session()->has('true'))
            <div class="alert alert-success" role="alert">{{session('true')}} </div>
        @endif
        @if(session()->has('false'))
            <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
        @endif
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
                    <div class="alert alert-success" role="alert">El personal {{$nombre}} fue actualizada!!</div>
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