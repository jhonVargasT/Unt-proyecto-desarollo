@extends('Administrador.Body')
@section('escuela')
    <div id="collapseThree" class="in collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarEscuela" style="color: #509f0c" target="_top">Buscar Escuelas</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarEscuela" >Agregar Escuela</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <div class="panel-heading"> <h3>EditarEscuela</h3></div>
        <div style="background-color: #FFFFFF" >
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                @if($escuela)
                    @foreach($escuela as $e)
                        <form name="form" action="{{ url('EscuelaEditada/' .$e->idEscuela ) }}" role="form" method="Get"
                              class="Vertical">
                            {{csrf_field()}}
                            <div class="col-sm-12 row form-group">

                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label"> Codigo Escuela</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="CodigoEscuela" type="text"
                                               value="{{$e->codEscuela}}">
                                    </div>
                                </div>
                                <div class=" form-group-sm" align="left">
                                    <span class="col-sm-1 control-label"> </span>
                                    <span class="col-sm-2 control-label">Cuenta interna </span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="CuentaInterna" type="text"
                                               autocomplete="off"
                                               onkeypress="return validarCodigoSiaf(event)" value="{{$e->nroCuenta}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label"> Nombre escuela</span>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" name="NombreEscuela" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)"
                                               value="{{$e->nombre}}">
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
    </fieldset>
@stop