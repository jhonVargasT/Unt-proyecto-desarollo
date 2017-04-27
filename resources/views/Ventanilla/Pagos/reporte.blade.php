
<div class="panel-heading" align="center"><img src="assets/img/logo.png" style="width:200px;height:150px;"></div>
<div class="panel-heading" align="center"><h3> UNIVERSIDAD NACIONAL DE TRUJILLO</h3></div>
<div class="panel-heading" align="center"><h3> OGSEF- OF.TEC. TESORERIA</h3></div>
<div class="panel-heading" align="center"><h4> PAGO ALUMNO</h4></div>

<div style="background-color: #FFFFFF">
    <div class="panel-body">
        <!--tabla-->
        <div class="table-responsive col-sm-12">
            <br>
            <br>
            <table class="table table-bordered">
                <thead>
                <!--cabecear Tabla-->
                <tr>
                    <th>
                        <div align="left">
                            <small>Codigo</small>
                        </div>
                    </th>
                    <th>
                        <div align="left">
                            <small>Dni</small>
                        </div>
                    </th>
                    <th>
                        <div align="left">
                            <small>Nombres y Apellidos</small>
                        </div>
                    </th>
                    <th>
                        <div align="left">
                            <small>Tasa</small>
                        </div>
                    </th>
                    <th>
                        <div align="left">
                            <small>Fecha</small>
                        </div>
                    </th>
                    <th>
                        <div align="left">
                            <small>Monto</small>
                        </div>
                    </th>
                    @foreach($pago as $p)
                        @if(isset($p->pnombres))
                            <th>
                                <div align="left">
                                    <small>Nombre cajero</small>
                                </div>
                            </th>
                        @else
                        @endif
                </tr>
                </thead>
                <body>
                <!--Contenido-->
                <tr>
                    <td align="left">{{$p->codPago}}</td>
                    <td align="left">{{$p->p1dni}}</td>
                    <td align="left">{{$p->p1nombres}} {{$p->p1apellidos}}</td>
                    <td align="left">{{$p->nombre}}</td>
                    <td align="left">{{$p->pfecha}}</td>
                    <td align="left">{{$p->precio}}</td>
                    @if(isset($p->pnombres))
                        <td align="left">{{$p->pnombres}} {{$p->papellidos}}</td>
                    @endif
                </tr>
                @endforeach
                </body>
            </table>
        </div>
        <style>
            td {
                padding: 5px;
            }

            th {
                padding: 5px;
                border: 1px solid black;
                background: lightgreen;
            }
        </style>
        <div class="col-sm-12 row">
            <div class="col-sm-4"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <br>
                <div class="col-sm-12" align="right">
                    Cantidad Total: {{$total}}
                </div>
            </div>

        </div>
    </div>
</div>