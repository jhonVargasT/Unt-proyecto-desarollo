@extends('Administrador.Body')
@section('facultad')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarFacultad">Buscar Facultades</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarFacultad" style="color: #509f0c" target="_top">Agregar Facultad</a>
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
    <div class="panel-heading"><h3>Agregar facultad</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <form name="form"
                  onsubmit="activarbotonform(event,['spansede','spancodigofacultad','spannombre'],'enviar','mensaje')"
                  action="{{url('FacultadRegistrada')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Sede</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Sede</span>
                                    <input class="typeahead form-control input-sm" name="sede" type="text"
                                           autocomplete="off" onchange="validarNombre('sede','spansede')"
                                           required id="sede">
                                    <span style="color: red" class=" control-label" id="spansede"> </span>
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
                                    <input class="form-control input-sm" name="CodigoFacultad" id="CodigoFacultad"
                                           type="text"
                                           autocomplete="off"
                                           onchange="validarNumeros('CodigoFacultad','spancodigofacultad')"
                                           required>
                                    <span style="color: red" class=" control-label" id="spancodigofacultad"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Cuenta interna</span>
                                    <input class="form-control input-sm" name="CuentaInterna" id="CuentaInterna"
                                           type="text"
                                           autocomplete="off" onchange="validarNumeros('CuentaInterna','spancuenta')">
                                    <span style="color: red" class=" control-label" id="spancuenta"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Nombre Facultad</span>
                                    <input class="form-control input-sm" name="NombreFacultad" id="NombreFacultad"
                                           type="text"
                                           autocomplete="off" onchange="validarNombre('NombreFacultad','spannombre')"
                                           required>
                                    <span style="color: red" class=" control-label" id="spannombre"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group" align="center">
                    <span id="mensaje" class="control-label" style="color: red"></span>
                </div>
                <div class="col-sm-12 row form-group" align="center">

                    <a href="{{url('/Adm')}}" class="  btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Regresar
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" id="enviar"
                            onmouseover="activarbotonform(null,['spansede','spancodigofacultad','spannombre'],'enviar','mensaje')"
                            name="enviar" class="btn btn-sm btn-success"><span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>


                </div>
            </form>
        </div>
    </div>
@stop