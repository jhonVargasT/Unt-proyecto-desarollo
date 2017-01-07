<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tesoreria-Unt</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <!-- Bootstrap theme -->
    <link href="{{asset('asset/css/bootstrap-theme.min.css')}}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{asset('asset/css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('theme.css')}}" rel="stylesheet">
    <script src="{{asset('asset/js/ie-emulation-modes-warning.js')}}"></script>

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
    <div class="row " ><!--Cabecera-->
        <div>
            <h1> Tesoreria unt</h1>
        </div>
    </div>
    <div><!--cuerpo-->

    </div>








<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{assets('asset/js/vendor/jquery.min.js')}}"><\/script>')</script>
<script src="{{assets('dist/js/bootstrap.min.js')}}"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->

<footer class="footer">
    <p>© 2016 Company, Inc.</p>
</footer>
</body>
</iframe>
</html>