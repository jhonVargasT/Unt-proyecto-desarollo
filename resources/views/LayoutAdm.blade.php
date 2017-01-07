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
    <link rel="stylesheet" href="{{asset('assets/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">

    <script>window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),]); ?>
    </script>
</head>
<body>
<div class="container ">

    <div class=" container row">
        <h2 class="left" align="left"> Unt-Administrador </h2>
    </div>

    <div class="row col-xs-10 ">
        <div class=" col-xs-4">
            <h4 align="left">Bienvenido usuario : </h4>
        </div>
        <div class="col-md-1 ">
            <h4> usuario </h4>
        </div>
    </div>

    <div class=" col-md-2" align="lefth">
        <a href="{{url('/Index')}}" class="btn btn-sm btn-danger"><span
                    class="glyphicon glyphicon-share-alt"></span> Salir</a>
    </div>

    <!--barra de navegacion -->
    <div class="row">
        <div class="col-sm-3 ">

            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <span class="glyphicon glyphicon-list-alt">
                                    </span> Reporte</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#">Reporte Pagos</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#">Reporte Donaciones y Transacciones</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span
                                        class="glyphicon glyphicon-th">
                            </span> Estudiante</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar Estudiantes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar Estudiante</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span
                                        class="glyphicon glyphicon-user">
                            </span> Escuela</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar Escuelas</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar Escuela</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span
                                        class="glyphicon glyphicon-user">
                            </span> Personal</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar Personal</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar Personal</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                <span class="glyphicon glyphicon-pushpin"></span>
                            </span> Tramite</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar Tramites</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar Tramite</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                                <span class="glyphicon glyphicon-pushpin">
                            </span> SubTramite</a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar SubTramites</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar SubTramite</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven"><span
                                        class="glyphicon glyphicon-user">
                            </span> Donaciones y Transacciones</a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-search"></span>
                                        <a href="#">Buscar Donaciones y transacciones</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <a href="#">Agregar Donaciones y transacciones</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9">
            <div class="well">
                <h1>
                    Accordion Menu With Icon</h1>
                Admin Dashboard Accordion Menu
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->
<!-- /#wrapper -->
<!-- /#wrapper -->
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- MORRIS CHART SCRIPTS -->
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


<footer class="footer">
    <p>© 2016 Company, Inc.</p>
</footer>
<!-- Javascript -->
<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>

<!--[if lt IE 10]>
<script src="{{asset('assets/js/placeholder.js')}}"></script>
<![endif]-->

</body>
</iframe>
</html>