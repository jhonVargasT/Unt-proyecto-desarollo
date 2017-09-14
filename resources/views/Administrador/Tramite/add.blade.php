@extends('Administrador/Body')
@section('tramite')
    <div id="collapseFive" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarTramite">Buscar Clasificador</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarTramite" style="color: #509f0c" target="_top">Agregar Clasificador</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel-heading"><h3>Agregar clasificador </h3></div>
    <div style="background-color: #FFFFFF">

        <div class="panel-body">
            <form

                    name="form" action="{{url('TramiteRegistrado')}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="col-sm-12 row form-group">
                    <div class="form-group-sm " align="left">

                        <div class="col-sm-3">
                            <span class=" control-label"> SIAF </span>
                            <input class="form-control input-sm" name="clasificador" id="clasificador" type="text"
                                   autocomplete="off" required
                                   onchange="validarNumeros('clasificador','spanclasificador')">
                            <span class=" control-label" style="color:red" id="spanclasificador">  </span>
                        </div>
                    </div>
                    <div class=" form-group-sm" align="left">

                        <div class="col-sm-2">
                            <span class=" control-label">Nombre de clasificador</span>
                            <input class="form-control" name="nombre" id="nombre" type="text"
                                   autocomplete="off"
                                   required>
                            <span class=" control-label" style="color:red" id="spannombre">  </span>
                        </div>
                    </div>
                    <div class="form-group-sm " align="left">

                        <div class="col-sm-3">
                            <span class="control-label"> Tipo de recurso</span>
                            <input class=" form-control input-sm" name="tipoRecurso" type="text"
                                   autocomplete="off" placeholder="A">
                        </div>
                    </div>
                    <div class=" form-group-sm" align="left">
                        <div class="col-sm-2">
                            <span class=" control-label"> Fuente de financiamieto</span>

                            <input class="form-control" name="fuentefinanc" type="text"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class=" form-group-sm" align="left">
                        <div class="col-sm-2">
                            <span class=" control-label"> Aux</span>

                            <input class="form-control" name="aux" type="text"
                                   autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 row form-group" align="center">
                    <span id="mensaje" class="control-label" style="color: red"></span>
                </div>
                <div class="col-sm-12 row form-group">
                    <div class="col-md-3"></div>
                    <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar</a>
                    <div class="col-md-2"></div>
                    <button type="submit" name="enviar" id="enviar" class="col-md-2 btn btn-success">
                        <span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
@stop