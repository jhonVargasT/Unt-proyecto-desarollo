@extends('Reportes.Body')
@section('banco')
    <div id="collapseBanco" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/buscarreBanco" >Buscar cuenta bancaria</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fa fa-building-o"></span>
                        <a href="/agregarreBanco" style="color: #509f0c" target="_top" >Agregar cuenta bancaria</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaR'))
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <div class="panel-heading"><h3>Agregar Banco</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <form name="form" action="{{url('BancoRegistrado')}}" role="form" method="POST" class="Horizontal">
                    {{csrf_field()}}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos Banco</div>
                        <div class="panel-body">
                            <div class=" row ">
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Banco</span>
                                    <input class="form-control input-sm" name="banco" type="text"
                                           autocomplete="off" onkeypress="return validarLetras(event)"
                                           placeholder="Ejem: Banco de la Nacion" required>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Cuenta</span>
                                    <input class="form-control input-sm" name="cuenta" type="text"
                                           autocomplete="off" onkeypress="return validarNum(event)"
                                           placeholder="Ejm:123456 " required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"></div>
                        <a href="{{url('/Adm')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                    class="glyphicon glyphicon-ban-circle"></span>
                            Cancelar</a>
                        <div class="col-md-2"></div>
                        <button type="submit" name="enviar" class="col-md-2 btn btn-sm btn-success"><span
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
