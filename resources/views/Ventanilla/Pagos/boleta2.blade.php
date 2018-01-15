<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Boleta</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
</head>
<br><br><br>
<body>
<form name="form" action="{{url('datos')}}" role="Form" method="POST" class="Vertical">
    {{csrf_field()}}
    <td><input type="hidden" name="facultad" value="{{$facultad}}" readonly></td>
    <td><input type="hidden" name="apellidos" value="{{$apellidos}}" readonly id="apellidos"></td>
    <td><input type="hidden" name="nombres" value="{{$nombre}}" readonly id="nombres"></td>
    <td><input type="hidden" name="total" value="{{$total}}" readonly></td>
    <td><input type="hidden" name="buscar" value="{{$buscar}}" readonly></td>
    <td><input type="hidden" name="facultad" value="{{$facultad}}" readonly></td>
    <td><input type="hidden" name="sede" value="{{$sede}}" readonly></td>
    <td><input type="hidden" name="selected" value="{{$select}}" readonly></td>

    <div id="printableArea" align="center">
        <table border="1">
            <tr>
                <td>
                    <table id="left">
                        <tr align="center">
                            <th colspan="2"><input name="contador" value="{{$contador}}" readonly id="contador"></th>
                        </tr>
                        <tr align="left">
                            <th>SIAF:</th>
                            <th><input name="siaf" value="{{$siaf}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>NOMBRES:</th>
                            <th><input name="nomape" value="{{$nombre}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>APELLIDOS:</th>
                            <th><input name="nomape" value="{{$apellidos}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>ESCUELA:</th>
                            <th><input name="escuela" value="{{$escuela}}" readonly id="escuela" size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>CONCEPTO:</th>
                            <th><textarea name="tasa" readonly rows="2" cols="58">{{$tasa}}</textarea></th>
                        </tr>
                        <tr align="left">
                            <th>DETALLE:</th>
                            <th><input name="detalle" value="{{$detalle}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>FECHA:</th>
                            <th><input name="fecha" value="{{Carbon\Carbon::parse($fecha)->format('d-m-Y H:i:s')}}"
                                       readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>MONTO:</th>
                            <th><input value="S/. {{$boleta}}" readonly size="76">
                            </th>
                        </tr>
                        <tr align="left">
                            <th></th>
                            <th><input id="wo" readonly size="76"
                                       value="{{$letras = NumeroALetras::convertir($boleta, 'SOLES', 'CENTIMOS')}}">
                            </th>
                        </tr>
                        <tr align="left">
                            <th>CAJERO:</th>
                            <th><input name="cajero" value="{{Session::get('misession','No existe session')}}" readonly
                                       size="76">
                            </th>
                        </tr>
                    </table>
                </td>
                <td>
                    <table id="right">
                        <tr align="center">
                            <th colspan="2"><input name="contador" value="{{$contador}}" readonly id="contador"></th>
                        </tr>
                        <tr align="left">
                            <th>SIAF:</th>
                            <th><input name="siaf" value="{{$siaf}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>NOMBRES:</th>
                            <th><input name="nomape" value="{{$nombre}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>APELLIDOS:</th>
                            <th><input name="nomape" value="{{$apellidos}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>ESCUELA:</th>
                            <th><input name="escuela" value="{{$escuela}}" readonly id="escuela" size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>CONCEPTO:</th>
                            <th><textarea name="tasa" readonly rows="2" cols="58">{{$tasa}}</textarea></th>
                        </tr>
                        <tr align="left">
                            <th>DETALLE:</th>
                            <th><input name="detalle" value="{{$detalle}}" readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>FECHA:</th>
                            <th><input name="fecha" value="{{Carbon\Carbon::parse($fecha)->format('d-m-Y H:i:s')}}"
                                       readonly size="76"></th>
                        </tr>
                        <tr align="left">
                            <th>MONTO:</th>
                            <th><input value="S/. {{$boleta}}" readonly size="76">
                                <input type="hidden" id="boleta" name="boleta" value="{{$boleta}}" readonly size="76">
                            </th>
                        </tr>
                        <tr align="left">
                            <th></th>
                            <th><input id="wo" readonly size="76"
                                       value="{{$letras = NumeroALetras::convertir($boleta, 'SOLES', 'CENTIMOS')}}">
                            </th>
                        </tr>
                        <tr align="left">
                            <th>CAJERO:</th>
                            <th><input name="cajero" value="{{Session::get('misession','No existe session')}}" readonly
                                       size="76">
                            </th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <style>
        #left{
            margin-left: 34px;
            margin-right: 34px;
        }
        #right{
            margin-left: 34px;
            margin-right: 34px;
        }
    </style>
    <div align="center">
        <button id="togglee"></button>
    </div>
    <script>
        printDiv('printableArea');
        setTimeout(function () {
            document.getElementById('togglee').style.visibility = 'visible';
        }, 450);
        //document.getElementById('togglee').click();
    </script>
</form>
</body>
</html>