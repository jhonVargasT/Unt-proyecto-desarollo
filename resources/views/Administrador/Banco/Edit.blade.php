@extends('Administrador.LayoutAdm')
@section('body')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="panel-heading"><h3>Editar Banco</h3></div>
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
                    <form name="form" onsubmit="activarbotonform(event,['spanbanco','spancuenta'],'enviar','mensaje')"
                          action="{{ url('BancoEditado/' .$b->codBanco ) }}" role="form" method="Get"
                          class="Vertical">
                        {{csrf_field()}}
                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos Banco</div>
                            <div class="panel-body">
                                <div class=" row ">
                                    <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                        <span class="control-label">Banco</span>
                                        <input class="form-control input-sm" name="banco" type="text" id="banco"
                                               autocomplete="off" onchange="validarNombre('banco','spanbanco')"
                                               placeholder="Ejem: Banco de la Nacion" required value="{{$b->banco}}">
                                        <span class=" control-label" style="color:red" id="spanbanco"></span>
                                    </div>
                                    <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                        <span class="control-label">Cuenta</span>
                                        <input class="form-control input-sm" name="cuenta" type="text" id="cuenta"
                                               autocomplete="off" onchange="validarNumeros('cuenta','spancuenta')"
                                               placeholder="Ejm:123456 " required value="{{$b->cuenta}}">
                                        <span class=" control-label" style="color:red" id="spancuenta"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                        <div class="row form-group" align="center">

                            <a href="{{url('/admBuscarBanco')}}" class=" btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" name="enviar" id="enviar"
                                        onmouseover="activarbotonform(null,['spanbanco','spancuenta'],'enviar','mensaje')"
                                        class=" btn btn-sm btn-success"><span
                                            class="glyphicon glyphicon-ok"></span> Guardar
                                </button>

                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
@stop