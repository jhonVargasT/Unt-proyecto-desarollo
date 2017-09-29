@extends('Administrador.LayoutAdm')
@section('body')
    <div class="panel-heading"><h3>Editar Facultad</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($facultad)
                @foreach($facultad as $f)
                    <form name="form"
                          onsubmit="activarbotonform(event,['spansede','spancodigofacultad','spancuenta','spannombre'],'enviar','mensaje')"
                          action="{{ url('FacultadEditada/' .$f->idFacultad ) }}" role="form" method="GET"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Sede</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Sede</span>
                                            <input class="typeahead form-control input-sm" name="sede" type="text"
                                                   autocomplete="off" onchange="validarNombre('sede','spansede')"
                                                   required id="sede" value="{{$f->nombresede}}">
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
                                </div>
                            </div>
                        </div>
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Facultad</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Codigo Facultad</span>
                                            <input class="form-control input-sm" name="CodigoFacultad"
                                                   id="CodigoFacultad"
                                                   type="text" value="{{$f->codFacultad}}" autocomplete="off"
                                                   onchange="validarNumeros('CodigoFacultad','spancodigofacultad')"
                                                   required>
                                            <span style="color: red" class=" control-label"
                                                  id="spancodigofacultad"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Cuenta interna</span>
                                            <input class="form-control input-sm" name="CuentaInterna" id="CuentaInterna"
                                                   type="text" value="{{$f->nroCuenta}}"
                                                   autocomplete="off"
                                                   onchange="validarNumeros('CuentaInterna','spancuenta')">
                                            <span style="color: red" class=" control-label" id="spancuenta"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Nombre Facultad</span>
                                            <input class="form-control input-sm" name="NombreFacultad"
                                                   id="NombreFacultad" value="{{$f->nombre}}"
                                                   type="text"
                                                   autocomplete="off"
                                                   onchange="validarNombre('NombreFacultad','spannombre')"
                                                   required>
                                            <span style="color: red" class=" control-label" id="spannombre"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="col-md-3"></div>
                            <a href="{{url('/admBuscarFacultad')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-2">
                            </div>
                            <div>
                                <button type="submit" id="enviar"
                                        onmouseover="activarbotonform(null,['spansede','spancodigofacultad','spancuenta','spannombre'],'enviar','mensaje')"
                                        name="enviar" class="col-md-2 btn btn-sm btn-success"><span
                                            class="glyphicon glyphicon-ok"></span> Guardar
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
@stop