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
    alert ("Debes completar todos los campos!");
    return false;
  }
  else if (pass.length < 6){
      alert("La contraseña debe contener al menos 6 caracteres.");
      return false;
   }

}