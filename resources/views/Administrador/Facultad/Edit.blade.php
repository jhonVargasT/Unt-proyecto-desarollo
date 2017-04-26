@extends('Administrador/Body')
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
                    <form name="form" action="{{ url('FacultadEditada/' .$f->idFacultad ) }}" role="form" method="get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Sede </span>
                                <div class="col-sm-4">
                                    <div class="input-group col-sm-12">
                                        <input class="typeahead form-control" type="text" placeholder="ejmp : Trujillo"
                                               name="nombreSede"
                                               autocomplete="off" required onkeypress="return validarLetras(event)"
                                               value="{{$f->nombresede}}">
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
                                <span class="col-sm-2 control-label"> Codigo Facultad</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="CodigoFacultad" type="text"
                                           autocomplete="off" placeholder="ejmp: 0002548"
                                           required value="{{$f->codFacultad}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Cuenta Interna</span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="CuentaInterna" type="text"
                                           autocomplete="off" placeholder="ejmp: 0002548"
                                           onkeypress="return validarCodigoSiaf(event)" required
                                           value="{{$f->nroCuenta}}">
                                </div>
                            </div>
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label">Nombre Facultad </span>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" name="NombreFacultad" type="text"
                                           autocomplete="off"
                                           onkeypress="return validarLetras(event)" placeholder="ejmp: Ingenieria"
                                           required value="{{$f->nombre}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-5">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="col-md-3"></div>
                            <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-2">
                            </div>
                            <div>
                                <button type="submit" name="enviar" class="col-md-2 btn btn-sm btn-success"><span
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