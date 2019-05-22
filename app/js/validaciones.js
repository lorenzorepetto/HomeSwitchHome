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
   return true;
}

function validarRegistrar(){

  var email = document.getElementById("email").value;
  var pass = document.getElementById("password").value;
  var nombre = document.getElementById("nombre").value;
  var apellido = document.getElementById("apellido").value;
  var telefono = document.getElementById("telefono").value;
  var fecha_nacimiento = document.getElementById("fecha_nacimiento").value;
  var marca_tarjeta = document.getElementById("marca_tarjeta").value;
  var numero_tarjeta = document.getElementById("numero_tarjeta").value;
  var titular_tarjeta = document.getElementById("titular_tarjeta").value;
  var fecha_vencimiento_tarjeta = document.getElementById("fecha_vencimiento_tarjeta").value;

  if (campoVacio(email) || campoVacio(pass) || campoVacio(nombre) || campoVacio(apellido) || campoVacio(telefono) 
    || campoVacio(fecha_nacimiento) || campoVacio(marca_tarjeta) || campoVacio(numero_tarjeta) || campoVacio(titular_tarjeta) || 
    campoVacio(fecha_vencimiento_tarjeta)){

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
  return true;

}


function validarAgregarResidencia(){

  var nombre = document.getElementById("nombre").value;
  var descripcion = document.getElementById("descripcion").value;
  var calle = document.getElementById("calle").value;
  var altura = document.getElementById("altura").value;
  var ciudad = document.getElementById("ciudad").value
  var provincia = document.getElementById("provincia").value;
  var capacidad = document.getElementById("capacidad").value;
  var foto = document.getElementById("foto").value;
  var digitos = /^[0-9]+$/;
  var carac_especiales=/[$@\!#]/;

  document.getElementById("msjNombreR").style.display = "none";
  document.getElementById("msjDescripcionR").style.display = "none";
  document.getElementById("msjCalleR").style.display = "none";
  document.getElementById("msjAlturaR").style.display = "none";
  document.getElementById("msjCiudadR").style.display = "none";
  document.getElementById("msjProvinciaR").style.display = "none";
  document.getElementById("msjCapacidadR").style.display = "none";
  document.getElementById("msjFotoR").style.display = "none";
  document.getElementById("msjCapacidadR2").style.display = "none";
  document.getElementById("msjNombreR2").style.display = "none";
  document.getElementById("msjCiudadR2").style.display = "none";
  document.getElementById("msjProvinciaR2").style.display = "none";
  document.getElementById("msjCalleR2").style.display = "none";
  document.getElementById("msjAlturaR2").style.display = "none";

  if (campoVacio(nombre) || campoVacio(descripcion)|| campoVacio(calle)|| campoVacio(altura)
    || campoVacio(ciudad)|| campoVacio(provincia)|| campoVacio(capacidad)
    || campoVacio(foto)){
    document.getElementById("msjNombreR").style.display = "block";
    document.getElementById("msjDescripcionR").style.display = "block";
    document.getElementById("msjCalleR").style.display = "block";
    document.getElementById("msjAlturaR").style.display = "block";
    document.getElementById("msjCiudadR").style.display = "block";
    document.getElementById("msjProvinciaR").style.display = "block";
    document.getElementById("msjCapacidadR").style.display = "block";
    document.getElementById("msjFotoR").style.display = "block";
    return false;

  }

  if (!digitos.test(capacidad) || capacidad<=0) {
    document.getElementById("msjCapacidadR2").style.display = "block";
    return false;
  }

  if (digitos.test(nombre) || carac_especiales.test(nombre)) {
    document.getElementById("msjNombreR2").style.display = "block";
    return false;
  }

  if (digitos.test(ciudad) || carac_especiales.test(ciudad)) {
    document.getElementById("msjCiudadR2").style.display = "block";
    return false;
  }

  if (digitos.test(provincia) || carac_especiales.test(provincia)) {
    document.getElementById("msjProvinciaR2").style.display = "block";
    return false;
  }

  if (carac_especiales.test(calle)) {
    document.getElementById("msjCalleR2").style.display = "block";
    return false;
  }

  if (!digitos.test(altura)) {
    document.getElementById("msjAlturaR2").style.display = "block";
    return false;
  }
  return true;
}

function validarModificarResidencia(){

  var nombre = document.getElementById("nombreM").value;
  var descripcion = document.getElementById("descripcionM").value;
  var calle = document.getElementById("calleM").value;
  var altura = document.getElementById("alturaM").value;
  var ciudad = document.getElementById("ciudadM").value
  var provincia = document.getElementById("provinciaM").value;
  var capacidad = document.getElementById("capacidadM").value;
  var digitos = /^[0-9]+$/;
  var carac_especiales=/[$@\!#]/;


  if (!digitos.test(capacidad) || capacidad<=0) {
    document.getElementById("msjCapacidadM2").style.display = "block";
    return false;
  }

  if (digitos.test(nombre) || carac_especiales.test(nombre)) {
    document.getElementById("msjNombreM2").style.display = "block";
    return false;
  }

  if (digitos.test(ciudad) || carac_especiales.test(ciudad)) {
    document.getElementById("msjCiudadM2").style.display = "block";
    return false;
  }

  if (digitoss.test(provincia) || carac_especiales.test(provincia)) {
    document.getElementById("msjProvinciaM2").style.display = "block";
    return false;
  }

  if (carac_especiales.test(calle)) {
    document.getElementById("msjCalleM2").style.display = "block";
    return false;
  }

  if (!digitos.test(altura)) {
    document.getElementById("msjAlturaM2").style.display = "block";
    return false;
  }
  return true;
}


function validarToken(){
    var token = document.getElementById("valor_token").value;

    var digitos = /^[0-9]+$/;

    if (campoVacio(token)){
      document.getElementById("msjToken1").style.display = "block";
      document.getElementById("msjToken2").style.display = "none";
      return false;
    }
    else if (token.length != 6 || !digitos.test(token)) {
      document.getElementById("msjToken2").style.display = "block";
      document.getElementById("msjToken1").style.display = "none";
      return false;
    }
    return true;
}


function mostrarToken(){
    document.getElementById("token").style.display = "block";

    document.getElementById("boton_token").style.display = "none";
    document.getElementById("boton_form_iniciar").style.display = "none";
    document.getElementById("input_email").style.display = "none";
    document.getElementById("input_password").style.display = "none";

    document.getElementById("msjEmail").style.display = "none";
    document.getElementById("msjPassword1").style.display = "none";
    document.getElementById("msjPassword2").style.display = "none";
    return true;
}

function validarAgregarSubasta(id){
  var monto = document.getElementById("monto"+id).value;
  document.getElementById("error_campo_vacio_subasta").style.display = "none";

  if (campoVacio(monto) || monto <= 0){
    document.getElementById("error_campo_vacio_subasta").style.display = "block";
    return false;
  }

  return true;
}

function confirmation(){
  
  if(confirm("¿Está seguro que desea realizar esta operación?")){
     return true;
  }
  else
  {
     return false;
  }

}

  function validarPuja(monto_validacion){
    var monto = document.getElementById("puja").value;

    if (campoVacio(monto)) {
      document.getElementById("errorPujaMonto").style.display = "none";
      document.getElementById("errorPujaVacia").style.display = "block";
      return false;
    }
    else if (monto <= monto_validacion) {
      document.getElementById("errorPujaVacia").style.display = "none";
      document.getElementById("errorPujaMonto").style.display = "block";
      return false;
    }

    return true;

  }
