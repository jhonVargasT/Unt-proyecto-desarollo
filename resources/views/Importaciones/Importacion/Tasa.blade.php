@extends('Importaciones.Body')
@section('tasa')
    <div id="collapseTwo" class="collapse in">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-import"></span>
                        <a href="/impTasas" style="color: #509f0c"
                           target="_top">Importar Tasas</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('content')
    @if( Session::has('tipoCuentaI'))
        <div class="panel-heading"><h3>Importar Tasas</h3></div>
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
                          action="{{url('importTasas')}}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        {!!   csrf_field() !!}
                        <input type="file" name="import_file">
                        <br>
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </form>
                </div>
            </div>
        </div>
        <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    @else
        @include("index")
    @endif
@stop
