@extends('Administrador.Body')
@section('produccion')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarProduccion">Buscar Centro de Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarProduccion" style="color: #509f0c" target="_top">Agregar Centro de
                            Produccion</a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaA'))
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <div class="panel-heading"><h3>Agregar Produccion</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <form name="form" action="{{url('ProduccionRegistrado')}}" role="form" method="POST" class="Horizontal"
                      onsubmit="activarbotonform(event,['spannombre'],'enviar','mensaje')">
                    {{csrf_field()}}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos de Produccion</div>
                        <div class="panel-body">
                            <div class=" row ">
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Nombre</span>
                                    <input class="form-control input-sm" name="nombre" type="text"
                                           autocomplete="off" onchange="validarNombre('nombre','spannombre')"
                                           placeholder="Ejem: UNT" required id="nombre">
                                    <span style="color: red" class=" control-label" id="spannombre"></span>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Direccion</span>
                                    <input class="form-control input-sm" name="direccion" type="text"
                                           autocomplete="off"
                                           placeholder="Ejm: Calle Juan Pablo Segundo" required id="direccion">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group" align="center">
                        <span id="mensaje" class="control-label" style="color: red"></span>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"></div>
                        <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                    class="glyphicon glyphicon-ban-circle"></span>
                            Cancelar</a>
                        <div class="col-md-2"></div>
                        <button type="submit" id="enviar"
                                onmouseover="activarbotonform(null,['spannombre'],'enviar','mensaje')"
                                name="enviar" class="col-md-2 btn btn-sm btn-success"><span
                                    class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                        <div class="col-md-3"></div>
                    </div>
                </form>
            </div>
        </div>
    @else
        @include("index")
    @endif
@stop
