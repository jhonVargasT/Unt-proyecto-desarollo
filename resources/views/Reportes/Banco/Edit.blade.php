@extends('Administrador.Body')
@section('banco')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarBanco">Buscar Bancos</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarBanco" style="color: #509f0c" target="_top">Agregar Banco</a>
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="panel-heading"><h3>Editar Alumno</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            @if($banco)
                @foreach($banco as $b)
                    <form name="form" action="{{ url('BancoEditado/' .$b->codBanco ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos persona</div>
                            <div class="panel-body">
                                <div class=" row ">
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label">Banco</span>
                                        <input class="form-control input-sm" name="banco" type="text"
                                               autocomplete="off" onkeypress="return validarLetras(event)"
                                               placeholder="Ejem: Banco de la Nacion" required value="{{$b->banco}}">
                                    </div>
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Cuenta</span>
                                        <input class="form-control input-sm" name="cuenta" type="text"
                                               autocomplete="off" onkeypress="return validarNum(event)"
                                               placeholder="Ejm:123456 " required value="{{$b->cuenta}}">
                                    </div>
                                </div>
                            </div>
                            <div class=" row ">
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
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
@stop