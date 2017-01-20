
function pagoOnChange(sel) {
      if (sel.value=="transferencia"){
           $("#nCuenta").show();
           $("#nTargeta").hide();

      }else{

           $("#nCuenta").hide();
           $("#nTargeta").show();

      }
}