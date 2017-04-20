<!DOCTYPE html>
<html lang="en">
@if( Session::has('tipoCuentaA'))
    <head>
        <style>
            body {overflow-x:hidden!important;}
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
        <title> Unt - Tesoreria </title>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

        <title>Velonic - Responsive Admin Dashboard Template</title>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}"  rel="stylesheet">


        <!--Animation css-->
        <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="{{asset('assets/css/font-awesome.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/ionicon/css/ionicons.min.css')}}" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{asset('assets/morris/morris.css')}}">


        <!-- Custom styles for this template -->

        <link href="{{asset('assets/css/style-responsive.css')}}" rel="stylesheet" />
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-62751496-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body style="background-color:#ccd0d2" >
        <div class="row  " >
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
            <div class="row "   style="background-color: #FFFFFF">
                <div class="col-sm-2 col-xs-2 col-lg-2 " align="center">
                    <h3 >Bienvenido : </h3>
                </div>
                <div class="col-sm-1 col-xs-1 col-lg-1"></div>
                <div class="col-sm-5 col-xs-5 col-lg-5" align="left">
                    <h3>{{Session::get('misession','No existe session')}}</h3>
                </div>
                <div class="col-sm-2 col-xs-2 col-lg-2">
                </div>
                <div class="col-sm-2 col-xs-2 col-lg-2" align="center">
                    <h3> <a href="/cerrarSesion" class="glyphicon  glyphicon-log-out red" style="color: #cf1100">
                            Salir </a></h3>
                </div>
            </div>
        </div>
            @yield('body')
            <footer class="footer row col-sm-12 col-xs-12 col-lg-12">
                <p align="right">© 2016 ÑuxtuSoft, S.A.C.</p>
            </footer>

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

    <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <!-- Javascript -->
    <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>

    <script src="{{asset('assets/js/placeholder.js')}}"></script>
    <![endif]-->
    @yield('scripts')
    </body>
@else
    @include("index")
@endif
</html>