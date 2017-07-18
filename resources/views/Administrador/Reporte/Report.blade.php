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
            if (value == true) {
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

            } else if (value == false) {
                document.getElementById("cp").readOnly = true;
                document.getElementById("cp").value = "";

            }
        }

        function habilitarff(value) {
            if (value == true) {
                document.getElementById("ff").readOnly = false;
            } else if (value == false) {
                document.getElementById("ff").readOnly = true;
                document.getElementById("ff").value = "";

            }
        }
        function habilitartr(value) {
            if (value == true) {
                document.getElementById("trinp").readOnly = false;
            } else if (value == false) {
                document.getElementById("trinp").readOnly = true;
                document.getElementById("trinp").value = "";
            }
        }
        function habilitarsed(value) {
            if (value == true) {
                document.getElementById("cp").value = "";
                document.getElementById("ccp").checked = false;
                document.getElementById("cp").readOnly = true;
                document.getElementById("sede").readOnly = false;
            } else if (value == false) {
                document.getElementById("sede").readOnly = true;
                document.getElementById("fac").readOnly = true;
                document.getElementById("esc").readOnly = true;

                document.getElementById("sede").value = "";
                document.getElementById("fac").value = "";
                document.getElementById("esc").value = "";


                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("cesc").checked = false;

            }
        }
        function habilitarfac(value) {

            if (value == true) {
                document.getElementById("ccp").checked = false;
                document.getElementById("sed").checked = false;
                document.getElementById("cp").readOnly = true;
                document.getElementById("cp").value = "";

                document.getElementById("sed").checked = true;
                document.getElementById("fac").readOnly = false;
                document.getElementById("sede").readOnly = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("fac").readOnly = true;
                document.getElementById("sede").readOnly = true;

                document.getElementById("fac").value = "";
                document.getElementById("sede").value = "";
            }
        }
        function habilitaresc(value) {
            if (value == true) {
                document.getElementById("ccp").checked = false;
                document.getElementById("cp").value = "";
                document.getElementById("cp").readOnly = true;
                document.getElementById("sed").checked = true;
                document.getElementById("cfac").checked = true;
                document.getElementById("fac").readOnly = false;
                document.getElementById("sede").readOnly = false;
                document.getElementById("esc").readOnly = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("cfac").checked = false;
                document.getElementById("esc").readOnly = true;
                document.getElementById("fac").readOnly = true;
                document.getElementById("sede").readOnly = true;

                document.getElementById("esc").value = "";
                document.getElementById("fac").value = "";
                document.getElementById("sede").value = "";

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
                        <div class="form-group-sm col-sm-2 ">
                            <span class=" control-label">Estado :</span>
                            <select class="form-control" name="estado">
                                <option>Pagado</option>
                                <option>Anulado</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <span class="control-label">Modalidad :</span>
                            <select class=" form-control small" name="modalidad">
                                <option>Todo</option>
                                <option>Banco</option>
                                <option>Online</option>
                                <option>Ventanilla</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <span class="control-label">Clasificador o tasa:</span>
                            <select class=" form-control" id="opcTramite" name="opcTramite">
                                <option value="Todo">Todo</option>
                                <option value="Clasificador">Clasificador</option>
                                <option value="Tasa">Tasa</option>
                            </select>

                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <script>
                                $('#opcTramite').change(function () {
                                    var value = $('#opcTramite option:selected').attr('value');
                                    document.getElementById("input").readOnly = value == 'Todo';
                                });
                            </script>
                            @if(isset($Tram))
                                <span class="control-label"> . </span>
                                <input type="text" class="typeahead form-control input-sm " id="input"
                                       name="inputTram"
                                       autocomplete="off" value="{{$Tram}}" readonly>
                            @else
                                <span class="control-label">. </span>
                                <input type="text" class="typeahead form-control input-sm " id="input"
                                       name="inputTram"
                                       autocomplete="off" readonly>
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
                        <div class="form-group-sm col-sm-2 ">
                            <span class=" control-label">Fecha desde:  </span>

                            <div class=" input-group date" data-provide="datepicker">
                                <input type="text" id="fecdesde" name="fechaDesde" class="form-control"
                                       autocomplete="off" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <span class=" control-label">Fecha hasta:  </span>

                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" id="fecHasta" name="fechaHasta" class="form-control"

                                       autocomplete="off" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row  ">
                        <div class="form-group-sm col-sm-2">
                            <input type="checkbox" id="ccp" onclick="habilitarCP(this.checked)">
                            Centro de produccion
                            @if(isset($produccion))
                                <input class="typeaheads form-control " name="cp" value="{{$produccion}}" id="cp"
                                       autocomplete="off" readonly>
                            @else
                                <input class="typeaheads form-control " name="cp" id="cp" autocomplete="off"
                                       readonly>
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
                        <div class="form-group-sm col-sm-2 ">
                            <input type="checkbox" id="sed" onclick="habilitarsed(this.checked)">
                            Sede
                            @if(isset($sede))
                                <input class="typeaheads form-control " name="sed" value="{{$sede}}" id="sede"
                                       autocomplete="off" readonly>
                            @else
                                <input class="typeaheads form-control " name="sed" id="sede" autocomplete="off"
                                       readonly>
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
                        <div class="form-group-sm col-sm-2 ">
                            <input type="checkbox" id="cfac" onclick="habilitarfac(this.checked)">
                            facultad
                            @if(isset($fac))
                                <input class="form-control " name="fac" id="fac"
                                       value="{{$fac}}" readOnly>
                            @else
                                <input class="form-control " name="fac" id="fac"
                                       readOnly>
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
                        <div class="form-group-sm col-sm-2">
                            <input type="checkbox" id="cesc" onclick=" habilitaresc(this.checked)">
                            Escuela
                            @if(isset($esc))
                                <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                       value="{{$esc}}" readOnly>
                            @else
                                <input class="typeahead form-control " name="esc" id="esc" autocomplete="off"
                                       readOnly>
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
                        <div class="form-group-sm col-sm-2">
                            <div class="form-group-sm col-sm-12">
                                <input type="checkbox" id="ctr" onclick=" habilitartr(this.checked)">

                                Tipo de recurso
                            </div>
                            <div class="form-group-sm col-sm-4">

                                <input type="text" class="form-control input-sm " id="trinp" name="tr"
                                       autocomplete="off"
                                       readOnly>
                            </div>

                        </div>
                        <div class="form-group-sm col-sm-2">
                            <div class="form-group-sm col-sm-12">
                                <input type="checkbox" id="cff" onclick="habilitarff(this.checked)">
                                Fuente de financiamiento
                            </div>

                            <div class="form-group-sm col-sm-4">
                                <input type="text" class="form-control input-sm " id="ff" name="fuf"
                                       autocomplete="off" readOnly>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class=" col-sm-4">

                        </div>
                        <div class="col-md-2 form-group-sm">
                            <button type="submit" name="enviar" class=" btn btn-success"><span
                                        class="glyphicon glyphicon-refresh"></span> Actualizar
                            </button>

                        </div>
                        <div class="col-md-2 form-group-sm">
                            <a class=" btn btn-warning" onclick="limpiarCampos(this);">
                                <span class="glyphicon glyphicon-erase">

                                </span> Limpiar campos
                            </a>
                        </div>
                        <div class="col-sm-4">

                        </div>
                    </div>
                </form>
                <!--Tabla-->

                <div align="center" class=" row  ">

                    <div class="col-sm-10"></div>

                    <div class="col-sm-2">
                        Total :
                        @if(isset($total) )
                            {{$total}}
                        @endif
                    </div>
                </div>
                <div class="table-responsive col-sm-12">
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
                        <tbody>
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
                                    <td><h6 align="left">{{$r->pagodetalle}}</h6></td>
                                </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
                </div>
                <div class="col-sm-12 row form-group">
                </div>
                <div class=" row ">
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <a href="{{url('/Adm')}}" class="btn btn-sm s-b-5  btn-primary"><span
                                    class="glyphicon glyphicon-arrow-left"></span> Regresar
                        </a>
                    </div>

                    <div class="col-md-2">
                        <!--Contenido-->
                        @if(isset($encript))
                            <a href="exceldetallado/{{$encript}}"
                               class="btn btn-sm s-b-5  btn-primary"><span
                                        class="glyphicon glyphicon-print"></span> Imprimir
                            </a>
                        @else
                            <a class="btn btn-sm s-b-5  btn-primary"><span
                                        class="glyphicon glyphicon-print"></span> Imprimir
                            </a>
                        @endif
                    </div>

                    <div class="col-md-3"></div>
                </div>

                <div class="col-md-5"></div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

@endsection
