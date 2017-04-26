@extends('Administrador.Body')
@section('escuela')
    <div id="collapseThree" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEscuela" style="color: #509f0c" target="_top">Buscar Escuelas</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEscuela">Agregar Escuela</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    @if(session()->has('true'))
        <div class="alert alert-success" role="alert">{{session('true')}} </div>
    @endif
    @if(session()->has('false'))
        <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
    @endif
    <div class="panel-heading"><h3>Buscar Escuelas</h3></div>
    <div style="background-color: #FFFFFF">

        <div class="panel-body">
            <form name="form" action="{{url('EscuelasBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select" id="select">
                                <option>Todo</option>
                                <option value="Facultad">Facultad</option>
                                <option>Codigo Escuela</option>
                                <option>Nombre Escuela</option>
                                <option>Cuenta Interna</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        @if(isset($txt))
                            <input type="text" name="text" class="form-control" value="{{$txt}}">
                        @else
                            <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                   name="text" id="text">
                            <script>
                                var path = "{{ route('autocompletee') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        return $.get(path, {query: query}, function (data) {
                                            var value = $('#select option:selected').attr('value');
                                            if (value == 'Facultad') {
                                                return process(data);
                                            }
                                        });
                                    }
                                });
                            </script>
                        @endif
                        <span class="input-group-btn">
                            <button class="btn btn-sm" type="submit" name="buscar">Buscar</button>
                        </span>
                    </div>
                </div>
                <!--tabla-->
                <div class="table-responsive col-sm-12">
                    @if(isset($nombre)!=null)
                        <div class="alert alert-success" role="alert">La escuela {{$nombre}} fue actualizada!!</div>
                    @endif
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <!--cabecear Tabla-->
                        <tr >
                            <th>Sede</th>
                            <th>Nombre Escuela</th>
                            <th>Codigo Escuela</th>
                            <th>Cuenta interna</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <body>
                        @if(isset($escuela))
                                <!--Contenido-->
                        @foreach($escuela as $es)
                            <tr>
                                <td>{{$es->nombresede}}</td>
                                <td>{{$es->nombre}}</td>
                                <td>{{$es->codEscuela}}</td>
                                <td>{{$es->nroCuenta}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="EscuelaCargar/{{$es->idEscuela}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="EscuelaEliminar/{{$es->idEscuela}}"><span
                                                class="glyphicon glyphicon-trash"></span> </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </body>
                    </table>
                </div>

            </form>
        </div>
    </div>
@stop