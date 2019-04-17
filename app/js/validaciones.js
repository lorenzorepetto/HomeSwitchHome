function campoVacio(campo){
  if (campo.length == 0){
    return true;
  }
  return false;
}



function validarIniciar(){

  var email = document.getElementById("email").value;
  var pass = document.getElementById("password").value;

  if (campoVacio(email) || campoVacio(pass)){
    document.getElementById("msjEmail").style.display = "block";
    document.getElementById("msjPassword1").style.display = "block";
    return false;
  }
  else if (pass.length < 6){
      document.getElementById("msjPassword2").style.display = "block";
      return false;
   }

}

function validarRegistrar(){

  var email = document.getElementById("email").value;
  var pass = document.getElementById("password").value;
  var nombre = document.getElementById("nombre").value;
  var apellido = document.getElementById("apellido").value;
  var telefono = document.getElementById("telefono").value;
  var fecha_nacimiento = document.getElementById("fecha_nacimiento").value;
  //var foto = document.getElementById("foto").value;
  var marca_tarjeta = document.getElementById("marca_tarjeta").value;
  var numero_tarjeta = document.getElementById("numero_tarjeta").value;
  var titular_tarjeta = document.getElementById("titular_tarjeta").value;
  var fecha_vencimiento_tarjeta = document.getElementById("nombre").value;

  if (campoVacio(email) || campoVacio(pass) || campoVacio(nombre) || campoVacio(apellido) || campoVacio(telefono) || campoVacio(fecha_nacimiento) || campoVacio(marca_tarjeta) || campoVacio(numero_tarjeta) || campoVacio(titular_tarjeta) || campoVacio(fecha_vencimiento_tarjeta)){
    document.getElementById("msjEmail").style.display = "block";
    document.getElementById("msjNombre").style.display = "block";
    document.getElementById("msjPassword1").style.display = "block";
    document.getElementById("msjApellido").style.display = "block";
    document.getElementById("msjTelefono").style.display = "block";
    document.getElementById("msjFecha_nacimiento").style.display = "block";
    document.getElementById("msjMarca").style.display = "block";
    document.getElementById("msjTitular").style.display = "block";
    document.getElementById("msjVencimiento").style.display = "block";
    document.getElementById("msjNumero").style.display = "block";
    return false;
  }

}