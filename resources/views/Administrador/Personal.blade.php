
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tesoreria-Unt</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),]); ?>
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" >
    <div >
        <a  class="navbar-brand"> Universidad Nacional de Trujillo -Tesoreria </a>
    </div><!--/.container-fluid -->
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Autenticar</div>
                <div class="panel-body">
                    <form class="form-signin " action="{{ url('registrado') }}" method="post">
                        {{ csrf_field() }}
                        <h2 class="form-signin-heading">Porfavor digite sus datos</h2>
                        <label for="dni" class="sr-only">DNI</label>
                        <input type="text" name="dni" class="form-control" placeholder="DNI" required >
                        <br>
                        <label for="nombres" class="sr-only">Nombres</label>
                        <input type="text" name="nombres" class="form-control" placeholder="Nombres" required >
                        <br>
                        <label for="apellidos" class="sr-only">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                        <br>
                        <label for="cuenta" class="sr-only">Cuenta</label>
                        <input type="text" name="cuenta" class="form-control" placeholder="Cuenta" required>
                        <br>
                        <label for="contraseña" class="sr-only">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                        <br>
                        <label for="tipocuenta" class="sr-only">Tipo de Cuenta</label>
                        <select for="tipocuenta" class="sr-only" name="tipocuenta">
                            <option selected disabled>Seleccionar</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Personal">Personal</option>
                        </select>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<script src="{{asset('asset/js/ie10-viewport-bug-workaround.js')}}"></script>
</body>
</html>
