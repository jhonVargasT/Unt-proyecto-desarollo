<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Boleta</title>
    <link rel="stylesheet" type="text/css" href="css/boleta.css">
</head>
<br><br><br>
<body>
<form name="form" action="{{url('datos')}}" role="form" method="POST" class="Vertical">
    {{csrf_field()}}
    <div align="center" id="printableArea">

        <table class="table">
            <tbody>
            <td><input type="hidden" name="buscar" value="{{$buscar}}" readonly></td>
            <td><input type="hidden" name="facultad" value="{{$facultad}}" readonly></td>
            <tr>
                <th>HE RECIBIDO DE:</th>
                <td>
                    <input name="nomape" value="{{$apellidos}}, {{$nombre}} " readonly>
                    <input type="hidden" name="apellidos" value="{{$apellidos}}" readonly>
                    <input type="hidden" name="nombres" value="{{$nombre}}" readonly>
                </td>
            </tr>
            <tr>
                <th>ESCUELA</th>
                <td><input name="escuela" value="Software" readonly></td>
            </tr>
            <tr>
                <th>POR CONCEPTO DE:</th>
                <td><input name="detalle" value="{{$detalle}}" readonly></td>
            </tr>
            <tr>
                <th>FECHA</th>
                <td><input name="fecha" value="{{$fecha}}" readonly></td>
            </tr>
            <tr>
                <th>MONTO</th>
                <td>
                    <input type="hidden" name="total" value="{{$total}}" readonly>
                    <input name="boleta" value="{{$boleta}}" readonly>
                </td>
            </tr>
            <tr>
                <th>CAJERO</th>
                <td><input name="cajero" value="{{Session::get('misession','No existe session')}}" readonly></td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div align="center">
        <button type="submit" id="togglee">Regresar</button>
    </div>
    <script>
        document.getElementById('togglee').style.visibility = 'hidden';
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        bool = printDiv('printableArea');
        setTimeout(function () {
            document.getElementById('togglee').style.visibility = 'visible';
        }, 450);

    </script>
</form>
</body>
</html>