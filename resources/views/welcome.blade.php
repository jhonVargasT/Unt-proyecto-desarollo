<!DOCTYPE html>
<html>
<head>
    <title>Datatables implementation in laravel - justlaravel.com</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script
            src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <script
            src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<style>
</style>
<body>
<div class="container ">
    {{ csrf_field() }}
    <div class="table-responsive col-sm-12">
        <table class="table table-borderless" id="table">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">DNI</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">Codigo Alumno</th>
                <th class="text-center">Codigo Matricula</th>
                <th class="text-center">Fecha de Ingreso</th>
                <th class="text-center">Opciones</th>
            </tr>
            </thead>
            @foreach($data as $item)
                <tr class="item{{$item->codPersona}}">
                    <td>{{$item->codPersona}}</td>
                    <td>{{$item->dni}}</td>
                    <td>{{$item->nombres}}</td>
                    <td>{{$item->apellidos}}</td>
                    <td>{{$item->codAlumno}}</td>
                    <td>{{$item->codMatricula}}</td>
                    <td>{{$item->fecha}}</td>
                    <td>
                        <button class="edit-modal btn btn-info"
                                data-info="{{$item->codPersona}},{{$item->dni}},{{$item->nombres}},{{$item->apellidos}},{{$item->codAlumno}},{{$item->codMatricula}},{{$item->fecha}}">
                            <span class="glyphicon glyphicon-edit"></span> Edit
                        </button>
                        <button class="delete-modal btn btn-danger"
                                data-info="{{$item->codPersona}},{{$item->dni}},{{$item->nombres}},{{$item->apellidos}},{{$item->codAlumno}},{{$item->codMatricula}},{{$item->fecha}}">
                            <span class="glyphicon glyphicon-trash"></span> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>

            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="codPersona">Codigo Persona</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fcodPersona" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="dni">DNI</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fdni" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="nombres">Nombres</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fnombres">
                        </div>
                    </div>
                    <p class="fname_error error text-center alert alert-danger hidden"></p>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="apellidos">Apellidos</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fapellidos">
                        </div>
                    </div>
                    <p class="lname_error error text-center alert alert-danger hidden"></p>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="codAlumno">Codigo Alumno</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fcodAlumno">
                        </div>
                    </div>
                    <p class="email_error error text-center alert alert-danger hidden"></p>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="codMatricula">CodigoMatricula</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fcodMatricula">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fecha">Fecha de Ingreso</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ffecha">
                        </div>
                    </div>
                </form>
                <div class="deleteContent">
                    Are you Sure you want to delete <span class="dname"></span> ? <span
                            class="hidden did"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class='glyphicon'> </span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>

<script>

    $(document).on('click', '.edit-modal', function () {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });
    $(document).on('click', '.delete-modal', function () {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');
        $('.did').text(stuff[0]);
        $('.dname').html(stuff[1] + " " + stuff[2]);
        $('#myModal').modal('show');
    });

    function fillmodalData(details) {
        $('#fcodPersona').val(details[0]);
        $('#fdni').val(details[1]);
        $('#fnombres').val(details[2]);
        $('#fapellidos').val(details[3]);
        $('#fcodAlumno').val(details[4]);
        $('#fcodMatricula').val(details[5]);
        $('#ffecha').val(details[6]);
    }

    $('.modal-footer').on('click', '.edit', function () {
        $.ajax({

            type: 'post',
            url: '/editItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'codPersona': $("#fcodPersona").val(),
                'dni': $("#fdni").val(),
                'nombres': $('#fnombres').val(),
                'apellidos': $('#fapellidos').val(),
                'codAlumno': $('#fcodAlumno').val(),
                'codMatricula': $('#fcodMatricula').val(),
                'fecha': $('#ffecha').val(),
            },
            success: function (data) {
                if (data.errors) {
                    $('#myModal').modal('show');
                    if (data.errors.fcodPersona) {
                        $('.codPersona_error').removeClass('hidden');
                        $('.codPersona_error').text("Esta Vacio!");
                    }
                    if (data.errors.fdni) {
                        $('.dni_error').removeClass('hidden');
                        $('.dni_error').text("Esta Vacio!");
                    }
                    if (data.errors.fnombres) {
                        $('.nombres_error').removeClass('hidden');
                        $('.nombres_error').text("Esta Vacio!");
                    }
                    if (data.errors.fapellidos) {
                        $('.apellidos_error').removeClass('hidden');
                        $('.apellidos_error').text("Esta Vacio!");
                    }
                    if (data.errors.fcodAlumno) {
                        $('.codAlumno_error').removeClass('hidden');
                        $('.codAlumno_error').text("Esta Vacio!");
                    }
                    if (data.errors.fcodMatricula) {
                        $('.codMatricula_error').removeClass('hidden');
                        $('.codMatricula_error').text("Esta Vacio!");
                    }
                    if (data.errors.ffecha) {
                        $('.fecha_error').removeClass('hidden');
                        $('.fecha_error').text("Esta Vacio!");
                    }
                }
                else {
                    $('.error').addClass('hidden');
                    $('.item' + data.codPersona).replaceWith("<tr class='item" + data.codPersona + "'>" +
                        "<td>" + data.codPersona +
                        "</td><td>" + data.dni +
                        "</td><td>" + data.nombres +
                        "</td><td>" + data.apellidos + "</td><td>" + data.codAlumno + "</td><td>" +
                        data.codMatricula + "</td><td>" + data.fecha + "</td>" +
                        "<td><button class='edit-modal btn btn-info' data-info='" + data.codPersona + "," + data.dni + "," + data.nombres + "," + data.apellidos + "," + data.codAlumno + "," + data.codMatricula + "," + data.fecha + "'><span class='glyphicon glyphicon-edit'></span> Edit</button><button class='delete-modal btn btn-danger' data-info='" + data.codPersona + "," + data.dni + "," + data.nombres + "," + data.apellidos + "," + data.codAlumno + "," + data.codMatricula + "," + data.fecha + "'><span class='glyphicon glyphicon-trash'></span> Edit</button> </tr>");
                }
            }
        });
    });
    $('.modal-footer').on('click', '.delete', function () {
        $.ajax({
            type: 'post',
            url: '/deleteItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'codPersona': $('.did').text(),
            },
            success: function (data) {
                $('.item' + $('.did').text()).remove();
            }
        });
    });
</script>
</body>
</html>