
@extends('Administrador/Body')
@section('body')
    <br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <div class="panel panel-primary">
        <div class="panel panel-heading"> Reporte Pagos</div>
        <div class="panel-body">
            <div class="panel-body form-group ">
                <form action="{{'reportePago'}}" role="form" method="POST" class="Vertical">
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
                                <select class=" form-control" name="opcTramite">
                                    <option>Todo</option>
                                    <option>Tramite</option>
                                    <option>SubTramite</option>
                                </select>
                            </div><div class="col-sm-1 ">

                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm " id="input" name="inputTram"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 row form-group ">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cb">
                                Sede
                            </div>
                            <div class="col-sm-7 ">
                                <input class="typeahead form-control " name="sed" id="sede" autocomplete="off">

                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cb">
                                facultad
                            </div>
                            <div class="col-sm-7 ">
                                <input class="typeahead form-control " name="fac" id="fac" autocomplete="off">

                            </div>
                        </div>

                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-5">
                                <input type="checkbox" id="cb">
                                Escuela
                            </div>
                            <div class="col-sm-7 ">
                                <input class="typeahead form-control " name="esc" id="esc" autocomplete="off">

                            </div>
                        </div>
                        <div class="form-group-sm col-sm-4 ">

                        </div>
                    </div>
                    <div class="col-sm-12 row form-group">
                        <div class="form-group-sm col-sm-4 ">
                            <div class="col-sm-4">
                                <input type="checkbox" id="cbtr">
                                Tipo de recurso
                            </div>
                            <div class="col-sm-2">
                                <script>
                                    $('#cbtr').change(function () {
                                        if ($(this).is(':checked')) {
                                            $('#tr').prop('disabled', false);
                                        } else {
                                            $('#tr').prop('disabled', true);
                                        }
                                    });
                                </script>
                                <input type="text" class="form-control input-sm " id="tr" name="tr" autocomplete="off"
                                       disabled="true">
                            </div>
                            <div class="col-sm-4">
                                <input type="checkbox" id="fuf"  autocomplete="off">
                                Fuente de financiamiento
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control input-sm " id="ff" name="fuf"
                                       autocomplete="off" >
                            </div>
                        </div>

                        <div class="form-group-sm col-sm-1 ">
                            <span class="col-sm-12 control-label">Fecha:  </span>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaDesde" class="form-control" placeholder="desde"
                                       autocomplete="off" value="03/01/2017" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group-sm col-sm-2 ">
                            <div class="col-sm-8 input-group date" data-provide="datepicker">
                                <input type="text" name="fechaHasta" class="form-control"
                                       placeholder="hasta"
                                       autocomplete="off"  value="03/18/2017" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class=" col-sm-5"></div>
                        <div class="col-md-2">

                            <button type="submit" name="enviar" class="col-lg-6 btn btn-success"><span
                                        class="glyphicon glyphicon-search"></span> Buscar
                            </button>
                        </div>
                        <div class="col-sm-5"></div>
                    </div>
                </form>
                <!--Tabla-->
                <br>
                <br>
                <div class="col-sm-12 row form-group ">
                    <br>
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
                <div align="center" class="col-sm-12 row form-group ">
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
                                            <small>FECHA </small>
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
                                    <th>
                                        <div align="center">
                                            <small>Opciones</small>
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
                                        <td><h6 align="left">{{$r->nombrefacultad }}</h6></td>
                                        <td><h6 align="left">{{$r->nombreescuela}}</h6></td>
                                        <td><h6 align="left">{{$r->clasi}}</h6></td>
                                        <td><h6 align="center">{{$r->fuente }}</h6></td>
                                        <td><h6 align="center">{{$r->tipre}}</h6></td>
                                        <td><h6 align="left">{{$r-> nombretramite}}</h6></td>
                                        <td><h6 align="left">{{$r->nombresubtramite }}</h6></td>
                                        <td><h6 align="left">{{$r->fechapago}}</h6></td>
                                        <td><h6 align="left">{{$r->precio}}</h6></td>
                                        <td><h6 align="left">{{$r->pagodetalle}}</h6></td>
                                        <td align="center">
                                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> </a>
                                            <a href="#"><span class="glyphicon glyphicon-trash"></span> </a>
                                        </td>

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
        var path = "{{ route('autocomplete') }}";
        $('#fac').typeahead({
            source: function (query, process) {
                return $.get(path, {query: query}, function (data) {
                    return process(data);
                });
            }
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#fac').click(function () {
                $(get('LlenarFacultad', data, function (result) {
                    alert('123123');
                }));
            });
        });

        $('#fac').change(function () {
            $.ajax({
                url: 'LlenarFacultad',
                type: "get",
                data: {name: $('#fac').val()},
                success: function (data) {
                    $('#fac').val(data);
                }
            });
        });
    </script>

@endsection
