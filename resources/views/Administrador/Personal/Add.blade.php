@extends('Administrador/Body')
@section('personal')
    <div id="collapseFour" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarPersonal">Buscar Personal</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarPersonal" style="color: #509f0c" target="_top">Agregar Personal</a>
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

    <div class="panel-heading"><h3>Agregar personal</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            @if(session()->has('true'))
                <div class="alert alert-success" role="alert">{{session('true')}} </div>
            @endif
            @if(session()->has('false'))
                <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
            <form name="form" onsubmit="activarbotonform(event,['spansede','spandni','spannombre',
                            'spanapellidos','spanemail','spancodigopersonal'],'enviar','mensaje')"
                  action="{{url('PersonalRegistrado')}}" role="form" method="POST"
                  class="Vertical">
                {{csrf_field()}}
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Sede</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Sede</span>
                                    <input class="typeahead form-control input-sm" name="sede" type="text"
                                           autocomplete="off" onchange=" validarNombre('sede','spansede')"
                                           required id="sede">
                                    <span style="color: red" class=" control-label" id="spansede"> </span>
                                </div>
                                <script type="text/javascript">
                                    var path = "{{ route('autocompletesede') }}";
                                    $('input.typeahead').typeahead({
                                        source: function (query, process) {
                                            return $.get(path, {query: query}, function (data) {
                                                return process(data);
                                            });
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos persona</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class=" control-label"> Numero de Dni</span>
                                    <input class="form-control input-sm" name="dni" type="text"
                                           autocomplete="off" onchange=" validarDni('dni','spandni')"
                                           placeholder="Ejem: 72978792" required id="dni">
                                    <span style="color: red" class=" control-label" id="spandni"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm" align="left">
                                <div class="col-sm-4">
                                    <span class="control-label">Nombres</span>
                                    <input class="form-control input-sm" name="nombres" id='nombre' type="text"
                                           autocomplete="off" onchange="validarNombre('nombre','spannombre')"
                                           required>
                                    <span style="color: red" class=" control-label" id="spannombre"> </span>
                                </div>

                            </div>
                            <div class="col-sm-4 col-xs-4 col-lg-4 form-group-sm">
                                <span class="control-label">Apellidos</span>
                                <input class="form-control input-sm" name="apellidos" type="text"
                                       autocomplete="off" onchange="validarNombre('apellidos','spanapellidos')"
                                       placeholder="Ejem: Terenas Lory" required id="apellidos">
                                <span style="color: red" class=" control-label" id="spanapellidos"> </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-4 col-lg-4 form-group-sm">
                            <span class="control-label">Correo</span>
                            <input class="form-control input-sm" name="correo" type="email" id="email"
                                   autocomplete="off" onchange="validarCorreo('email','spanemail')" required>
                            <span style="color: red" class=" control-label" id="spanemail"> </span>
                        </div>
                    </div>
                </div>
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos usuario</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-3">
                                    <span class="control-label">Tipo de cuenta</span>
                                    <select class="form-control " name="tipocuenta">
                                        <option>Administrador</option>
                                        <option>Ventanilla</option>
                                        <!--<option>Reportes</option>-->
                                        <option>Importador</option>
                                        <option>Registro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                    <span class="control-label">Codigo personal</span>
                                    <input class="form-control input-sm" name="codigoPersonal" type="text"
                                           onchange="validarNumeros('codigoPersonal','spancodigopersonal')"
                                           autocomplete="off" placeholder="Ejm: 000104499" required id="codigoPersonal">
                                    <span style="color: red" class=" control-label" id="spancodigopersonal"> </span>
                                </div>
                            </div>
                            <div class="form-group-sm " align="left">

                                <div class="col-sm-2">
                                    <span class="control-label">Cuenta</span>
                                    <input class="form-control input-sm" name="cuentaAgregar" type="text"
                                           autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <div class="col-sm-2">
                                    <span class="control-label">Contraseña</span>
                                    <input class="form-control input-sm" id="contrasenavalidar1"
                                           name="contraseñaAgregar"
                                           type="password"
                                           autocomplete="off" required>
                                </div>
                                <div class="col-sm-2">
                                    <span class="control-label">Repita contraseña</span>
                                    <input class="form-control input-sm" id="contrasenavalidar2"
                                           name="contrasenavalidar"
                                           onchange="validarContrasena('contrasenavalidar1','contrasenavalidar2','spancontrasenavalidar')"
                                           type="password" autocomplete="off" required>
                                    <span class="control-label" id="spancontrasenavalidar"> </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 row form-group" align="center">
                    <span id="mensaje" class="control-label" style="color: red"></span>
                </div>
                <div class="col-sm-12  row " align="center">

                    <a href="{{url('/Adm')}}" class=" btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="enviar" id="enviar" class=" btn-sm btn btn-success"
                            onmouseover="activarbotonform(null,['spansede','spandni','spannombre',
                            'spanapellidos','spanemail','spancodigopersonal'],'enviar','mensaje')">
                        <span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>

                </div>
            </form>
        </div>
    </div>
@stop