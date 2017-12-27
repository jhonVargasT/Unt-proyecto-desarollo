<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
    <title>Test Nuevo Bot&oacute;n de Pago</title>
</head>
<body>
<form name="form" action="{{url('/visaPago')}}" role="form" method="POST" class="Horizontal">
    {{csrf_field()}}
    <input type="tel" class="button" name="amount" value="1.00">
    <input type="submit" name="enviar" value="Crear bot&oacute;n">
</form>
</body>
</html>