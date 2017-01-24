@extends('Administrador.Body')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> Agregar facultad</div>
        <div class="panel-body">
            <form name="form" action="{{url('FacultadRegistrada')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <span class="col-sm-2 control-label"> Codigo Facultad</span>
                        <div class="col-sm-2">
                            <input class="form-control input-sm" name="CodigoFacultad" type="text">
                            @if($errors->has('CodigoFacultad'))
                                <span style="color: red">{{$errors->first('CodigoFacultad')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-2 control-label"> </span>
                        <span class="col-sm-2 control-label">Cuenta interna </span>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" name="CuentaInterna" type="text">
                            @if($errors->has('CuentaInterna'))
                                <span style="color: red">{{$errors->first('CuentaInterna')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">

                        <span class="col-sm-2 control-label"> Nombre facultad</span>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" name="NombreFacultad" type="text">
                            @if($errors->has('NombreFacultad'))
                                <span style="color: red">{{$errors->first('NombreFacultad')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <button href="#" class=" col-md-2 btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </button>
                    <div class="col-md-2">

                    </div>
                    <div>
                        <button type="submit" name="enviar" class="col-md-2 btn btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>

        </div>
    </div>

@stop