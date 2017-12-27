<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Boleta</title>
    <link rel="stylesheet" type="text/css" href="css/boleta.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
</head>
<br><br><br>
<body>
<form name="form" action="{{url('datos')}}" role="Form" method="POST" class="Vertical">
    {{csrf_field()}}
    <div id="printableArea">
        <table>
            <tr>
                <td>
                    <table>
                        <td><input type="hidden" name="facultad" value="{{$facultad}}" readonly></td>
                        <td><input type="hidden" name="apellidos" value="{{$apellidos}}" readonly id="apellidos"></td>
                        <td><input type="hidden" name="nombres" value="{{$nombre}}" readonly id="nombres"></td>
                        <td><input type="hidden" name="total" value="{{$total}}" readonly></td>
                        <td><input type="hidden" name="buscar" value="{{$buscar}}" readonly></td>
                        <td><input type="hidden" name="facultad" value="{{$facultad}}" readonly></td>
                        <td><input type="hidden" name="sede" value="{{$sede}}" readonly></td>
                        <td><input type="hidden" name="selected" value="{{$select}}" readonly></td>

                        <tr align="center">
                            <th colspan="2"><input name="contador" value="{{$contador}}" readonly id="contador"></th>
                        </tr>
                        <tr>
                            <th>SIAF:</th>
                            <th><input name="siaf" value="{{$siaf}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>RECIBIDO DE:</th>
                            <th><input name="nomape" value="{{$apellidos}}, {{$nombre}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>ESCUELA:</th>
                            <th><input name="escuela" value="{{$escuela}}" readonly id="escuela" size="45"></th>
                        </tr>
                        <tr>
                            <th>TASA:</th>
                            <th><textarea name="tasa" readonly rows="2" cols="45">{{$tasa}}</textarea></th>
                        </tr>
                        <tr>
                            <th>CONCEPTO:</th>
                            <th><input name="detalle" value="{{$detalle}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>FECHA:</th>
                            <th><input name="fecha" value="{{$fecha}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>MONTO:</th>
                            <th><input value="S/. {{$boleta}}" readonly size="45">
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input id="wo" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>CAJERO:</th>
                            <th><input name="cajero" value="{{Session::get('misession','No existe session')}}" readonly
                                       size="45">
                            </th>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr align="center">
                            <th colspan="2"><input name="contador" value="{{$contador}}" readonly id="contador"></th>
                        </tr>
                        <tr>
                            <th>SIAF:</th>
                            <th><input name="siaf" value="{{$siaf}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>RECIBIDO DE:</th>
                            <th><input name="nomape" value="{{$apellidos}}, {{$nombre}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>ESCUELA:</th>
                            <th><input name="escuela" value="{{$escuela}}" readonly id="escuela" size="45"></th>
                        </tr>
                        <tr>
                            <th>TASA:</th>
                            <th><textarea name="tasa" readonly rows="2" cols="45">{{$tasa}}</textarea></th>
                        </tr>
                        <tr>
                            <th>CONCEPTO:</th>
                            <th><input name="detalle" value="{{$detalle}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>FECHA:</th>
                            <th><input name="fecha" value="{{$fecha}}" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>MONTO:</th>
                            <th><input value="S/. {{$boleta}}" readonly size="45">
                                <input type="hidden" id="boleta" name="boleta" value="{{$boleta}}"
                                       onchange="updatePrice()"
                                       readonly>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input id="wo2" readonly size="45"></th>
                        </tr>
                        <tr>
                            <th>CAJERO:</th>
                            <th><input name="cajero" value="{{Session::get('misession','No existe session')}}" readonly
                                       size="45">
                            </th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div align="center">
        <button id="togglee">Regresar</button>
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

        printDiv('printableArea');
        setTimeout(function () {
            document.getElementById('togglee').style.visibility = 'visible';
        }, 450);
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#boleta").change(function () {
            /**
             * @return {string}
             */
            function Unidades(num) {

                switch (num) {
                    case 1:
                        return "un";
                    case 2:
                        return "dos";
                    case 3:
                        return "tres";
                    case 4:
                        return "cuatro";
                    case 5:
                        return "cinco";
                    case 6:
                        return "seis";
                    case 7:
                        return "siete";
                    case 8:
                        return "ocho";
                    case 9:
                        return "nueve";
                }
                return "";
            }//Unidades()

            /**
             * @return {string}
             */
            function Decenas(num) {
                decena = Math.floor(num / 10);
                unidad = num - (decena * 10);
                switch (decena) {
                    case 1:
                        switch (unidad) {
                            case 0:
                                return "diez";
                            case 1:
                                return "once";
                            case 2:
                                return "doce";
                            case 3:
                                return "trece";
                            case 4:
                                return "catorce";
                            case 5:
                                return "quince";
                            default:
                                return "dieci" + Unidades(unidad);
                        }
                    case 2:
                        switch (unidad) {
                            case 0:
                                return "veinte";
                            default:
                                return "veinti" + Unidades(unidad);
                        }
                    case 3:
                        return DecenasY("treinta", unidad);
                    case 4:
                        return DecenasY("cuarenta", unidad);
                    case 5:
                        return DecenasY("cincuenta", unidad);
                    case 6:
                        return DecenasY("sesenta", unidad);
                    case 7:
                        return DecenasY("setenta", unidad);
                    case 8:
                        return DecenasY("ochenta", unidad);
                    case 9:
                        return DecenasY("noventa", unidad);
                    case 0:
                        return Unidades(unidad);
                }
            }//Unidades()

            /**
             * @return {string}
             */
            function DecenasY(strSin, numUnidades) {
                if (numUnidades > 0)
                    return strSin + " y " + Unidades(numUnidades)

                return strSin;
            }//DecenasY()

            /**
             * @return {string}
             */
            function Centenas(num) {
                centenas = Math.floor(num / 100);
                decenas = num - (centenas * 100);

                switch (centenas) {
                    case 1:
                        if (decenas > 0)
                            return "ciento " + Decenas(decenas);
                        return "cien";
                    case 2:
                        return "doscientos " + Decenas(decenas);
                    case 3:
                        return "trescientos " + Decenas(decenas);
                    case 4:
                        return "cuatrocientos " + Decenas(decenas);
                    case 5:
                        return "quinientos " + Decenas(decenas);
                    case 6:
                        return "seiscientos " + Decenas(decenas);
                    case 7:
                        return "setecientos " + Decenas(decenas);
                    case 8:
                        return "ochocientos " + Decenas(decenas);
                    case 9:
                        return "novecientos " + Decenas(decenas);
                }
                return Decenas(decenas);
            }//Centenas()

            /**
             * @return {string}
             */
            function Seccion(num, divisor, strSingular, strPlural) {
                cientos = Math.floor(num / divisor);
                resto = num - (cientos * divisor);
                letras = "";
                if (cientos > 0)
                    if (cientos > 1)
                        letras = Centenas(cientos) + "" + strPlural;
                    else
                        letras = strSingular;
                if (resto > 0)
                    letras += "";
                return letras;
            }//Seccion()

            /**
             * @return {string}
             */
            function Miles(num) {
                divisor = 1000;
                cientos = Math.floor(num / divisor);
                resto = num - (cientos * divisor);
                strMiles = Seccion(num, divisor, "mil", "mil");
                strCentenas = Centenas(resto);
                if (strMiles === "")
                    return strCentenas;
                return strMiles + "" + strCentenas;
            }//Miles()

            /**
             * @return {string}
             */
            function Millones(num) {
                divisor = 1000000;
                cientos = Math.floor(num / divisor);
                resto = num - (cientos * divisor);
                strMillones = Seccion(num, divisor, "un millon de", "millones de");
                strMiles = Miles(resto);
                if (strMillones === "")
                    return strMiles;

                return strMillones + "" + strMiles;
            }//Millones()

            /**
             * @return {string}
             */
            function NumeroALetras(num) {
                var data = {
                    numero: num,
                    enteros: Math.floor(num),
                    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
                    letrasCentavos: "",
                    letrasMonedaPlural: 'soles',//“PESOS”, 'Dólares', 'Bolívares', 'etcs'
                    letrasMonedaSingular: 'sol', //“PESO”, 'Dólar', 'Bolivar', 'etc'

                    letrasMonedaCentavoPlural: "centimos",
                    letrasMonedaCentavoSingular: "centimo"
                };

                if (data.centavos > 0) {
                    data.letrasCentavos = "con" + (function () {
                        if (data.centavos === 1)
                            return Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular;
                        else
                            return Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural;
                    })();
                }
                if (data.enteros === 0)
                    return "CERO" + data.letrasMonedaPlural + " " + data.letrasCentavos;
                if (data.enteros === 1)
                    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
                else
                    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
            }//NumeroALetras()

            var val = $("#boleta").val();

            var total = NumeroALetras(val);

            $("#wo").val(total);
            $("#wo2").val(total);
        });


        function updatePrice(val) {
            $("#boleta").val(val);
            $("#boleta").trigger('change');
        }

        updatePrice($("#boleta").val());

        document.getElementById('togglee').click();

    </script>
</form>
</body>
</html>