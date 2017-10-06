@extends('Importaciones.Body')
@section('alumno')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-import"></span>
                        <a href="/impAlumnos" style="color: #509f0c"
                           target="_top">Importar Alumnos</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaI'))
        <div class="panel-heading"><h3>Importar Alumnos</h3></div>
        <div style="background-color: #FFFFFF">
            <div class="panel-body">
                @if(session()->has('true'))
                    <div class="alert alert-success" role="alert">{{session('true')}} </div>
                @endif
                @if(session()->has('false'))
                    <div class="alert alert-danger" role="alert">{{session('false')}}  </div>
                @endif
                <div class="container">
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                          action="{{url('importAlumnos')}}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        {!!   csrf_field() !!}
                        <input type="file" name="import_file">
                        <br>
                        <button type="submit" class="btn btn-primary">Importar</button>
                        <a title="Importar" href="/importAlumnoAutomatico"><span
                                    class="btn btn-primary"> Importacion automatica</span> </a>
                    </form>
                </div>
            </div>
        </div>
        <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    @else
        @include("index")
    @endif
@stop
