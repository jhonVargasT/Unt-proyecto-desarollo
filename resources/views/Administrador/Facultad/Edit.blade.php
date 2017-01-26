@extends('Administrador.Body')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"> EditarFacultad</div>
        <div class="panel-body">
            @if($facultad)
                @foreach($facultad as $f)
                    <form name="form" action="{{ url('FacultadEditada/' .$f->idFacultad ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="col-sm-12 row form-group">

                            <div class="form-group-sm " align="left">
                                <span class="col-sm-2 control-label"> Codigo Facultad</span>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" name="CodigoFacultad" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)"
                                           value="{{$f->codFacultad}}">
                                </div>
                            </div>
                            <div class=" form-group-sm" align="left">
                                <span class="col-sm-2 control-label"> </span>
                                <span class="col-sm-2 control-label">Cuenta interna </span>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm" name="CuentaInterna" type="text"
                                           autocomplete="off"
                                           onkeypress="return validarNum(event)" value="{{$f->nroCuenta}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">

                                <span class="col-sm-2 control-label"> Nombre facultad</span>
                                <div class="col-sm-5">
                                    <input class="form-control input-sm" name="NombreFacultad" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)"
                                           value="{{$f->nombre}}">

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
                                <button  href="" type="submit" name="enviar" class="col-md-2 btn btn-sm btn-success"><span
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