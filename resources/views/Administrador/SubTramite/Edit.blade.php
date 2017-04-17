@extends('Administrador/Body')
@section('subtramite')
    <div id="collapseSix" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSubtramite" style="color: #509f0c" target="_top">Buscar Tasa</a>
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
    <div class="panel-heading"><h3> Editar Tasa</h3></div>
    <div  style="background-color: #FFFFFF" >

        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($subtramite)
                @foreach($subtramite as $s)
                    <form name="form" action="{{ url('SubtramiteEditada/' .$s->codSubtramite ) }}" role="form"
                          method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <legend>Editar SubTasa</legend>
                        <br>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Nombre Tasa</span>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control input-sm" name="nombreSubtramite"
                                           placeholder="Ingresa Nombre de Tramite aqui .." autocomplete="off"
                                           onkeypress="return validarLetras(event)"
                                           value="{{$s->nombre}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Cuenta contable</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="cuentaContable" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)"
                                           value="{{$s->cuenta}}">
                                </div>
                                <div class="col-sm-1">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <span class="col-sm-1">Precio</span>
                                <div class="input-group col-sm-2">
                                    <div class="input-group-addon ">S/.</div>
                                    <input type="text" class="form-control " name="precio" autocomplete="off"
                                           onkeypress="return validarNum(event)"
                                           value="{{$s->precio}}">
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