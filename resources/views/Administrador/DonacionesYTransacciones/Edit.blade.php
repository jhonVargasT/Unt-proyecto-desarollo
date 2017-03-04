@extends('Administrador/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y
                            transacciones</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarDonaciones">Agregar Donaciones y transacciones</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <fieldset>
        <div class="panel panel-primary">
            <div class="panel-heading"> Editar Cliente</div>
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                @if($donacion)
                    @foreach($donacion as $d)
                        <form name="form" action="{{ url('DonacionEditada/'.$d->codDonacion)}}" role="form"
                              method="Get"
                              class="Vertical">
                        {{csrf_field()}}
                        <!-- Form Name -->
                            <legend>Editar Donaciones y Transacciones</legend>
                            <!-- Search input-->
                            <br>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label">Numero de resolucion </span>
                                    <div class="col-sm-4">
                                        <input class="form-control " name="numeroResolucion" type="text"
                                               autocomplete="off" onkeypress="return validarNum(event)"
                                               value="{{$d->numResolucion}}">
                                    </div>
                                </div>
                                <div class=" form-group-sm" align="left">
                                    <span class="col-sm-2 control-label">Fecha </span>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="fechaDeIngreso" type="text"
                                               autocomplete="off" onkeypress="return validarNumS(event)"
                                               value="{{$d->fechaIngreso}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group">
                                <div class="form-group-sm " align="left">
                                    <span class="col-sm-2 control-label">Monto </span>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="monto" type="text"
                                               autocomplete="off" onkeypress="return validarNumP(event)"
                                               value="{{$d->monto}}">
                                    </div>
                                </div>
                                <div class=" form-group-sm" align="left">
                                    <span class=" col-sm-2 control-label">Descripcion </span>
                                    <div class="col-sm-4">
                                        <textarea class="form-control " rows="2"
                                                  name="descripcion">{{$d->descripcion}}</textarea>
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
            </div>
            @endforeach
            @endif
        </div>
    </fieldset>
@stop