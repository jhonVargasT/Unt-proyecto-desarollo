@extends('Administrador.Body')
@section('content')
    <fieldset>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

        <form name="form" action="{{url('DonacionRegistrada')}}" role="form" method="POST" class="Horizontal">
        {{csrf_field()}}
        <!-- Form Name -->
            <legend>Agregar Donaciones y Transacciones</legend>
            <!-- Search input-->
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-2 control-label"> Clasificador Siaf </span>
                    <div class="col-sm-5">
                        <div class="input-group col-sm-6">
                            <input class="typeahead form-control" type="text" placeholder="Ingresa datos aqui .."
                                   name="nombreTramite" id="name">
                            <script type="text/javascript">
                                var path = "{{ route('autocompletet') }}";
                                $('input.typeahead').typeahead({
                                    source: function (query, process) {
                                        return $.get(path, {query: query}, function (data) {
                                            return process(data);
                                        });
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Fecha </span>
                    <div class="col-sm-3">
                        <input class="form-control" name="fechaDeIngreso" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row form-group">
                <div class="form-group-sm " align="left">
                    <span class="col-sm-2 control-label">Tipo de recurso </span>
                    <div class="col-sm-5">
                        @if(session()->has('false'))
                            <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                        @endif
                        @if(isset($cor))
                            <?php
                            echo $cor;
                            ?>
                        @endif
                        @if(isset($facultad))
                        <!--Contenido-->
                            @foreach($facultad as $f)
                                <input class="form-control input-sm " name="TipoDeRecurso" type="text" value="<?php $f?>">
                            @endforeach
                        @endif
                </div>
                <div class=" form-group-sm" align="left">
                    <span class="col-sm-2 control-label">Monto </span>
                    <div class="col-sm-3">
                        <input class="form-control" name="monto" type="text">
                    </div>
                </div>
            </div>
            <br>
            <div class="col-sm-12 row form-group" align="left">
                <div>
                    <span class=" col-sm-2 control-label">Descripcion </span>
                    <div class="col-sm-5">
                        <textarea class="form-control " rows="5" name="descripcion">
                            </textarea>
                    </div>
                </div>
                <div class="form-group-sm ">
                    <span class="col-sm-2 control-label">Numero de resolucion </span>
                    <div class="col-sm-3">
                        <input class="form-control " name="numeroResolucion" type="text">
                    </div>
                </div>

            </div>
            <div class="col-sm-12 row form-group">
                <div class="col-md-3"></div>
                <a href="#" class=" col-md-2 btn btn-sm btn-danger"><span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar</a>
                <div class="col-md-2"></div>
                <a href="#" class=" col-md-2 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                <div class="col-md-3"></div>
            </div>

        </form>
    </fieldset>


@stop