<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="cache-control" content="no-store" />
    <meta http-equiv="cache-control" content="must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{asset('assets/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="´{{asset('assets/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{asset('assets/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/ico/apple-touch-icon-57-precomposed.png')}}">


</head>

<body style="background-color:  #ccd0d2">
<!-- Top content -->
<div class="row">
    <div class="row" style="width:100px; height:100px">

    </div>
    <div style="width: 40%;height: 200px;  margin: 0 auto;left: 100px;
 top: 50px;">
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
                                  autocomplete="off"  required>
                        </div>
                        <div class="col-sm-12" align="left">
                            <label for="inputPassword">Contraseña :</label>
                            <input align="center" type="password" name="password" class="form-control"
                                   placeholder="Contraseña" required autocomplete="off">
                            <br>
                        </div>

                        <div class="row">
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
<!-- CUSTOM SCRIPTS -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->

<!-- Javascript -->
<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>

<!--[if lt IE 10]>
<script src="{{asset('assets/js/placeholder.js')}}"></script>
<![endif]-->


</body>
</html>
