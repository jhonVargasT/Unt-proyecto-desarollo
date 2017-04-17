@extends('Administrador/Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite" style="color: #509f0c" target="_top">Buscar Tasa</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite">Agregar Tasa</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"> <h3>Editar Tasa</h3></div>
    <div  style="background-color: #FFFFFF" >
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($tramite)
                @foreach($tramite as $t)
                    <form name="form" action="{{ url('TramiteEditada/' .$t->codTramite ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Clasificador SIAF</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="clasificadorSiaf" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)"
                                           value="{{$t->clasificador}}">
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Nombre tasa</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="nombreTramite" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)"
                                           value="{{$t->nombre}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label">Tipo de recurso </span>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm" name="tipoDeRecurso" type="text"
                                           autocomplete="off"
                                           onkeypress="return validarLetras(event)" value="{{$t->tipoRecurso}}">
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label">Fuente de financiamiento </span>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm" name="fuenteFinaciamiento" type="text"
                                           autocomplete="off"
                                           onkeypress="return validarNum(event)" value="{{$t->fuentefinanc}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="col-md-3"></div>
                            <a href="{{url('/Layout')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-2">
                            </div>
                            <div>
                                <button href="" type="submit" name="enviar"
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