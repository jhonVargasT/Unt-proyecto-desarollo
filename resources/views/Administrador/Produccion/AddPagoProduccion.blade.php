@extends('Administrador.Body')
@section('produccion')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/admBuscarProduccion">Buscar Centro de Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarProduccion">Agregar Centro de
                            Produccion</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/admRegistrarProduccionPagos"  style="color: #509f0c" target="_top">Agregar Produccion pagos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    <div class="panel-heading"><h3>Agregar Pago Produccion</h3>
    </div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

            <form name="form"
                  onsubmit="activarbotonform(event,['spansiaf','spanmonto','spanresolucion','spancuenta'],'enviar','mensaje')"
                  action="{{url('/PagoProduccion')}}" role="form" method="POST" class="Horizontal">
                {{csrf_field()}}
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
            @endif
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Centro de Produccion</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm " align="left">
                                <div class="col-sm-2">
                                    <span class=" control-label">Centro de Produccion</span>
                                    <select id="produccion" class="form-control " name="produccion" required>
                                        <option disabled>Seleccionar..</option>
                                    </select>
                                </div>
                                <script>
                                    $.ajax({
                                        url: '/obtenerProduccion',
                                        type: "get",
                                        data: '',
                                        success: function (data) {
                                            var select = document.getElementById('produccion');
                                            for (var i = 0; i < data.length; i++) {
                                                option = document.createElement('option');
                                                option.value = option.text = data[i];
                                                select.add(option);
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel  panel-primary">
                    <div class="panel-heading">Datos Tasa</div>
                    <div class="panel-body">
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm">
                                <div class="col-sm-2 ">
                                    <select class=" form-group-sm form-control" id="selectt" name="selectt">
                                        <option value="Codigo tasa"> Codigo tasa</option>
                                        <option value="Nombre tasa"> Nombre tasa</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input class="typeahead form-control" name="txtsub" id="ts" required>
                                    <script>
                                        var path = "{{ route('autocompletes') }}";
                                        $('input.typeahead').typeahead({
                                            source: function (query, process) {
                                                return $.get(path, {query: query}, function (data) {
                                                    var value = $('#selectt option:selected').attr('value');
                                                    if (value == 'Nombre tasa') {
                                                        return process(data);
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                    <script>
                                        $('#selectt').change(function () {
                                            var value = $('#selectt option:selected').attr('value');
                                            if (value == 'Codigo tasa') {
                                                var y = document.getElementById("st");
                                                y.type = "text";
                                                document.getElementById("nsub").style.visibility = "visible";
                                            }
                                            else {
                                                if (value == 'Nombre tasa') {
                                                    var x = document.getElementById("st");
                                                    x.type = "hidden";
                                                    document.getElementById("nsub").style.visibility = "hidden";
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                                <script>
                                    $('#ts').change(function () {
                                        var value = $('#selectt option:selected').attr('value');
                                        if (value === 'Codigo tasa') {
                                            var id = $('#ts').val();
                                            $.ajax({
                                                url: "/nombreSCT",
                                                type: "get",
                                                data: {ct: id},
                                                success: function (data) {
                                                    $('#st').val(data);
                                                    $.ajax({
                                                        url: '/precioSubtramite',
                                                        type: "get",
                                                        data: {name: $('#st').val()},
                                                        success: function (data) {
                                                            $('#bp').val(data);
                                                            var val = data * 100;
                                                            $('#p').val(val);
                                                            $('#pg').val(data);
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                        else {
                                            if (value === 'Nombre tasa') {
                                                $.ajax({
                                                    url: '/precioSubtramite',
                                                    type: "get",
                                                    data: {name: $('#ts').val()},
                                                    success: function (data) {
                                                        if (data === 0) {
                                                            $('#bp').val(data);
                                                            var val = data * 100;
                                                            $('#p').val(val);
                                                            $('#pg').val(data);
                                                        }
                                                        else {
                                                            $('#bp').val(data);
                                                            var val = data * 100;
                                                            $('#p').val(val);
                                                            $('#pg').val(data);
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm" id="nsub">
                                <span class="col-sm-2" >Nombre de tasa:</span>
                                <div class="col-sm-7">
                                    <input class="form-control" name="subtramite" id="st" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row form-group">
                            <div class="form-group-sm">
                                <span class="col-sm-2">Detalle:</span>
                                <div class="col-sm-3">
                                <textarea class="form-control input-sm" name="detalle" placeholder="Detalle"
                                          id="detalle"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 row form-group">
                            <div class="form-group-sm">
                                <span class="col-sm-2">Costo de boleta:</span>
                                <div class="col-sm-1">
                                    S/.
                                </div>
                                <div class="col-sm-1">
                                    <input class="form-control" name="boletapagar" id="bp"
                                           readonly>
                                </div>
                                <div class="col-sm-1">
                                    x
                                </div>
                                <div class="col-sm-1">
                                    <input class="form-control" name="multiplicador" id="mp" value="1"
                                           onkeypress="return validarNum(event)">
                                </div>
                                <div class="col-sm-1">
                                    =
                                </div>
                                <div class="col-sm-1">
                                    <input class="form-control" name="pagar" id="pg" readonly>
                                </div>
                                <script>
                                    $('#mp').change(function () {
                                        var n2 = $('#mp').val();
                                        var n1 = $('#bp').val();
                                        var r = n1 * n2;
                                        $('#pg').val(r);
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-sm-12 row form-group" align="center">
                    <span id="mensaje" class="control-label" style="color: red"></span>
                </div>
                <div class=" row " align="center">

                    <a href="{{url('/Adm')}}" class=" btn btn-sm btn-danger"><span
                                class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit"
                            onmouseover="activarbotonform(null,['spansiaf','spanmonto','spanresolucion','spancuenta'],'enviar','mensaje')"
                            name="enviar" class="btn  btn-success" id="enviar"><span
                                class="glyphicon glyphicon-ok"></span> Guardar
                    </button>

                </div>
            </form>
        </div>
    </div>
@stop