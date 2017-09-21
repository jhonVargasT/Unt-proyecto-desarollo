@extends('Administrador/Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite" style="color: #509f0c" target="_top">Buscar Clasificador</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite">Agregar Clasificador</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Editar clasificador </h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($tramite)
                @foreach($tramite as $t)
                    <form name="form"
                          onsubmit="activarbotonform(event,['spanclasificador','spannombre'],'enviar','mensaje')"
                          action="{{ url('TramiteEditada/' .$t->codTramite ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Clasificador</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> SIAF </span>
                                            <input class="form-control input-sm" name="clasificador" id="clasificador"
                                                   type="text" value="{{$t->clasificador}}"
                                                   autocomplete="off" required
                                                   onchange="validarNumeros('clasificador','spanclasificador')">
                                            <span class=" control-label" style="color:red"
                                                  id="spanclasificador">  </span>
                                        </div>
                                    </div>
                                    <div class=" form-group-sm" align="left">

                                        <div class="col-sm-2">
                                            <span class=" control-label">Nombre de clasificador</span>
                                            <input class="form-control" name="nombre" id="nombre" type="text"
                                                   autocomplete="off" value="{{$t->nombre}}"
                                                   onchange="validarNombre('nombre','spannombre')" required>
                                            <span class=" control-label" style="color:red" id="spannombre"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">

                                        <div class="col-sm-3">
                                            <span class="control-label"> Tipo de recurso</span>
                                            <input class=" form-control input-sm" name="tipoRecurso" type="text"
                                                   autocomplete="off" placeholder="A" id="tipoRecurso"
                                                   value="{{$t->tipoRecurso}}"
                                                   onchange="validarNombre('tipoRecurso','spantiporecurso')">
                                            <span class=" control-label" style="color:red" id="spantiporecurso"></span>
                                        </div>
                                    </div>
                                    <div class=" form-group-sm" align="left">
                                        <div class="col-sm-2">
                                            <span class=" control-label"> Fuente de financiamieto</span>
                                            <input class="form-control" name="fuentefinanc" type="text"
                                                   autocomplete="off" placeholder="1" id="fuentefinac"
                                                   value="{{$t->fuentefinanc}}"
                                                   onchange="validarNumeros('fuentefinac','spanfuente')">
                                            <span class=" control-label" style="color:red" id="spanfuente"></span>
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
                            <a href="{{url('/admBuscarTramite')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-2">
                            </div>
                            <div>
                                <button type="submit" name="enviar"
                                        onmouseover="activarbotonform(null,['spanclasificador','spannombre'],'enviar','mensaje')"
                                        class="col-md-2 btn btn-sm btn-success"><span
                                            class="glyphicon glyphicon-ok"></span> Guardar
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </form>
        </div>
        @endforeach
        @endif
    </div>
@stop