@extends('Administrador.LayoutAdm')
@section('body')
    <div class="panel-heading"><h3>Editar personal</h3></div>
    <div style="background-color: #FFFFFF">
        @if(session()->has('true'))
            <div class="alert alert-success" role="alert">{{session('true')}} </div>
        @endif
        @if(session()->has('false'))
            <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
        @endif

        <div class="panel-body">
            @if($personal)
                @foreach($personal as $per)
                    <form name="form" onsubmit="activarbotonform(event,['spansede','spandni','spannombre',
                            'spanapellidos','spancorreo','spancodigoPersonal','spancontrasenavalidar'],'enviar','mensaje')"
                          action="{{ url('PersonalEditado/' .$per->codPersona ) }}" role="form" method="Get"
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
                                                   required id="sede" value="{{$per->nombresede}}">
                                            <span style="color: red" class=" control-label" id="spansede"></span>
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
                                            <input class="form-control input-sm" name="dni" id="dni" type="text"
                                                   autocomplete="off" onchange="validarDni('dni','spandni')"
                                                   required value="{{$per->dni}}">
                                            <span style="color: red" class=" control-label" id="spandni"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm" align="left">
                                        <div class="col-sm-4">
                                            <span class="control-label">Nombres</span>
                                            <input class="form-control input-sm" name="nombres" id='nombre' type="text"
                                                   autocomplete="off" onchange="validarNombre('nombre','spannombre')"
                                                   required value="{{$per->nombres}}">
                                            <span style="color: red" class=" control-label" id="spannombre"></span>
                                        </div>

                                    </div>
                                    <div class="form-group-sm" align="left">
                                        <div class="col-sm-4">
                                            <span class="control-label">Apellidos</span>
                                            <input class="form-control input-sm" name="apellidos" id="apellidos"
                                                   type="text"
                                                   autocomplete="off"
                                                   onchange="validarNombre('apellidos','spanapellidos')"
                                                   required value="{{$per->apellidos}}">
                                            <span style="color: red" class="control-label" id="spanapellidos"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                    <div class="form-group-sm">
                                        <div class="col-sm-3">
                                            <span class="control-label">Correo</span>
                                            <input class="form-control input-sm" name="correo" id="correo" type="email"
                                                   autocomplete="off" value="{{$per->correo}}"
                                                   onchange="validarCorreo('correo','spancorreo')" required>
                                            <span style="color: red" class="control-label" id="spancorreo"></span>
                                        </div>
                                    </div>
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
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group-sm">

                                        <div class="col-sm-2">
                                            <span class="control-label">Codigo personal</span>
                                            <input class="form-control input-sm" name="codigoPersonal"
                                                   id="codigoPersonal"
                                                   type="text" value="{{$per->codPersonal}}"
                                                   onchange="validarNumeros('codigoPersonal','spancodigoPersonal')"
                                                   required>
                                            <span style="color: red" class="control-label"
                                                  id="spancodigoPersonal"></span>
                                        </div>
                                    </div>
                                    <div class="form-group-sm " align="left">

                                        <div class="col-sm-2">
                                            <span class="control-label">Cuenta</span>
                                            <input class="form-control input-sm" name="cuentaAgregar" type="text"
                                                   autocomplete="off" required value="{{$per->cuenta}}">
                                        </div>
                                    </div>
                                    <div class="form-group-sm">

                                        <div class="col-sm-2">
                                            <span class="control-label">Contraseña</span>
                                            <input class="form-control input-sm" id="contrasenavalidar"
                                                   name="contraseñaAgregar" value="{{$per->password}}"
                                                   type="password" autocomplete="off" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <span class="control-label">Repita contraseña</span>
                                            <input class="form-control input-sm" id="contrasenavalidar" type="password"
                                                   autocomplete="off" value="{{$per->password}}"
                                                   onchange="validarContrasena('contrasenavalidar','contrasenavalidar','spancontrasenavalidar')"
                                                   required>
                                            <span class="control-label" id="spancontrasenavalidar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row form-group">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                        <div class="col-sm-12 row form-group" align="center">


                            <a href="{{url('/admBuscarPersonal')}}" class=" col-md-2 btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-ban-circle"></span>
                                Regresar
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" id="enviar" onmouseover="activarbotonform(null,['spandni','spannombre',
                            'spanapellidos','spancorreo','spancodigoPersonal','spancontrasenavalidar'
                            ],'enviar','mensaje')" name="enviar" class="col-md-2 btn btn-success"><span
                                        class="glyphicon glyphicon-ok"></span> Guardar
                            </button>

                        </div>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
@stop