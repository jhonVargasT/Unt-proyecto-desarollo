
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Autenticar</div>
                <div class="panel-body">
                    <form class="form-signin " action="{{ url('Index') }}" method="get">
                        <h2 class="form-signin-heading">Porfavor digite sus datos</h2>
                        <label for="cuenta" class="sr-only">Cuenta</label>
                        <input type="text" name="cuenta" class="form-control" placeholder="Cuenta" required >
                        <br>
                        <label for="contraseña" class="sr-only">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me"> Recuerdame
                            </label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<script src="{{asset('asset/js/ie10-viewport-bug-workaround.js')}}"></script>
</body>
</html>
