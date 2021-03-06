<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

    <script>window.Laravel = '<?php echo json_encode([
            'csrfToken' => csrf_token(),]); ?>';
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body style="background-color: #ccd0d2">
<div>
    <div class="row ">
        <div class="row " style="background-color: #FFFFFF">
            <br>
            <div class="col-sm-1 col-xs-1 col-lg-1"></div>
            <div class="col-sm-1 col-xs-1 col-lg-1" >

                <img style="width: 200px;"src="{{ asset('assets/img/logo.png') }}">

            </div>
            <div class="col-sm-1 col-xs-1 col-lg-1"></div>
            <div class="col-sm-8 col-xs-8 col-lg-8" align="center">
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
                <div class="col-sm-3  ">
                    <h4 align="left">Bienvenido(a)</h4>
                </div>
            </div>
            <div class="col-sm-4">
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
</html>