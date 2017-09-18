@extends('Ventanilla.Body')
@section('cliente')
    <div id="collapseClie" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/ventBuscarCliente">Buscar Clientes</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/ventRegistrarCliente" style="color: #509f0c" target="_top">Agregar Clientes</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaV'))
        <script src="{{asset('assets/js/utilidades.js')}}"></script>

        <div class="panel-heading"><h3> Agregar cliente</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <form name="form"
                      onsubmit="activarbotonform(event,['spandni','spannombre','spanapellidos','spanemail','spanruc','spanrazonsocial'],'enviar','mensaje')"
                      action="{{url('ClienteRegistrado')}}" role="form" method="POST" class="Horizontal">
                    {{csrf_field()}}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos personales</div>
                        <div class="panel-body">
                            <div class=" row ">
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label"> Numero de Dni</span>
                                    <input class="form-control input-sm" name="dni" type="text"
                                           autocomplete="off" onchange=" validarDni('dni','spandni')"
                                           placeholder="Ejem: 72978792" required id="dni">
                                    <span style="color: red" class=" control-label" id="spandni"> </span>
                                    <script>
                                        $('#dni').change(function () {
                                            $.ajax({
                                                url: "/buscarAlumno",
                                                type: "get",
                                                data: {dni: $('#dni').val()},
                                                success: function (data) {
                                                    if (data != false) {
                                                        $('#nombres').val(data[0]);
                                                        $('#apellidos').val(data[1]);
                                                        $('#correo').val(data[2]);
                                                        $('#codAlumno').val(data[3]);
                                                        $('#fecha').val(data[4]);
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Nombres</span>
                                    <input class="form-control input-sm" name="nombres" type="text"
                                           autocomplete="off" onchange="validarNombre('nombres','spannombre')"
                                           placeholder="Ejm:Jose Carlos" required id="nombres">
                                    <span style="color: red" class=" control-label" id="spannombre"> </span>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Apellidos</span>
                                    <input class="form-control input-sm" name="apellidos" type="text"
                                           autocomplete="off" onchange="validarNombre('apellidos','spanapellidos')"
                                           placeholder="Ejem: Terenas Lory" required id="apellidos">
                                    <span style="color: red" class=" control-label" id="spanapellidos"> </span>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label">Correo</span>
                                    <input class="form-control input-sm" name="correo" type="email" id="email"
                                           autocomplete="off" onchange="validarCorreo('email','spanemail')" required
                                           placeholder="Ejem: correo@gmail.com">
                                    <span style="color: red" class=" control-label" id="spanemail"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos cliente</div>
                        <div class="panel-body">
                            <div class=" row ">
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label"> Ruc</span>
                                    <input class="form-control input-sm" name="ruc" type="text"
                                           autocomplete="off" onchange="validarNumeros('ruc','spanruc')"
                                           placeholder="Ejm: 0729787548" id="ruc">
                                    <span style="color: red" class=" control-label" id="spanruc"> </span>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                    <span class="control-label"> Ruc</span>
                                    <input class="form-control input-sm" name="razonSocial"
                                           placeholder="Ejm:PRICEWATERHOUSE"
                                           onchange="validarNombre('razonSocial','spanrazonsocial')" id="razonSocial">
                                    <span style="color: red" class=" control-label" id="spanrazonsocial"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="col-md-3"></div>
                        <a href="{{url('/Vent')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                    class="glyphicon glyphicon-ban-circle"></span>
                            Cancelar</a>
                        <div class="col-md-2"></div>
                        <button type="submit"
                                onmouseover="activarbotonform(null,['spandni','spannombre','spanapellidos','spanemail','spanruc','spanrazonsocial'],'enviar','mensaje')"
                                name="enviar" class="col-md-2 btn btn-success"><span
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
