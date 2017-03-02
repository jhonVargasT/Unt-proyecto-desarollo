<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logear</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{asset('assets/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="´{{asset('assets/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{asset('assets/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/ico/apple-touch-icon-57-precomposed.png')}}">
    <script>window.Laravel = "<?php echo json_encode([
                'csrfToken' => csrf_token(),]); ?>"
    </script>
    <script>
        $(document).ready(function () {
            $('#fecha').datepicker();
        });
    </script>
</head>

<body style="background-color:  #ccd0d2">
<!-- Top content -->
<div class="container col-sm-12">
    <div class="container col-sm-12"><br> <br> <br> <br> <br> <br> <br> <br><br></div>
    <div class="container col-sm-12">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading" align="left">Por favor ingrese sus datos</div>
                <div class="panel-body">
                    @if(session()->has('true'))
                        <div class="alert alert-danger" role="alert">{{session('true')}} </div>
                    @endif
                    <div class="col-sm-5">
                        <div class="col-sm-12"><strong> UNIVERSIDAD NACIONAL DE TRUJILLO </strong></div>

                        <div class="col-sm-12">
                            <img src="{{ asset('assets/img/logo.png') }}">
                        </div>
                        <div class="col-sm-12"> Tesoreria</div>
                    </div>
                    <div class="col-sm-7">
                        <form action="{{url('/loguear')}}" role="form" method="POST" class="Vertical">
                            {{csrf_field()}}
                            <div class="col-sm-12" align="left">
                                <label for="inputEmail">Cuenta :</label>
                                <input type="text" name="cuenta" class="form-control" placeholder="Ejemp: admin"
                                       required=""
                                       autofocus="">
                            </div>
                            <div class="col-sm-12" align="left">
                                <label for="inputPassword">Contraseña :</label>
                                <input align="center" type="password" name="password" class="form-control"
                                       placeholder="Contraseña" required="">
                                <br>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <button class="btn btn-sm btn-primary btn-block " type="submit">Ingresar</button>
                                </div>
                                <div class="col-sm-3"></div>

                            </div>
                        </form>
                    </div>

                </div>
                <br>
            </div>
            <footer class="footer row col-xs-12">
                <p align="right">© 2016 ÑuxtuSoft, S.A.C.</p>
            </footer>
        </div>
        <div class="col-sm-4"></div>
    </div>
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
