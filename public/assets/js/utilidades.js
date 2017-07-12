/**
 * Created by JhO.On on 11/07/2017.
 */
function activarboton(myarray,idboton)
{
  var cont=0;
  var dat;
for (var i=0;i<myarray.length;i++)
{
    dat=+myarray[i];
    cont++;
}
    alert(dat,cont);
}
function validarContraseña(idContra,idRepContra,idspan) {
    var texto1=document.getElementById(idContra).value;
    var texto2=document.getElementById(idRepContra).value;
    if(texto1 === texto2)
    {
        document.getElementById(idspan).style.color = '#2ba710';
        document.getElementById(idContra).style.backgroundColor = '#FFFFFF';
        document.getElementById(idRepContra).style.backgroundColor = '#FFFFFF';
        document.getElementById(idspan).innerHTML = " Contraseñas coinciden.";
    }
    else {
        document.getElementById(idContra).style.backgroundColor = '#F6CECE';
        document.getElementById(idRepContra).style.backgroundColor = '#F6CECE';
        document.getElementById(idspan).style.color = '#f90000';
        document.getElementById(idspan).innerHTML = "Error: Las ontraseñas no coinciden.";
    }
}
function validarNumeros(idform,idspan) {
    var texto=document.getElementById(idform).value;
    if(isNaN(texto))
    {
        document.getElementById(idform).style.backgroundColor = '#F6CECE';
        document.getElementById(idspan).innerHTML = "Error: no puede contener letras.";
    }else {
        document.getElementById(idform).style.backgroundColor = '#FFFFFF';
        document.getElementById(idspan).innerHTML = "";
    }

}

function validarDni(idform,idspan){

var texto=document.getElementById(idform).value;
if(isNaN(texto)){
    document.getElementById(idform).style.backgroundColor = '#F6CECE';
    document.getElementById(idspan).innerHTML = "Error: un dni no puede contener letras.";
}
else{
    var expresion=/^[0-9]{8}/;
    if(expresion.test(texto)){
        document.getElementById(idform).style.backgroundColor = '#FFFFFF';
        document.getElementById(idspan).innerHTML = "";}
    else{
        document.getElementById(idform).style.backgroundColor = '#F6CECE';
        document.getElementById(idspan).innerHTML = "Error: El dni debe tener 8 digitos";}
}}

function validarNombre(idform,idspan) {
var texto=document.getElementById(idform).value;
if(isNaN(texto))
{
    var expresion=/^[A-Z]|[a-z]/;
    if(expresion.test(texto)){
    document.getElementById(idform).value =  (texto.toUpperCase());
    document.getElementById(idform).style.backgroundColor = '#FFFFFF';
    document.getElementById(idspan).innerHTML = "";}
    else {
        document.getElementById(idform).style.backgroundColor = '#F6CECE';
        document.getElementById(idspan).innerHTML = "Error: No puede incluir numeros.";
    }
}
else {
    document.getElementById(idform).style.backgroundColor = '#F6CECE';
    document.getElementById(idspan).innerHTML = "Error: No puede incluir numeros.";
}
}

function validarCorreo(idform,idspan) {
    var texto=document.getElementById(idform).value;

    if(texto.indexOf('@')!=-1)
    {
        if(texto.indexOf('.')!=-1)
        {
            document.getElementById(idform).style.backgroundColor = '#FFFFFF';
            document.getElementById(idspan).innerHTML = "";

        }
        else {
            document.getElementById(idform).style.backgroundColor = '#F6CECE';
            document.getElementById(idspan).innerHTML = "Error: Falta domino";
        }

    }
    else {
        document.getElementById(idform).style.backgroundColor = '#F6CECE';
        document.getElementById(idspan).innerHTML = "Error: Falta @ en ele correo.";
    }

}


