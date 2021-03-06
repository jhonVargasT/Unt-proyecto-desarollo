@extends('Administrador/Body')
@section('subtramite')
    <div id="collapseSix" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSubtramite" style="color: #509f0c" target="_top" autocomplete="off">Buscar
                            Tasa</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSubtramite">Agregar Tasa</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel-heading"><h3>Buscar SubTasa</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" action="{{url('SubtramitesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select" id="select"
                                    onclick="activarBusqueda('select','text','buscar');">
                                <option>Todo</option>
                                <option value="Nombre Clasificador">Nombre Clasificador</option>
                                <option>Nombre Tasa</option>
                                <option>Codigo Tasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-sm input-group col-sm-6">
                        @if(isset($txt))
                            <input name="text" class="form-control" value="{{$txt}}" id="text" required>
                        @else
                            <input class="typeahead form-control" placeholder="Ingresa datos aqui .."
                                   name="text" id="text" required disabled>
                            <script>
                                var path = "{{ route('autocompletet') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        return $.get(path, {query: query}, function (data) {
                                            var value = $('#select option:selected').attr('value');
                                            if (value === 'Nombre Clasificador') {
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
                            <div align="center">Nombre clasificador</div>
                        </th>
                        <th>
                            <div align="center">Nombre tasa</div>
                        </th>
                        <th>
                            <div align="center">Unidad operativa</div>
                        </th>
                        <th>
                            <div align="center">Codigo tasa</div>
                        </th>
                        <th>
                            <div align="center">Precio</div>
                        </th>
                        <th>
                            <div align="center">Opciones</div>
                        </th>
                    </tr>
                    </thead>
                    <body>
                    @if(isset($subtramite))
                        <!--Contenido-->
                        @foreach($subtramite as $s)
                            <tr>
                                <td>{{$s->fnombre}}</td>
                                <td>{{$s->tnombre}}</td>
                                <td>{{$s->unidadOperativa}}</td>
                                <td>{{$s->codigoSubtramite}}</td>
                                <td>{{$s->precio}}</td>
                                <td align="center">
                                    {{ csrf_field() }}
                                    <a href="SubtramiteCargar/{{$s->codSubtramite}}" title="Editar"><span
                                                style="color:green" class="glyphicon glyphicon-pencil"></span> </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="eliminar(event,'SubtramiteEliminar/{{$s->codSubtramite}}')"
                                       title="Eliminar"
                                       href=""><span class="glyphicon glyphicon-trash" style="color: red;"></span></a>
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