/**
 * Created by JhO.On on 17/09/2017.
 */
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

function habilitarTexto(value,idtexto) {
    if(value===true){
    document.getElementById(idtexto).disabled = false;}
    else{
        document.getElementById(idtexto).disabled = true;}
}