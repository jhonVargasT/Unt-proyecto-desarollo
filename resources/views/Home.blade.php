
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
<?php
        $space = ' ';
foreach ($personal as $per) {
    $usern= $per->nombres;
    $usera= $per->apellidos;
}
if($per!=null)
    {?>
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
                    <p> Hello, <?php echo $usern; echo $space; echo $usera?>   </p>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<script src="{{asset('asset/js/ie10-viewport-bug-workaround.js')}}"></script>
<?php }?>
</body>
</html>
