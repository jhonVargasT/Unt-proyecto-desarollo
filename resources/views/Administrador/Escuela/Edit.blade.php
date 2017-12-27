@extends('Administrador.LayoutAdm')
@section('body')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class=" panel-heading"><h3> Agregar Escuela</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($escuela)
                @foreach($escuela as $e)
                    <form name="form"
                          onsubmit="activarbotonform(event,['spansede','spanfacultad','spancodigoescuela','spanescuela'],'enviar','mensaje')"
                          action="{{ url('EscuelaEditada/'.$e->idEscuela)}}" role="form" method="get"
                          class="Horizontal">
                        {{csrf_field()}}
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Sede y Facultad</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Sede</span>
                                            <input class="typeahead form-control input-sm" name="nombreSede" type="text"
                                                   autocomplete="off" onchange="validarNombre('ns','spansede')"
                                                   required id="ns" value="{{$e->nombresede}}">
                                            <span style="color: red" class=" control-label" id="spansede"></span>
                                        </div>
                                        <script type="text/javascript">
                                            var path = "{{ route('autocompletesede') }}";
                                            $('input.typeahead').typeahead({
                                                source: function (query, process) {
                                                    return $.get(path, {query: query}, function (data) {
                                                        return process(data);
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Facultad</span>
                                            <input class="facultad form-control input-sm" type="text"
                                                   placeholder="ejmp : Ingenieria"
                                                   onchange="validarNombre('fa','spanfacultad')"
                                                   name="nombreFacultad" id="fa" autocomplete="off" required
                                                   value="{{$e->fnombre}}">
                                            <span style="color: red" class=" control-label" id="spanfacultad"></span>
                                            <script>
                                                src = "{{ route('searchsedeescuela') }}";
                                                $("#fa").autocomplete({
                                                    source: function (request, response) {
                                                        $.ajax({
                                                            url: src,
                                                            type: 'get',
                                                            dataType: "json",
                                                            data: {
                                                                term: $('#fa').val(),
                                                                sede: $('#ns').val()
                                                            },
                                                            success: function (data) {
                                                                response(data);
                                                            }
                                                        });
                                                    },
                                                    min_length: 1
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Escuela</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Codigo Escuela</span>
                                            <input class="form-control input-sm" name="codEscuela" id="codEscuela"
                                                   type="text"
                                                   autocomplete="off"
                                                   onchange="validarNumeros('codEscuela','spancodigoescuela')"
                                                   required value="{{$e->codEscuela}}">
                                            <span style="color: red" class=" control-label"
                                                  id="spancodigoescuela"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Nombre Escuela</span>
                                            <input class="form-control input-sm" name="nombre" id="nombre"
                                                   type="text" value="{{$e->nombre}}"
                                                   autocomplete="off" onchange="validarNombre('nombre','spanescuela')"
                                                   required>
                                            <span style="color: red" class=" control-label" id="spanescuela"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Cuenta Interna</span>
                                            <input class="form-control input-sm" name="nroCuenta" id="nroCuenta"
                                                   type="text" value="{{$e->nroCuenta}}"
                                                   autocomplete="off"
                                                   onchange="validarNumeros('nroCuenta','spancuenta')">
                                            <span style="color: red" class=" control-label" id="spancuenta"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">

                            <a href="{{url('/admBuscarEscuela')}}" class=" btn-sm btn  btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Cancelar</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" id="enviar"
                                    onmouseover="activarbotonform(null,['spansede','spanfacultad','spancodigoescuela','spanescuela'],'enviar','mensaje')"
                                    name="enviar" class=" btn btn-sm btn-success"><span
                                        class="glyphicon glyphicon-ok"></span> Guardar
                            </button>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
@stop