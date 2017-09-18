/**
 * Created by JhO.On on 17/09/2017.
 */
$(document).ready(function () {

});

function activarBotonreporte(event) {


    activarbotonform(event,['spanaño'],'imp','mensaje');
}
function cambiartabla(event) {
    event.preventDefault();
    var value= document.getElementById('tipreporte').value;
    if(value ==='Clasificador S.I.A.F'){
        $('#example').html(
            '   <thead> <tr><th>Unidad Operativa </th><th> <div align="center">'
           + 'CLASIFICADOR S.I.A.F</div></th><th><div align="center">NOMBRE DE CLASIFICADOR</div>'
            +'</th><th><div align="center">CUENTA</div></th> <th>'
           + '<div align="center"> NOMBRE DE TASA</div></th><th>'
           + '<div align="center"> IMPORTE</div></th><th><div align="center">'
           + 'NRO PAGOS</div></th></tr></thead><tbody></tbody>');
    }
    else {
        if(value==='Resumen total'){
            $('#example').html(
                '<thead><tr><th><div align="center"> CODIGO CLASIFICADOR S.I.A.F'
                +'</div></th><th><div align="center">UNIDAD OPERATIVA</div></th>'
                +'<th><div align="center">NOMBRE DE CLASIFICADOR</div></th><th>'
               + '<div align="center">IMPORTE</div></th></tr></thead><tbody></tbody>');
        }
    }


}
function validarAño() {
    var valor=document.getElementById('año1').value;

    var fecha= new Date();
    fecha=fecha.getFullYear();
    if (isNaN(valor)) {
        document.getElementById('spanaño').innerHTML = "Error: un numero no puede contener letras.";
    }
    else {
        if(valor<=fecha && valor >=1900)
        {
            document.getElementById('spanaño').innerHTML = '';
        }
        else{
            document.getElementById('spanaño').innerHTML = "El año no debe ser mayor a "+fecha +" o menor a 1900";
        }
    }
}

function validarMesyAño() {
    var valorAño=document.getElementById('año2').value;
    var valorMes=document.getElementById('mes2').value;

    var fecha= new Date();
    fecha=fecha.getFullYear();
    if(isNaN(valorAño) )
    {
        document.getElementById('spanaño1').innerHTML = "Error: el año no puede contener letras.";
       if( isNaN(valorMes))
       {
           document.getElementById('spanmes').innerHTML = "Error: el mes no puede contener letras.";
       }

    }
    else{
        if(valorAño >= 1900 && valorAño <=fecha){
            document.getElementById('spanaño1').innerHTML = " ";
            if(valorMes >= 1 && valorMes <=12)
            {
                document.getElementById('spanmes').innerHTML = " ";
            }
            else {
                document.getElementById('spanmes').innerHTML = "Error: el mes debe ser >0 o <13.";
            }
        }
        else {
            document.getElementById('spanaño1').innerHTML = "Error: La año debe ser >1900 o <2017.";
        }
    }
}

function cambiarmenu(event) {
   var value= document.getElementById('combito').value;
   if(value ==='Año'){
       $('#opc').html(
            '<div id="div_1" class="contenido">'
            + '<span class=" control-label">Año :</span>'
            + ' <input required type="text" class="form-control input-sm " id="año1" name="año1"'
            +' autocomplete="off" '
            +'onchange="validarAño()">'
            +'<span class=" control-label" id="spanaño" style="color: red"></span>'
            +   '</div>')
   }
       else {
       if(value==='Mes'){
           $('#opc').html('' +
               '<div id="div_2" class="row contenido">'
               +'<div class="col-sm-6 col-lg-6 col-xs-6">'
              +'<span class=" control-label">Año :</span>'
           +'<input type="text" required class="form-control input-sm " id="año2" name="año2"'
           +'autocomplete="off" onchange="validarMesyAño()"><span class=" control-label" id="spanaño1" style="color: red"></span></div><div class="col-sm-6 col-lg-6 col-xs-6">'
           +'<span class=" control-label">Mes :</span>'
           +'<input type="text" onchange="validarMesyAño()" required class="form-control input-sm " id="mes2" name="mes2"'
           +'autocomplete="off"> <span class=" control-label" id="spanmes" style="color: red"></span> </div></div>')
       }
       else{
           if(value==='Dia'){
               $('#opc').html('<div id="div_3" class="contenido ">'
                  + '<span class=" control-label">Elija fecha :</span>'
               +'<div class="input-group date " data-provide="datepicker">'
                  + '<input required type="dia" name="fecha" class="form-control"'
              + 'autocomplete="off"><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>'
               +'</div></div></div>')
           }
           else {
               $('#opc').html('')
            }
        }
    }
}

function agregarMenu(val) {
    if (val === 1) {
        document.getElementById('opc').innerHTML("<input class='form-control input-sm' type='text' @if(isset($fecha) ) value='{{$fecha}}' @endif name='fecha' required> ");
    }
}

function habilitarTexto(value, idtexto,idSpan) {
    if(value === true) {
        document.getElementById(idtexto).disabled = false;
    }
    else {
        document.getElementById(idtexto).disabled = true;
        document.getElementById(idtexto).readonly = false;
        document.getElementById(idtexto).value='';
        document.getElementById(idSpan).innerHTML='';
    }
}