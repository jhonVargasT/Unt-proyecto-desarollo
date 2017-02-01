@extends('Administrador.Body')
@section('facultad')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarFacultad">Buscar Facultades</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarFacultad" style="color: #509f0c" target="_top" >Agregar Facultad</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
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
                            <input class="form-control input-sm" name="CodigoFacultad" type="text" autocomplete="off"
                                   onkeypress="return validarNum(event)">
                        </div>
                    </div>
                    <div class=" form-group-sm" align="left">
                        <span class="col-sm-2 control-label"> </span>
                        <span class="col-sm-2 control-label">Cuenta interna </span>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" name="CuentaInterna" type="text" autocomplete="off"
                                   onkeypress="return validarNum(event)">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">

                        <span class="col-sm-2 control-label"> Nombre facultad</span>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" name="NombreFacultad" type="text" autocomplete="off"
                                   onkeypress="return validarLetras(event)">

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="/Adm" class=" col-md-2 btn btn-sm btn-danger"><span
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

        </div>
    </div>


@stop