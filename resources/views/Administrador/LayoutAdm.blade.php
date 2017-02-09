<!DOCTYPE html>
<html lang="en">
@if( Session::has('tipoCuentaA'))
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <title> Unt - Tesoreria </title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

    <script>window.Laravel =" <?php echo json_encode([
            'csrfToken' => csrf_token(),]); ?>"
    </script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</head>
<body style="background-color: #ccd0d2">
<div class="container container-fluid">
    <br>
    <div class="col-sm-12 panel panel-default ">
        <div class="col-sm-12 ">
            <div class="col-sm-3 ">
                <div>
                    <img src="{{ asset('assets/img/logo.png') }}">
                </div>
            </div>
            <div class="col-sm-9  " align="center">
                <br>
                <br>
                <br>
                <div>
                    <h1> UNIVERSIDAD NACIONAL DE TRUJILLO</h1>
                </div>
                <div>
                    <h3>Tesoreria - Administrador</h3>
                </div>
            </div>

        </div>

        <div class="col-sm-12 ">
            <hr>
            <br></div>

        <div class="col-sm-12 ">
            <div class=" col-sm-8">
                <div class="col-sm-5  ">
                    <h4 align="left">Bienvenido administrador(a) : </h4>
                </div>
                <div class="col-sm-4 " align="left">
                    <h4>{{Session::get('misession','No existe session')}}</h4>
                </div>
            </div>
            <div class="col-sm-4">

                <div class="col-sm-12" align="right">
                    <h4><a href="/cerrarSesion" class="glyphicon  glyphicon-log-out red" style="color: #cf1100"> Salir </a></h4>

                </div>
            </div>
        </div>
        <div class="col-sm-12 "><br></div>
    </div>
    <div class=" col-sm-12 panel panel-default">
        @yield('body')
    </div>
    <footer class="footer row col-sm-12">
        <p align="right">© 2016 ÑuxtuSoft, S.A.C.</p>
    </footer>
</div>
<!-- /#wrapper -->
<!-- /#wrapper -->
<!-- /#wrapper -->
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>

<!-- BOOTSTRAP SCRIPTS -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- METISMENU SCRIPTS -->
<script src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
<!-- MORRIS CHART SCRIPTS -->
<script src="{{asset('assets/js/morris/raphael-2.1.0.min.js')}}"></script>
<script src="{{asset('assets/js/morris/morris.js')}}"></script>
<!-- CUSTOM SCRIPTS -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<!-- Javascript -->
<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>

<!--[if lt IE 10]>
<script src="{{asset('assets/js/placeholder.js')}}"></script>
<![endif]-->

</body>
@else
    @include("index")
@endif
</html>