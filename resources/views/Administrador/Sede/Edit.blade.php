@extends('Administrador/Body')
@section('sede')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSede " style="color: #509f0c">Buscar Sedes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSede" target="_top">Agregar Sede</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Editar Sede</div>
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($sede)
                @foreach($sede as $s)
                    <form name="form" action="{{ url('SedeEditada/' .$s->codSede ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Codigo Sede</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="codigoSede" type="text"
                                           value="{{$s->codigosede}}">
                                </div>
                            </div>
                            <div class=" form-group-sm" align="right">
                                <span class="col-sm-2 control-label">Nombre Sede </span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="nombreSede" type="text"
                                           autocomplete="off"
                                           onkeypress="return validarLetras(event)" value="{{$s->nombresede}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label">Direccion</span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="direccion" type="text"
                                           autocomplete="off"
                                           value="{{$s->direccion}}">
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
                @endforeach
            @endif
        </div>
    </div>
@stop