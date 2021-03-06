@extends('Administrador.Body')
@section('reportes')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <a href="/admReportres"><span
                                    class="glyphicon glyphicon-book"></span> Reporte Resumido</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/admReportes" style="color: #509f0c" target="_top"> <span
                                    class="glyphicon glyphicon-list-alt"></span> Reporte pagos
                            detallado</a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@stop
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <script type="text/javascript">
        function limpiarCampos() {

            document.getElementById("sede").value = "";
            document.getElementById("fac").value = "";
            document.getElementById("esc").value = "";
            document.getElementById("cp").value = "";
            document.getElementById("ff").value = "";
            document.getElementById("trinp").value = "";
            document.getElementById("fecdesde").value = "";
            document.getElementById("fecHasta").value = "";
            document.getElementById("input").value = "";


            document.getElementById("sede").readOnly = true;
            document.getElementById("fac").readOnly = true;
            document.getElementById("esc").readOnly = true;
            document.getElementById("cp").readOnly = true;
            document.getElementById("ff").readOnly = true;
            document.getElementById("trinp").readOnly = true;
            document.getElementById("input").readOnly = true;

            document.getElementById("ctr").checked = false;
            document.getElementById("cff").checked = false;
            document.getElementById("cesc").checked = false;
            document.getElementById("cfac").checked = false;
            document.getElementById("sed").checked = false;
            document.getElementById("ccp").checked = false;

        }


        function habilitarCP(value) {
            if (value) {
                document.getElementById("cp").readOnly = false;
                document.getElementById("sede").readOnly = true;
                document.getElementById("fac").readOnly = true;
                document.getElementById("esc").readOnly = true;

                document.getElementById("sede").value = "";
                document.getElementById("fac").value = "";
                document.getElementById("esc").value = "";

                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("cesc").checked = false;
                document.getElementById("cp").style.backgroundColor = '#FFFFFF ';

            } else {
                document.getElementById("cp").readOnly = true;
                document.getElementById("cp").value = "";
                document.getElementById("cp").style.backgroundColor = '#e6e6e6';
                document.getElementById("spanproduccion").innerHTML = "";
            }
        }

        function habilitarff(value) {
            if (value) {
                document.getElementById("ff").readOnly = false;
                document.getElementById("ff").style.backgroundColor = '#FFFFFF';
            } else {
                document.getElementById("ff").readOnly = true;
                document.getElementById("ff").value = "";
                document.getElementById("ff").style.backgroundColor = '#e6e6e6';
                document.getElementById("spanff").innerHTML = "";
            }
        }

        function habilitartr(value) {
            if (value) {
                document.getElementById("trinp").readOnly = false;
                document.getElementById("trinp").style.backgroundColor = '#FFFFFF';
            } else {
                document.getElementById("trinp").readOnly = true;
                document.getElementById("trinp").value = "";
                document.getElementById("trinp").style.backgroundColor = '#e6e6e6';
                document.getElementById("spantr").innerHTML = "";
            }
        }

        function habilitarsed(value) {
            if (value) {
                document.getElementById("cp").value = "";
                document.getElementById("ccp").checked = false;
                document.getElementById("cp").readOnly = true;
                document.getElementById("sede").readOnly = false;
                document.getElementById("sede").style.backgroundColor = '#FFFFFF';
            } else {
                document.getElementById("sede").readOnly = true;
                document.getElementById("fac").readOnly = true;
                document.getElementById("esc").readOnly = true;

                document.getElementById("sede").value = "";
                document.getElementById("fac").value = "";
                document.getElementById("esc").value = "";


                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("cesc").checked = false;

                document.getElementById("sede").style.backgroundColor = '#e6e6e6 ';
                document.getElementById("spansede").innerHTML = "";
            }
        }

        function habilitarfac(value) {
            if (value) {
                document.getElementById("ccp").checked = false;
                document.getElementById("sed").checked = false;
                document.getElementById("cp").readOnly = true;
                document.getElementById("cp").value = "";

                document.getElementById("sed").checked = true;
                document.getElementById("fac").readOnly = false;
                document.getElementById("sede").readOnly = false;

                document.getElementById("fac").style.backgroundColor = '#FFFFFF';
            } else {
                document.getElementById("sed").checked = false;
                document.getElementById("fac").readOnly = true;
                document.getElementById("sede").readOnly = true;

                document.getElementById("fac").value = "";
                document.getElementById("sede").value = "";

                document.getElementById("fac").style.backgroundColor = '#e6e6e6 ';
                document.getElementById("spanfacultad").innerHTML = "";
            }
        }

        function habilitaresc(value) {
            if (value) {
                document.getElementById("ccp").checked = false;
                document.getElementById("cp").value = "";
                document.getElementById("cp").readOnly = true;
                document.getElementById("sed").checked = true;
                document.getElementById("cfac").checked = true;
                document.getElementById("fac").readOnly = false;
                document.getElementById("sede").readOnly = false;
                document.getElementById("esc").readOnly = false;
                document.getElementById("esc").style.backgroundColor = '#FFFFFF';
            } else {
                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("esc").readOnly = true;
                document.getElementById("fac").readOnly = true;
                document.getElementById("sede").readOnly = true;

                document.getElementById("esc").value = "";
                document.getElementById("fac").value = "";
                document.getElementById("sede").value = "";

                document.getElementById("esc").style.backgroundColor = '#e6e6e6 ';
                document.getElementById("spanescuela").innerHTML = "";
            }
        }

    </script>
    <div class=" panel-heading"><h3>Reporte Pagos</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <div class="panel-body form-group ">
                <form id="miform" action="{{'reportePago'}}" role="form" method="POST" class="Vertical">

                        <input type="hidden" name="_token" value="{{csrf_token() }}"/>
                        <div class=" row ">
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <span class=" control-label">Estado </span>
                            <select class="form-control" name="estado">
                                <option>Pagado</option>
                                <option>Devuelto</option>
                                <option>Eliminado</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <span class="control-label">Modalidad </span>
                            <select class=" form-control small" name="modalidad">
                                <option>Todo</option>
                                <option>Banco</option>
                                <option>Online</option>
                                <option>Ventanilla</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <span class="control-label">Clasificador o tasa</span>
                            <select class=" form-control" id="opcTramite" name="opcTramite">
                                <option value="Todo">Todo</option>
                                <option value="Clasificador">Clasificador</option>
                                <option value="Tasa">Tasa</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <script>
                                $('#opcTramite').change(function () {
                                    var value = $('#opcTramite option:selected').attr('value');
                                    if (value === 'Todo') {
                                        document.getElementById("input").readOnly = true;
                                        document.getElementById("input").style.backgroundColor = '#e6e6e6 ';
                                        document.getElementById("spaninput").innerHTML = "";
                                        document.getElementById("input").value = "";
                                    }
                                    else {
                                        document.getElementById("input").readOnly = false;
                                    }
                                });
                            </script>
                            @if(isset($Tram))
                                <span class="control-label"> &nbsp; </span>
                                <input type="text" class="typeahead form-control input-sm " id="input"
                                       name="inputTram"
                                       autocomplete="off" value="{{$Tram}}" readonly
                                       onchange=" validarNombre('input','spaninput')">
                                <span style="color: red" class=" control-label" id="spaninput"> </span>
                            @else
                                <span class="control-label">&nbsp; </span>
                                <input type="text" class="typeahead form-control input-sm " id="input"
                                       name="inputTram" onchange=" validarNombre('input','spaninput')"
                                       autocomplete="off" readonly>
                                <span style="color: red" class=" control-label" id="spaninput"> </span>
                            @endif
                            <script>
                                var path = "{{ route('autocompletet') }}";
                                var path2 = "{{ route('autocompletes') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        var value = $('#opcTramite option:selected').attr('value');
                                        if (value == 'Clasificador') {
                                            return $.get(path, {query: query}, function (data) {
                                                return process(data);
                                            });
                                        }
                                        else {
                                            if (value == 'Tasa') {
                                                return $.get(path2, {query: query}, function (data) {
                                                    return process(data);
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <span class=" control-label">Fecha desde:  </span>

                            <div class=" input-group date" data-provide="datepicker">
                                <input type="text" id="fecdesde" name="fechaDesde" class="form-control"
                                       autocomplete="off" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <span class=" control-label">Fecha hasta:  </span>

                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="fecHasta" name="fechaHasta" class="form-control"

                                       autocomplete="off" onchange="compararFechas('fecdesde','fecHasta','mensaje')"
                                       required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                        <div class="row  ">
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <input type="checkbox" id="ccp" onclick="habilitarCP(this.checked)">
                            Centro de produccion
                            @if(isset($produccion))
                                <input class="typeaheads form-control " name="cp" value="{{$produccion}}" id="cp"
                                       autocomplete="off" readonly onchange=" validarNombre('cp','spanproduccion')">
                                <span style="color: red" class=" control-label" id="spanproduccion"> </span>
                            @else
                                <input class="typeaheads form-control " name="cp" id="cp" autocomplete="off"
                                       readonly onchange=" validarNombre('cp','spanproduccion')">
                                <span style="color: red" class=" control-label" id="spanproduccion"> </span>
                            @endif
                            <script>
                                var pathcp = "{{ route('autocompleteprod')}}";
                                $('input.typeaheads').typeahead({
                                    source: function (querycp, processcp) {
                                        return $.get(pathcp, {query: querycp}, function (datacp) {
                                            return processcp(datacp);
                                        });
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <input type="checkbox" id="sed" onclick="habilitarsed(this.checked)">
                            Sede
                            @if(isset($sede))
                                <input class="typeaheads form-control " name="sed" value="{{$sede}}" id="sede"
                                       autocomplete="off" readonly onchange=" validarNombre('sede','spansede')">
                                <span style="color: red" class=" control-label" id="spansede"> </span>
                            @else
                                <input class="typeaheads form-control " name="sed" id="sede" autocomplete="off"
                                       readonly onchange=" validarNombre('sede','spansede')">
                                <span style="color: red" class=" control-label" id="spansede"> </span>
                            @endif
                            <script>
                                var pathsede = "{{ route('autocompletesede')}}";
                                $('input.typeaheads').typeahead({
                                    source: function (querys, processsede) {
                                        return $.get(pathsede, {query: querys}, function (datasede) {
                                            return processsede(datasede);
                                        });
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <input type="checkbox" id="cfac" onclick="habilitarfac(this.checked)">
                            facultad
                            @if(isset($fac))
                                <input class="form-control " name="fac" id="fac"
                                       value="{{$fac}}" readOnly onchange=" validarNombre('fac','spanfacultad')">
                                <span style="color: red" class=" control-label" id="spanfacultad"> </span>
                            @else
                                <input class="form-control " name="fac" id="fac"
                                       readOnly onchange=" validarNombre('fac','spanfacultad')">
                                <span style="color: red" class=" control-label" id="spanfacultad"> </span>
                            @endif
                            <script>
                                srcF = "{{ route('searchF') }}";
                                $('#fac').autocomplete({
                                    source: function (requestF, responseF) {
                                        $.ajax({
                                            url: srcF,
                                            type: 'get',
                                            dataType: "json",
                                            data: {
                                                term: $('#fac').val(),
                                                sede: $('#sede').val()
                                            },
                                            success: function (dataF) {
                                                responseF(dataF);
                                            }
                                        });
                                    },
                                    min_length: 1
                                });
                            </script>
                        </div>
                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <input type="checkbox" id="cesc" onclick=" habilitaresc(this.checked)">
                            Escuela
                            @if(isset($esc))
                                <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                       value="{{$esc}}" readOnly onchange=" validarNombre('esc','spanescuela')">
                                <span style="color: red" class=" control-label" id="spanescuela"> </span>
                            @else
                                <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                       readOnly onchange=" validarNombre('esc','spanescuela')">
                                <span style="color: red" class=" control-label" id="spanescuela"> </span>
                            @endif
                            <script>
                                srcE = "{{ route('searchE') }}";
                                $('#esc').autocomplete({
                                    source: function (requestE, responseE) {
                                        $.ajax({
                                            url: srcE,
                                            type: 'get',
                                            dataType: "json",
                                            data: {
                                                term: $('#esc').val(),
                                                facultad: $('#fac').val()
                                            },
                                            success: function (dataE) {
                                                responseE(dataE);
                                            }
                                        });
                                    },
                                    min_length: 1
                                });
                            </script>
                        </div>


                        <div class="form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <div class="form-group-sm ">
                                <input type="checkbox" id="ctr" onclick=" habilitartr(this.checked)">
                                Tipo recurso
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control input-sm " id="trinp" name="tr"
                                       autocomplete="off" onchange="validarNombre('trinp','spantr')"
                                       readOnly>
                                <span style="color: red" class=" control-label" id="spantr"> </span></div>

                        </div>
                        <div class="  form-group-sm col-sm-2 col-xs-2 col-lg-2">
                            <div class="form-group-sm ">
                                <input type="checkbox" id="cff" onclick="habilitarff(this.checked)">
                                Fuente financiamiento
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control input-sm " id="ff" name="fuf"
                                       autocomplete="off" readOnly onchange="validarNumeros('ff','spanff')">
                                <span style="color: red" class=" control-label" id="spanff"> </span>
                            </div>
                        </div>

                        <div class=" col-sm-12  col-xs-12 col-lg-12 row form-group " align="center">
                            <span id="mensaje" class="control-label" style="color: red"></span>
                        </div>
                    </div>
                        <div class="row col-sm-12 col-xs-12 col-lg-12" align="center">
                            <button type="submit" name="enviar" class=" btn btn-sm  btn-success"><span
                                        class="glyphicon glyphicon-refresh"></span> Actualizar
                            </button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class=" btn btn-sm btn-warning" onclick="limpiarCampos(this);">
                                <span class="glyphicon glyphicon-erase">
                                </span> Limpiar campos
                            </a>
                        </div>

                </form>
                <!--Tabla-->

                <div class="row   col-sm-12  col-xs-12 col-lg-12 row form-group ">
                    <div align="right">
                        Total : @if(isset($total) )S/. {{$total}} @else S/. 0.00 @endif
                    </div>
                </div>
                <div class="table-responsive col-sm-12 col-xs-12 col-lg-12">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                        <thead align="center">
                        <!--cabecear Tabla-->
                        <tr>

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
                                    <small>CLASIFICADOR</small>
                                </div>
                            </th>
                            <th>
                                <div align="center">
                                    <small>TASA</small>
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
                        <body>
                        @if(isset($result))
                            <!--Contenido-->
                            @foreach($result as $r)
                                <tr>
                                    <td><h6 align="center">{{$r->codigopago}}</h6></td>
                                    <td><h6 align="left">{{$r->modalidad}}</h6></td>
                                    <td><h6 align="left">{{$r->nombresede}}</h6></td>
                                    <td><h6 align="left">{{$r->nombrefacultad}}</h6></td>
                                    <td><h6 align="left">{{$r->nombreescuela}}</h6></td>
                                    <td><h6 align="left">{{$r->clasi}}</h6></td>
                                    <td><h6 align="center">{{$r->fuentefinanc}}</h6></td>
                                    <td><h6 align="center">{{$r->tiporecurso }}</h6></td>
                                    <td><h6 align="left">{{$r-> nombretramite}}</h6></td>
                                    <td><h6 align="left">{{$r->nombresubtramite }}</h6></td>
                                    <td><h6 align="left">{{$r->fechapago}}</h6></td>
                                    <td><h6 align="center">{{$r->precio}}</h6></td>
                                    <td><h6 align="left">{{$r->pagodetalle}}    </h6></td>
                                </tr>
                            @endforeach
                        @endif
                        </body>
                    </table>
                </div>

                <div class="row  col-sm-12 col-xs-12 col-lg-12" align="center">

                    <a href="{{url('/Adm')}}" class="btn btn-sm  btn-primary"><span
                                class="glyphicon glyphicon-arrow-left"></span> Regresar
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!--Contenido-->
                    @if(isset($encript))
                        <a href="exceldetallado/{{$encript}}"
                           class="btn btn-sm   btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir
                        </a>
                    @else
                        <a class="btn btn-sm   btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

@endsection
