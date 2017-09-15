@extends('Administrador.Body')
@section('sede')
    <div id="collapseThrees" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarSede">Buscar Sedes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarSede" style="color: #509f0c" target="_top">Agregar Sede</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Agregar sede</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <form name="form" action="{{url('SedeRegistrada')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Sede</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Sede</span>
                                    <input class="form-control input-sm" name="nombresede" id="nombresede" type="text"
                                           autocomplete="off" onchange="validarNombre('nombresede','spandni')"
                                           required>
                                    <span style="color: red" class=" control-label" id="spandni" > </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Codigo sede</span>
                                    <input class="form-control input-sm" name="codigosede" id="codigosede" type="text"
                                           autocomplete="off" onchange="validarNumeros('codigosede','spandni')"
                                           required>
                                    <span style="color: red" class=" control-label" id="spandni" > </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Direccion</span>
                                    <input class="form-control input-sm" name="direccion" id="direccion" type="text"
                                           autocomplete="off" required>
                                    <span style="color: red" class=" control-label" id="spandni" > </span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">
                        <div class="col-sm-5">
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