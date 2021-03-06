<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace app\controllers;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Controllers\Controllers;
use Ocrend\Kernel\Controllers\IControllers;
use Ocrend\Kernel\Router\IRouter;
use Ocrend\Kernel\Helpers\Strings;
use Ocrend\Kernel\Helpers\Functions;

/**
 * Controlador usuarios/
*/
class usuariosController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $router->setRoute('/id_hotsale');

        #Instancio un objeto Usuario
        $u = new Model\Usuarios;
        $s = new Model\Subastas;
        $e = new Model\Estadias;
        $r = new Model\Residencias;
        $t = new Model\Tarjeta;
        $h = new Model\Hotsales;

        switch ($router->getMethod()) {

            case 'cuenta':

                    switch ($router->getId()) {

                        case 'iniciar':
                            echo $this->template->display('home/home');
                            break;

                        case 'logout':
                            $this->logout();
                            break;

                        case 'autenticar':
                            $this->autenticar($u);
                            break;


                        default:
                            echo $this->template->display('home/home');
                            break;

                    }

            break;



            case 'registro':

                    switch ($router->getId()) {

                        case 'registrar':
                            echo $this->template->display('usuarios/registrar');
                            break;

                        case 'insertar':
                            $this->insertar($u, $t);
                            break;


                        default:
                            echo $this->template->display('home/home');
                            break;

                    }


                break;



            case 'operaciones':

                switch ($router->getId()) {

                    case 'perfil':

                        if (isset($_GET['elimino'])) {
                          $this->perfil($u, $t, 1);
                        }else {
                          // code...
                          $this->perfil($u, $t, 0);
                        }
                        break;

                    case 'modificar_perfil':
                        $id_usuario = $_GET['id'];
                        $this->modificar_perfil($u, $id_usuario, $data = array('sin_error' => 0 ));
                        break;

                    case 'ver_estadias':
                        $this->verEstadias($e);
                        break;

                    case 'descontarCredito':
                        $this->descontarCredito($u);
                        break;

                    case 'eliminarTarjeta':
                        $id=$_GET['id_tarjeta'];
                        $this->eliminarTarjeta($id, $t);
                    break;

                    case 'agregar_tarjeta':
                        $id=$_GET['id'];
                        $data = array('usuario' => $id );

                        $this->template->display('usuarios/agregar_tarjeta', $data);
                    break;

                    default:
                        echo $this->template->display('home/home');
                        break;
                }




            break;

            case 'subastas':

                switch ($router->getId()) {

                    case 'verSubastas':
                        $subastas= $s->getSubastasConEstadiaYResidencia();
                        $this->template->display('subastas/verSubastasLogged', array('subastas' => $subastas));

                    break;

                    default:
                        echo $this->template->display('home/home');
                    break;
                }
            break;

            case 'hotsales':

                switch ($router->getId()) {

                    case 'listar':
                        $hotsales=$h->getHotsalesConEstadiaYResidencia();

                        $data = array('hotsales' => $hotsales,
                                      'rol' => 'USUARIO');
                        $this->template->display('hotsales/listar', $data);
                    break;

                    case 'confirmacion':

                      $id_hotsale = $router->getRoute('/id_hotsale');
                      $this->confirmacionHotsale($h,$e,$u,$id_hotsale);
                      break;

                    case 'adquirir':
                      $id_hotsale = $router->getRoute('/id_hotsale');

                      $this->adquirirHotsale($h,$e,$u,$id_hotsale);
                      break;
                }
            break;

            case 'faqs':
              if (isset($_SESSION['id'])) {
                $data = array('esta_loggeado' => 1 );
              }else{
                $data = array('esta_loggeado' => 0 );

              }
              $this->template->display('usuarios/faqs', $data);
            break;

            case 'agregar_tarjeta':
              $id= $router->getId();
              $this->agregar_tarjeta($id, $t, $u);
            break;

            case 'cambiarRol':
                    $this->cambiarRol($u);
                break;


            case 'verDetalleResidencia':
                $id= $router->getId();

                $this->verDetalleResidencia($r,$id);
                break;

            case 'modificar_perfil':
                $id= $router->getId();
                $data= array('sin_error' => 0);
                $this->modificar($id, $u, $data);
                break;

            case 'cambiar_principal':
                $id_tarjeta = $router->getId();
                $this->cambiar_principal($u,$t,$id_tarjeta);
                break;


             default:
                $this->template->display('home/home');
                break;

    	}

    }



    /*

    -------------------------------------CUENTA----------------------------------------------

    */


    private function autenticar($u){

        #Guardo los valores del formulario
        $email= $_POST['email'];
        $pass= $_POST['password'];

        $ok = $u->autenticar($email,$pass);

        if ($ok) {

            if ($_SESSION['rol']=='ADMINISTRADOR') {
                $this->template->display('home/homeBackend');
            }
            else{
                $this->template->display('home/homeLogged');
            }
        }
        else{
            //Login fallido
            //$errores = array('error_login' => 1);

            Functions::redir("http://localhost/HomeSwitchHome/home/error_login?email=$email");
        }
    }



    private function logout(){

        if (isset($_SESSION['id'])) {

            #Destruir la sesión
            session_destroy();

        }
        Functions::redir("http://localhost/HomeSwitchHome/home");
    }



    /*

    -------------------------------------------REGISTRO-------------------------------

    */


    public function insertar($u, $t){

        $email=$_POST['email'];
        $password=$_POST['password'];
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $telefono=$_POST['telefono'];
        $marca_tarjeta=$_POST['marca_tarjeta'];
        $numero_tarjeta=$_POST['numero_tarjeta'];
        $titular_tarjeta=$_POST['titular_tarjeta'];
        $vencimiento_tarjeta=$_POST['fecha_vencimiento_tarjeta'];

        $originalDate = $_POST['fecha_nacimiento'];
        $newDate = date("d/m/Y", strtotime($originalDate));
        $edad = Strings::calculate_age($newDate);

        $errores= array('email_existente' => 0,
                        'edad_invalida' => 0,
                        'sin_error' => 0,
                        'vencimiento_invalido' => 0,
                        'email' => $email,
                        'password' => $password,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'fecha_nacimiento' => $originalDate,
                        'telefono' => $telefono,
                        'marca_tarjeta' => $marca_tarjeta,
                        'numero_tarjeta' => $numero_tarjeta,
                        'titular_tarjeta' => $titular_tarjeta,
                        'vencimiento_tarjeta' => $vencimiento_tarjeta);

        //Valido la fecha de vencimiento de la tarjeta
        $newDate2 = date("Y/m/d", strtotime($vencimiento_tarjeta));
        $fecha_actual = date("Y/m/d");

        if ($newDate2 < $fecha_actual) {
          $errores['vencimiento_invalido'] = 1;
        }
        //Valido el email
        if ($u->existe($email)) {
            $errores['email_existente'] = 1;
        }

        //Valido la edad
        if ($edad < 18) {
            $errores['edad_invalida'] = 1;
        }


        if (!$errores['email_existente'] && !$errores['edad_invalida'] && !$errores['vencimiento_invalido']) {
            //Registro exitoso
            $u->insertar($t);
            $errores['sin_error'] = 1;
        }

        echo $this->template->display('usuarios/registrar',$errores);

    }






    /*

    ----------------------------OPERACIONES--------------------------------------------

    */


    public function cambiar_principal($u,$t,$id_tarjeta){
      $t->cambiar_principal($_SESSION['id'], $id_tarjeta);

      $this->perfil($u,$t);

    }



    public function perfil($u, $t, $elimino = 0){

        if (isset($_SESSION['id'])) {

            $id=$_SESSION['id'];

            $resultado = $u->getUsuario($id);

            if ($resultado) {

                $usuario = array(
                'id' => $resultado['0']['id'],
                'email' => $resultado['0']['email'],
                'nombre' => $resultado['0']['nombre'],
                'apellido' => $resultado['0']['apellido'],
                'foto' => $resultado['0']['foto'],
                'creditos' => $resultado['0']['creditos'],
                'rol' => $resultado['0']['rol'],
                'telefono' => $resultado['0']['telefono'],
                'fecha_nacimiento' => $resultado['0']['fecha_nacimiento'],
                'fecha_registro' => $resultado['0']['fecha_registro']
                 );

                $tarjetas= $t->getTarjetas($id);
            }

            $data = array('usuario' => $usuario, 'tarjetas' => $tarjetas );

            if ($elimino == 1) {
              $data['elimino_tarjeta'] = 1;
            }
            $this->template->display('usuarios/perfil', $data);
        }
        else{
            $this->template->display('home/home');
        }

    }


    public function descontarCredito($u){

        $u->descontarCredito($_SESSION['id']);
        $this->perfil($u);
    }


    public function cambiarRol($u){

        #ESTE METODO TENDRIA QUE IR EN ADMIN CONTROLLER Y LE LLEGARIA UN ID DEL USUARIO A MODIFICAR

        if(isset($_SESSION)){
            if ($_SESSION['rol'] == 'ADMINISTRADOR') {
                $u->cambiarRol($_SESSION['id']);
            }
        }

        $this->perfil($u);
    }

    public function modificar_perfil($u, $id_usuario, $data){


        if ($_SESSION['id']==$id_usuario) {

            $resultado = $u->getUsuario($id_usuario);

            if ($resultado) {

                $usuario = array(
                'id' => $resultado['0']['id'],
                'password' => $resultado['0']['password'],
                'nombre' => $resultado['0']['nombre'],
                'apellido' => $resultado['0']['apellido'],
                'foto' => $resultado['0']['foto'],
                'creditos' => $resultado['0']['creditos'],
                'rol' => $resultado['0']['rol'],
                'telefono' => $resultado['0']['telefono'],
                'fecha_nacimiento' => $resultado['0']['fecha_nacimiento']
                 );
            }

            $data['usuario'] = $usuario;
            $this->template->display('usuarios/modificar_perfil', $data);
        }
        else{
            $this->template->display('home/home');
        }
    }

    public function verDetalleResidencia($r, $id){
        $residencia = $r->getResidencia($id)[0];
        $estadias = $r->getEstadias($id);
        $premium=false;


        if (isset($_SESSION['id']) && $_SESSION['rol'] != 'ADMINISTRADOR'){
            if ($_SESSION['rol'] == 'PREMIUM'){
                $premium=true;
            }
        }else{
            $this->template->display('home/home');
        }
        $data = array('residencia' => $residencia, 'estadias' => $estadias, 'premium' => $premium);
        $this->template->display('filtros/verDetalleResidencia', $data);

    }

    public function modificar($id, $u){

      if ($_SESSION['id'] == $id) {

        $usuario = array('nombre' => $_POST['nombreP'],
                          'apellido' => $_POST['apellidoP'],
                          'telefono' => $_POST['telefonoP'],
                          'fecha_nacimiento' => $_POST['fecha_nacimientoP']);

        $originalDate = $_POST['fecha_nacimientoP'];
        $newDate = date("d/m/Y", strtotime($originalDate));
        $edad = Strings::calculate_age($newDate);

        if ($edad < 18) {
          $data = array('menor_de_edad' => 1, 'sin_error' => 0 );
          $this->modificar_perfil($u, $id, $data);
        }else {
          if ($u->update($id, $usuario)) {
            $data = array('sin_error' => 1 );
            $this->modificar_perfil($u, $id, $data);
          }
        }


      }else{
        $this->template->display('home/home');
      }

    }

    public function eliminarTarjeta ($id, $t){

       $t->eliminar($id);
       Functions::redir("http://localhost/HomeSwitchHome/usuarios/operaciones/perfil?elimino=1");
    }


    public function confirmacionHotsale($h,$e,$u,$id_hotsale){

      $hotsale = $h->getHotsaleConEstadiaYResidencia($id_hotsale);
      $usuario = $u->getUsuario($_SESSION['id']);

      $data = array('hotsale' => $hotsale['0'],
                    'usuario' => $usuario['0']);

      $this->template->display( 'hotsales/adquirir', $data );
    }


    public function adquirirHotsale($h,$e,$u,$id_hotsale){

      $usuario = $u->getUsuario($_SESSION['id']);
      $hotsale = $h->getHotsaleConEstadiaYResidencia($id_hotsale);
      $id_estadia = $hotsale['0']['id_estadia'];

      $e->cambiarEstado($id_estadia, 'OCUPADA');

      $h->eliminar($id_hotsale);

      $u->agregarReservaHotsale($_SESSION['id'], $id_estadia);

      $data = array('hotsale' => $hotsale['0'],
                    'usuario' => $usuario['0']);

      $this->template->display('hotsales/detalleAdquirido', $data);

    }

    public function agregar_tarjeta($id, $t, $u){

      $titular= $_POST['titular'];
      $marca= $_POST['marca'];
      $numero= $_POST['numero'];
      $vencimiento= $_POST['vencimiento'];

      $tarjeta = array('titular' => $titular,
                        'marca' => $marca,
                      'numero' => $numero,
                      'vencimiento' => $vencimiento,
                    'id_usuario' => $id,
                      'principal' => 0,
                      'vencimiento_invalido' => 0);


      if ($vencimiento < date('Y-m')) {
          $tarjeta['vencimiento_invalido'] = 1;
          $this->template->display('usuarios/agregar_tarjeta', $tarjeta);
      }

      unset($tarjeta['vencimiento_invalido']);
      $t->insertar($tarjeta);

      if (isset($_SESSION['id'])) {

          $id=$_SESSION['id'];

          $resultado = $u->getUsuario($id);

          if ($resultado) {

              $usuario = array(
              'id' => $resultado['0']['id'],
              'email' => $resultado['0']['email'],
              'nombre' => $resultado['0']['nombre'],
              'apellido' => $resultado['0']['apellido'],
              'foto' => $resultado['0']['foto'],
              'creditos' => $resultado['0']['creditos'],
              'rol' => $resultado['0']['rol'],
              'telefono' => $resultado['0']['telefono'],
              'fecha_nacimiento' => $resultado['0']['fecha_nacimiento'],
              'fecha_registro' => $resultado['0']['fecha_registro']
               );

              $tarjetas= $t->getTarjetas($id);
          }

          $data = array('usuario' => $usuario, 'tarjetas' => $tarjetas, 'agrego_tarjeta' => 1 );
          $this->template->display('usuarios/perfil', $data);
      }
      else{
          $this->template->display('home/home');
      }
    }




}
