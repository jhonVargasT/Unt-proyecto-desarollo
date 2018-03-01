@extends('Administrador.LayoutAdm')
@section('body')
    <fieldset>
        <div class="panel-heading"><h3>Editar Cliente</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if($cliente)
                    @foreach($cliente as $c)
                        <form name="form"
                              onsubmit="activarbotonform(event,['spandni','spannombre','spanapellidos'],'enviar','mensaje')"
                              action="{{ url('ClienteEditado/' .$c->codPersona ) }}" role="form"
                              method="Get" class="Vertical">
                            {{csrf_field()}}
                            <div class="panel panel-primary">
                                <div class="panel-heading">Datos persona</div>
                                <div class="panel-body">
                                    <div class=" row ">
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm ">
                                            <span class="control-label"> Numero de Dni</span>
                                            <input class="form-control input-sm" name="dni" id="dni" type="text"
                                                   autocomplete="off" onchange="validarDni('dni','spandni')"
                                                   placeholder="Ejem: 72978792" required value="{{$c->dni}}">
                                            <span style="color: red" class=" control-label" id="spandni"></span>
                                        </div>
                                        <div class=" col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Nombres</span>
                                            <input class="form-control input-sm" name="nombres" id="nombres" type="text"
                                                   autocomplete="off" onchange="validarNombre('nombres','spannombre')"
                                                   placeholder="Ejm:Jose Carlos" required value="{{$c->nombres}}">
                                            <span style="color: red" class=" control-label" id="spannombre"></span>
                                        </div>
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Apellidos</span>
                                            <input class="form-control input-sm" name="apellidos" type="text"
                                                   autocomplete="off" id="apellidos"
                                                   onmouseover="validarNombre('apellidos','spanapellidos')"
                                                   placeholder="Ejem: Terenas Lory" required value="{{$c->apellidos}}">
                                            <span style="color: red" class=" control-label" id="spanapellidos"></span>
                                        </div>
                                        <!--<div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label">Correo</span>
                                            <input class="form-control input-sm" id="correo" name="correo" type="email"
                                                   autocomplete="off" onchange="validarCorreo('correo','spanemail')"
                                                   required value="{{$c->correo}}">
                                            <span style="color: red" class=" control-label" id="spanemail"></span>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="panel  panel-primary">
                                <div class="panel-heading">Datos cliente</div>
                                <div class="panel-body">
                                    <div class=" row ">
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label"> Ruc</span>
                                            <input class="form-control input-sm" name="ruc" type="text" id="ruc"
                                                   autocomplete="off" onchange="validarNumeros('ruc','spanruc')"
                                                   placeholder="Ejm: 0729787548" value="{{$c->ruc}}">
                                            <span style="color: red" class=" control-label" id="spanruc"></span>
                                        </div>
                                        <div class="col-sm-2 col-xs-2 col-lg-2 form-group-sm">
                                            <span class="control-label"> Razon social</span>
                                            <input class="form-control input-sm" name="razonSocial"
                                                   placeholder="Ejm: PRICEWATERHOUSE" id="razonSocial"
                                                   onchange="validarNombre('razonSocial','spanrazon')"
                                                   value="{{$c->razonSocial}}">
                                            <span style="color: red" class=" control-label" id="spanrazon"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row form-group" align="center">
                                <span id="mensaje" class="control-label" style="color: red"></span>
                            </div>
                            <div class="col-sm-12 row form-group">

                                <a href="{{url('/admBuscarCliente')}}" class="  btn btn-sm btn-danger"><span
                                            class="glyphicon glyphicon-ban-circle"></span>
                                    Regresar
                                </a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <button href="" type="submit" name="enviar" id="enviar"
                                        onmouseover="activarbotonform(event,['spandni','spannombre','spanapellidos'],'enviar','mensaje')"
                                        class=" btn btn-sm btn-success"><span
                                            class="glyphicon glyphicon-ok"></span> Guardar
                                </button>
                            </div>
                        </form>
                    @endforeach
                @endif
            </div>
        </div>
    </fieldset>
@stop