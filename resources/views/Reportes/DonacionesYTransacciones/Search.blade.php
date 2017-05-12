@extends('Reportes/Body')
@section('donaciones')
    <div id="collapseSeven" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-search"></span>
                        <a href="/repBuscarDonaciones" style="color: #509f0c" target="_top">Buscar Donaciones y
                            transferencias</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="/repAgregarDonaciones">Agregar Donaciones y transaferencias</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if(session()->has('true'))
        <div class="alert alert-success" role="alert">{{session('true')}} </div>
    @endif
    @if(session()->has('false'))
        <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
    @endif
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript">
        $(document).ready(function () {
            $(".contenido").hide();
            $("#combito").change(function () {
                $(".contenido").hide();
                $("#div_" + $(this).val()).show();
            });

        });

        function agregarMenu(val) {
            if (val === 1) {
                document.getElementById('opc').innerHTML("<input class='form-control input-sm' type='text' @if(isset($fecha) ) value='{{$fecha}}' @endif name='fecha' required> ");
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <div class="panel-heading"><h3> Buscar Donaciones y
            transferencias</h3></div>
    <div style="background-color: #FFFFFF">
        <div class="panel-body">
            <form id="miform" action="{{'DonacionesBuscadas'}}" role="form" method="POST" class="Vertical">
                {{csrf_field()}}
                <div class="row ">

                    <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2">
                        <span class="control-label">Buscar por :</span>
                        <select class=" form-control" name="combito" id="combito">
                            <option>Escojer</option>
                            <option value="1">Año</option>
                            <option value="2">Mes</option>
                            <option value="3">Dia</option>
                        </select>
                    </div>
                    <div class="form-group-sm col-sm-2 col-lg-2 col-xs-2" id="opc">
                        <div id="div_1" class="contenido">
                            <span class=" control-label">Año :</span>

                            <input type="text" class="form-control input-sm " id="año1" name="año1"
                                   autocomplete="off">

                        </div>
                        <div id="div_2" class="row contenido">
                            <div class="col-sm-6 col-lg-6 col-xs-6">
                                <span class=" control-label">Año :</span>
                                <input type="text" class="form-control input-sm " id="trinp" name="año2"
                                       autocomplete="off">
                            </div>
                            <div class="col-sm-6 col-lg-6 col-xs-6">
                                <span class=" control-label">Mes :</span>
                                <input type="text" class="form-control input-sm " id="trinp" name="mes2"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div id="div_3" class="contenido ">
                            <span class=" control-label">Elija fecha :</span>
                            <div class="input-group date " data-provide="datepicker">
                                <input type="dia" name="fecha" class="form-control"
                                       autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group-sm col-sm-1 col-lg-1 col-xs-1">
                        <span class=" control-label">. .. </span>
                        <button type="submit" class="btn btn-sm btn-success s-b-5" id="imp"><i
                                    class="ion-ios7-search"> </i> buscar
                        </button>
                    </div>
                </div>
            </form>
            <!--tabla-->
            <div class="col-sm-12 row form-group">
            </div>

            @if(isset($nombre)!=null)
                <div class="alert alert-success" role="alert">El tramite {{$nombre}} fue actualizada!!</div>
            @endif
            <div align="center" class=" row  ">

                <div class="col-sm-10"></div>

                <div class="col-sm-2">
                    Total :
                    @if(isset($total) )
                        {{$total}}
                    @endif
                </div>
            </div>
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <!--cabecear Tabla-->
                <tr>
                    <th>
                        <div align="center">Numero Resolucion</div>
                    </th>
                    <th>
                        <div align="center">Banco</div>
                    </th>
                    <th>
                        <div align="center">N° cuenta</div>
                    </th>
                    <th>
                        <div align="center">Clasificador</div>
                    </th>
                    <th>
                        <div align="center">Fecha de ingreso</div>
                    </th>
                    <th>
                        <div align="center">Descripcion</div>
                    </th>
                    <th>
                        <div align="center">Importe</div>
                    </th>
                    <th>
                        <div align="center">Opciones</div>
                    </th>
                </tr>
                </thead>
                <body>
                @if(isset($result))
                        <!--Contenido-->
                @foreach($result as $d)
                    <tr>
                        <td>{{$d->numResolucion}}</td>
                        <td>{{$d->banco}}</td>
                        <td>{{$d->cuenta}}</td>
                        <td>{{$d->nombre}}</td>
                        <td>{{$d->fechaIngreso}}</td>
                        <td>{{$d->descripcion}}</td>
                        <td>{{$d->importe}}</td>
                        <td align="center">
                            {{ csrf_field() }}
                            <a href="DonacionCargar/{{$d->codigo}}" title="Click para editar"><span
                                        class="glyphicon glyphicon-pencil"></span> </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="DonacionEliminar/{{$d->codigo}}" title="Click para eliminar"><span
                                        class="glyphicon glyphicon-trash"></span> </a>
                        </td>
                    </tr>
                @endforeach
                @endif
                </body>
            </table>

            <div class="col-sm-12 row form-group">
            </div>
            <div class=" row ">
                <div class="col-md-4"></div>
                <div class="col-md-2">
                    <a href="{{url('/Adm')}}" class="btn btn-sm s-b-5  btn-primary"><span
                                class="glyphicon glyphicon-arrow-left"></span> Regresar
                    </a>
                </div>
                <div class="col-md-2">
                    <!--Contenido-->
                    @if(isset($fecha))
                        <a href="exceldonacion/{{$fecha}}/{{$numero}}"
                           class="btn btn-sm s-b-5  btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir
                        </a>
                    @else
                        <a class="btn btn-sm s-b-5  btn-primary"><span
                                    class="glyphicon glyphicon-print"></span> Imprimir
                        </a>
                    @endif
                </div>

                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
@stop