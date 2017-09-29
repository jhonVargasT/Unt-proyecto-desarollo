@extends('Administrador.LayoutAdm')
@section('body')
    <div class="panel-heading"><h3>Editar Sede</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($sede)
                @foreach($sede as $s)
                    <form name="form"
                          onsubmit="activarbotonform(event,['spansede'],'enviar','mensaje')"
                          action="{{ url('SedeEditada/' .$s->codSede ) }}" role="form" method="GET"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel  panel-primary">
                            <div class="panel-heading">Datos Sede</div>
                            <div class="panel-body">
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Sede</span>
                                            <input class="form-control input-sm" name="nombresede" id="sede"
                                                   type="text" autocomplete="off"
                                                   onchange="validarNombre('sede','spansede')"
                                                   required value="{{$s->nombresede}}">
                                            <span style="color: red" class=" control-label" id="spansede"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Codigo sede</span>
                                            <input class="form-control input-sm" name="codigosede" id="codigo"
                                                   type="text" autocomplete="off"
                                                   onchange="validarNumeros('codigo','spancodigosede')"
                                                   required value="{{$s->codigosede}}">
                                            <span style="color: red" class=" control-label" id="spancodigosede"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">
                                        <div class="col-sm-3">
                                            <span class=" control-label"> Direccion</span>
                                            <input class="form-control input-sm" name="direccion" id="direccion"
                                                   type="text"
                                                   autocomplete="off" value="{{$s->direccion}}">
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
                            <a href="{{url('/admBuscarSede')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            <div class="col-md-2">
                            </div>
                            <div>
                                <button type="submit" id="enviar"
                                        onmouseover="activarbotonform(null,['spansede'],'enviar','mensaje')"
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