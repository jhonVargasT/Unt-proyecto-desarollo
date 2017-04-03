@extends('Ventanilla/LayoutCulqi')
@section('body')
    <!--barra de navegacion -->
    <div class=" col-sm-12 ">
        <br>
        <div class="row">
            <div class="col-sm-2">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="fa fa-money"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Pagos Visa</a>
                            </h4>
                        </div>
                        @yield('culqi')
                    </div>
                </div>
            </div>
            <div class="col-sm-9" style="align-items: center">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        function validarNum(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            if (tecla == 8) {
                return true;
            }
            patron = /[0-9]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
        }
        function validarLetras(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            if (tecla == 8) {
                return true;
            }
            patron = /[A-Za-z]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
        }
    </script>
@stop