@extends('Reportes/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/repBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y transferencias</a>
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel-heading"><h3> Buscar Donaciones y
        transferencias</h3></div>
    <div style="background-color: #FFFFFF" >

        <div class="panel-body">
            <form name="form" action="{{url('DonacionesBuscadas')}}" role="form" method="POST" class="Vertical">
                {{ csrf_field() }}
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm col-sm-6 ">
                        <span class="col-sm-5 control-label">Buscar por:</span>
                        <div class="col-sm-7 ">
                            <select class=" form-control" name="select" id="select">
                                <option>Todo</option>
                                <option value="Tramite">Tramite</option>
                                <option>Fecha</option>
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
                            <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                   name="text" id="text" >
                            <script>
                                var path = "{{ route('autocompletet') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        return $.get(path, {query: query}, function (data) {
                                            var value = $('#select option:selected').attr('value');
                                            if (value == 'Tramite') {
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