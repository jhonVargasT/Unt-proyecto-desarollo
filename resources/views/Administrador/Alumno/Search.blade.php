@extends('Administrador\LayoutAdm')
@section('content')
    <fieldset>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel DataTables Tutorial</title>

        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

        <div>
            <legend>Buscar alumno</legend>
            <!--menu Busqueda-->
            <br>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm col-sm-6 ">
                    <span class="col-sm-5 control-label">Buscar por:</span>
                    <div class="col-sm-7 ">
                        <select class=" form-control">
                            <option>Dni</option>
                            <option>Nombres y apellidos</option>
                            <option>Codigo personal</option>
                            <option>Codigo alumno</option>
                            <option>Codigo Matricula</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-sm input-group col-sm-6">
                    <input type="text" class="form-control" placeholder="Ingresa datos aqui ..">
                    <span class="input-group-btn">

                            <button class="btn btn-sm" type="button">Buscar</button>
                        </span>
                </div>

            </div>
            <!--tabla-->


        </div>
    </fieldset>
@stop