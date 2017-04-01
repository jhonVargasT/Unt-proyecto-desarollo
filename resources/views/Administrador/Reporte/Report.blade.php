@extends('Administrador/Body')
@section('body')
    <br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Reporte Pagos</div>
        <div class="panel-body">
            <div class="panel-body form-group ">
                <form id="miform" action="{{'reportePago'}}" role="form" method="POST" class="Vertical">
                    <input type="hidden" name="_token" value="{{csrf_token() }}"/>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-5 control-label">Estado </span>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="estado">
                                    <option>Pagado</option>
                                    <option>Anulado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <span class="col-sm-5 control-label">Modalidad</span>
                            <div class="col-sm-7 ">
                                <select class=" form-control" name="modalidad">
                                    <option>Todo</option>
                                    <option>Banco</option>
                                    <option>Online</option>
                                    <option>Ventanilla</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-4 ">
                                <select class=" form-control" id="opcTramite" name="opcTramite">
                                    <option>Todo</option>
                                    <option>Tramite</option>
                                    <option>SubTramite</option>
                                </select>
                            </div>
                            <div class="col-sm-1 ">

                            </div>
                            <div class="col-sm-7">
                                @if(isset($Tram))
                                    <input type="text" class="form-control input-sm " id="input" name="inputTram"
                                           autocomplete="off" value="{{$Tram}}">
                                @else
                                    <input type="text" class="form-control input-sm " id="input" name="inputTram"
                                           autocomplete="off">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group ">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="sed" onclick="habilitarsed(this.checked)">
                                Sede
                            </div>
                            <div class="col-sm-7 ">
                                @if(isset($sede))
                                    <input class="typeahead form-control " name="sed" value="{{$sede}}" id="sede"
                                           autocomplete="off" disabled>
                                @else
                                    <input class="typeahead form-control " name="sed" id="sede" autocomplete="off"
                                           disabled>
                                @endif
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cfac" onclick="habilitarfac(this.checked)">
                                facultad
                            </div>
                            <div class="col-sm-7 ">
                                @if(isset($fac))
                                    <input class="typeahead form-control " name="fac" id="fac" autocomplete="off"
                                           value="{{$fac}}" disabled>
                                @else
                                    <input class="typeahead form-control " name="fac" id="fac" autocomplete="off"
                                           disabled>
                                @endif
                            </div>
                        </div>

                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cesc" onclick=" habilitaresc(this.checked)">
                                Escuela
                            </div>
                            <div class="col-sm-7 ">
                                @if(isset($esc))
                                    <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                           value="{{$esc}}" disabled>
                                @else
                                    <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                           disabled>
                                @endif
                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">

                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-4">
                                <input type="checkbox"  onclick=" habilitartr(this.checked)">
                                Tipo de recurso
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control input-sm " id="trinp" name="tr" autocomplete="off"
                                       disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="checkbox"  onclick="habilitarff(this.checked)">
                                Fuente de financiamiento
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control input-sm " id="ff" name="fuf"
                                       autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="form-group-sm col-sm-1 ">
                            <span class="col-sm-12 control-label">Fecha:  </span>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaDesde" class="form-control" placeholder="desde"
                                       autocomplete="off"  required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaHasta" class="form-control"
                                       placeholder="hasta"
                                       autocomplete="off" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class=" col-sm-4"></div>
                        <div class="col-md-4">
                            <button class="col-lg-4 btn btn-warning" onclick=" limpiarCampos()"><span
                                              class="glyphicon glyphicon-erase" ></span> Limpiar
                                campos
                            </button>
                            <div class="col-lg-4"></div>
                            <button type="submit" name="enviar" class="col-lg-4 btn btn-success"><span
                                        class="glyphicon glyphicon-refresh"></span> Actualizar lista
                            </button>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </form>
                <!--Tabla-->

                <div align="center" class="col-sm-12 row form-group ">
                    <div class="col-sm-12 row form-group ">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-3">
                                Total :
                            </div>
                            <div class="col-sm-2">
                                @if(isset($total) )
                                    {{$total}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive col-sm-12">
                        <table class="table table-bordered list-inline">
                            @if(isset($result))
                                <thead align="center">
                                <!--cabecear Tabla-->
                                <tr class="active">

                                    <th>
                                        <div align="center">
                                            <small>ID</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>MODALIDAD</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>SEDE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>FACULTAD</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>ESCUELA</small>
                                        </div>
                                    </th>

                                    <th>
                                        <div align="center">
                                            <small>CLASIFICADOR S.I.A.F</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>FUE FIN</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>TIP REC</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>TRAMITE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>SUB TRAMITE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>FECHA</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>PRECIO</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>DETALLE</small>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--Contenido-->

                                @foreach($result as $r)
                                    <tr>
                                        <td><h6 align="center">{{$r->codigopago}}</h6></td>
                                        <td><h6 align="left">{{$r->modalidad}}</h6></td>
                                        <td><h6 align="left">{{$r->nombresede}}</h6></td>
                                        <td><h6 align="left">{{$r->nombrefacultad}}</h6></td>
                                        <td><h6 align="left">{{$r->nombreescuela}}</h6></td>
                                        <td><h6 align="left">{{$r->clasi}}</h6></td>
                                        <td><h6 align="center">{{$r->tiporecurso }}</h6></td>
                                        <td><h6 align="center">{{$r->fuentefinanc}}</h6></td>
                                        <td><h6 align="left">{{$r-> nombretramite}}</h6></td>
                                        <td><h6 align="left">{{$r->nombresubtramite }}</h6></td>
                                        <td><h6 align="left">{{$r->fechapago}}</h6></td>
                                        <td><h6 align="center">{{$r->precio}}</h6></td>
                                        <td><h6 align="left">{{$r->pagodetalle}}</h6></td>


                                    </tr>
                                </tbody>
                                @endforeach

                            @else
                                <thead align="center">
                                <!--cabecear Tabla-->
                                <tr class="active">

                                    <th>
                                        <div align="center">
                                            <small>ID PAGO</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>MODALIDAD</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE SEDE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE FACULTAD</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE ESCUELA</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>FECHA PAGO</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE TRAMITE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE SUB TRAMITE</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>PRECIO</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>Opciones</small>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--Contenido-->

                                <tr>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td><h6 align="center"></h6></td>
                                    <td align="center">

                                    </td>

                                </tr>
                                </tbody>

                            @endif


                        </table>
                    </div>
                    <div class="col-sm-12 row form-group">
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <a href="{{url('/Adm')}}" class="btn  btn-primary"><span
                                        class="glyphicon glyphicon-arrow-left"></span> Regresar
                            </a>
                        </div>

                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <button href="#" class="btn  btn-primary" id="imp">Imprimir <span
                                        class="glyphicon glyphicon-print"></span></button>
                        </div>

                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">
        $('#inputTram').autocomplete({
            source : 'autocompleteTram',
            minlenght:1,
            autoFocus:true,
            select:function(e,ui){
                alert(ui);
            }
        });
        function limpiarCampos() {
            var x='1';
            document.getElementById("fac").innerHTML = x;
            document.getElementById("sede").innerHTML = x;
            document.getElementById("esc").innerHTML = x;
        }
        function habilitarff(value) {
            if (value == true) {
                document.getElementById("ff").disabled = false;
            } else if (value == false) {
                document.getElementById("ff").disabled = true;
            }
        }
        function habilitartr(value) {
            if (value == true) {
                document.getElementById("trinp").disabled = false;
            } else if (value == false) {
                document.getElementById("trinp").disabled = true;
            }
        }
        function habilitarsed(value) {
            if (value == true) {
                document.getElementById("sede").disabled = false;
            } else if (value == false) {
                document.getElementById("sede").disabled = true;
            }
        }
        function habilitarfac(value) {

            if (value == true) {
                document.getElementById("sed").checked = true;
                document.getElementById("fac").disabled = false;
                document.getElementById("sede").disabled = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("fac").disabled = true;
                document.getElementById("sede").disabled = true;
            }
        }
        function habilitaresc(value) {
            if (value == true) {
                document.getElementById("sed").checked = true;
                document.getElementById("cfac").checked = true;
                document.getElementById("fac").disabled = false;
                document.getElementById("sede").disabled = false;
                document.getElementById("esc").disabled = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("esc").disabled = true;
                document.getElementById("fac").disabled = true;
                document.getElementById("sede").disabled = true;
            }
        }
    </script>

@endsection
