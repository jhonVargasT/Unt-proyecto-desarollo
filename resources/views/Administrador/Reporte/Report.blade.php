@extends('Administrador.Body')
@section('reportes')
    <div id="collapseOne" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <a href="/admReportres" ><span
                                    class="glyphicon glyphicon-book"></span> Reporte Resumido</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/admReportes" style="color: #509f0c" target="_top"> <span class="glyphicon glyphicon-list-alt"></span> Reporte pagos
                            detallado</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class=" panel-heading"> <h3>Reporte Pagos</h3></div>
    <div  style="background-color: #FFFFFF" >
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
                                    <option value="Todo">Todo</option>
                                    <option value="Tramite">Clasificador</option>
                                    <option value="SubTramite">Tasa</option>
                                </select>
                            </div>
                            <script>
                                $('#opcTramite').change(function () {
                                    var value = $('#opcTramite option:selected').attr('value');
                                    document.getElementById("input").readOnly = value == 'Todo';
                                });
                            </script>
                            <div class="col-sm-1 ">
                            </div>
                            <div class="col-sm-7">
                                @if(isset($Tram))
                                    <input type="text" class="typeahead form-control input-sm " id="input"
                                           name="inputTram"
                                           autocomplete="off" value="{{$Tram}}" readonly>
                                @else
                                    <input type="text" class="typeahead form-control input-sm " id="input"
                                           name="inputTram"
                                           autocomplete="off" readonly>
                                @endif
                            </div>
                            <script>
                                var path = "{{ route('autocompletet') }}";
                                var path2 = "{{ route('autocompletes') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        var value = $('#opcTramite option:selected').attr('value');
                                        if (value == 'Tramite') {
                                            return $.get(path, {query: query}, function (data) {
                                                return process(data);
                                            });
                                        }
                                        else {
                                            if (value == 'SubTramite') {
                                                return $.get(path2, {query: query}, function (data) {
                                                    return process(data);
                                                });
                                            }
                                        }
                                    }
                                });
                            </script>
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
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cfac" onclick="habilitarfac(this.checked)">
                                facultad
                            </div>
                            <div class="col-sm-7 ">
                                @if(isset($fac))
                                    <input class="form-control " name="fac" id="fac"
                                           value="{{$fac}}" readOnly>
                                @else
                                    <input class="form-control " name="fac" id="fac"
                                           readOnly>
                                @endif
                                <script>
                                    src = "{{ route('searchF') }}";
                                    $('#fac').autocomplete({
                                        source: function (request, response) {
                                            $.ajax({
                                                url: src,
                                                type: 'get',
                                                dataType: "json",
                                                data: {
                                                    term: $('#fac').val(),
                                                    sede: $('#sede').val()
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                            });
                                        },
                                        min_length: 1
                                    });
                                </script>
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
                        </div>
                        <div class="form-group-sm col-sm-4 ">

                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-4">
                                <input type="checkbox" onclick=" habilitartr(this.checked)">
                                Tipo de recurso
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control input-sm " id="trinp" name="tr"
                                       autocomplete="off"
                                       readOnly>
                            </div>
                            <div class="col-sm-4">
                                <input type="checkbox" onclick="habilitarff(this.checked)">
                                Fuente de financiamiento
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control input-sm " id="ff" name="fuf"
                                       autocomplete="off" readOnly>
                            </div>
                        </div>

                        <div class="form-group-sm col-sm-1 ">
                            <span class="col-sm-12 control-label">Fecha:  </span>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaDesde" class="form-control" placeholder="desde"
                                       autocomplete="off" required>
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
                            <div class="col-lg-4"></div>
                            <button type="submit" name="enviar" class="col-lg-4 btn btn-success"><span
                                        class="glyphicon glyphicon-refresh"></span> Actualizar
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
                                            <small>NOMBRE CLASIFICADOR</small>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="center">
                                            <small>NOMBRE TASA</small>
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
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <a href="{{url('/Adm')}}" class="btn  btn-primary"><span
                                        class="glyphicon glyphicon-arrow-left"></span> Regresar
                            </a>
                        </div>
                        </div>

                        <div class="col-md-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">

        function limpiarCampos() {
            var x = '1';
            document.getElementById("fac").innerHTML = x;
            document.getElementById("sede").innerHTML = x;
            document.getElementById("esc").innerHTML = x;
        }
        function habilitarff(value) {
            if (value == true) {
                document.getElementById("ff").readOnly = false;
            } else if (value == false) {
                document.getElementById("ff").readOnly = true;
            }
        }
        function habilitartr(value) {
            if (value == true) {
                document.getElementById("trinp").readOnly = false;
            } else if (value == false) {
                document.getElementById("trinp").readOnly = true;
            }
        }
        function habilitarsed(value) {
            if (value == true) {
                document.getElementById("sede").readOnly = false;
            } else if (value == false) {
                document.getElementById("sede").readOnly = true;
            }
        }
        function habilitarfac(value) {

            if (value == true) {
                document.getElementById("sed").checked = true;
                document.getElementById("fac").readOnly = false;
                document.getElementById("sede").readOnly = false;
            } else if (value == false) {
                document.getElementById("sed").checked = false;
                document.getElementById("fac").readOnly = true;
                document.getElementById("sede").readOnly = true;
            }
        }
        function habilitaresc(value) {
            if (value == true) {
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
            }
        }
    </script>

@endsection
