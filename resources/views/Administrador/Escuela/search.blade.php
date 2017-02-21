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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <div class="panel panel-primary">
        <div class="panel-heading"> Buscar Escuelas</div>
        <div class="panel-body">
            <form name="form" action="{{url('EscuelasBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select" id="select">
                                <option value="Facultad" selected>Facultad</option>
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
                                   name="text" id="text" required>
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
                    <table class="table table-bordered">
                        <thead>
                        <!--cabecear Tabla-->
                        <tr class="active">
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
                                <td>{{$es->nombre}}</td>
                                <td>{{$es->codEscuela}}</td>
                                <td>{{$es->nroCuenta}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="EscuelaCargar/{{$es->idEscuela}}"><span
                                                class="glyphicon glyphicon-pencil"></span> </a>
                                    <a href="EscuelaEliminar/{{$es->idEscuela}}"><span
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
            </form>
        </div>
    </div>
@stop