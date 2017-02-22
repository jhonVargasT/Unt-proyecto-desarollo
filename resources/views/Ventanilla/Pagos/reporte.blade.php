<div class="panel panel-primary">
    <div class="panel-heading"> Reporte Pago</div>
    <div class="panel-body">
        <!--tabla-->
        <div class="table-responsive col-sm-12">
            <table class="table table-bordered">
                <thead>
                <!--cabecear Tabla-->
                <tr>
                    <th>
                        <div align="center">
                            <small>Codigo de pago</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Dni</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Nombres y apellidos</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Subtramite</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Fecha de pago</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Monto</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Modalidad</small>
                        </div>
                    </th>
                    <th>
                        <div align="center">
                            <small>Nombre cajero</small>
                        </div>
                    </th>
                </tr>
                </thead>
                <body>
                <!--Contenido-->
                @foreach($pago as $p)
                    <tr>
                        <td>{{$p->codPago}}</td>
                        <td>{{$p->p1dni}}</td>
                        <td>{{$p->p1nombres}} {{$p->p1apellidos}}</td>
                        <td>{{$p->nombre}}</td>
                        <td>{{$p->pfecha}}</td>
                        <td>{{$p->pago}}</td>
                        <td>{{$p->modalidad}}</td>
                        <td>{{$p->pnombres}} {{$p->papellidos}}</td>
                    </tr>
                @endforeach
                </body>
            </table>
        </div>
        <div class="col-sm-12 row">
            <div class="col-sm-4"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <br>
                <div class="col-sm-12" align="left">
                    Cantidad Total: {{$total}}
                </div>
            </div>

        </div>
    </div>
</div>