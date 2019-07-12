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

/**
 * Controlador estadias/
*/
class estadiasController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $router->setRoute('/fecha_desde');
        $router->setRoute('/fecha_hasta');
        $router->setRoute('/ciudad');

        $e = new Model\Estadias;
        $u = new Model\Usuarios;

        switch ($router->getMethod()) {
          case 'confirmacion':
            $id = $router->getId();
            $this->confirmacion($e,$u,$id,$router->getRoute('/fecha_desde'),$router->getRoute('/fecha_hasta'),$router->getRoute('/ciudad'));
            break;

          case 'adquirir':
            $id = $router->getId();
            $this->adquirir($e,$u,$id,$router->getRoute('/fecha_desde'),$router->getRoute('/fecha_hasta'),$router->getRoute('/ciudad'));
            break;

          default:
            // code...
            break;
        }
    }


    public function confirmacion($e, $u, $id , $desde , $hasta,$ciudad){

      $estadia = $e->getEstadiaConResidencia($id);
      $usuario = $u->getUsuario($_SESSION['id']);

      $data = array('estadia' => $estadia[0],
                    'usuario' => $usuario[0],
                    'fecha_desde' => $desde,
                    'fecha_hasta' => $hasta,
                    'ciudad' => $ciudad);

      $this->template->display('estadias/adquirirEstadia', $data);

    }


    public function adquirir($e, $u, $id, $desde , $hasta,$ciudad){

      $estadia = $e->getEstadiaConResidencia($id);
      $usuario = $u->getUsuario($_SESSION['id']);

      $e->cambiarEstado($id, 'OCUPADA');
      $u->restarCredito($_SESSION['id']);



      $data = array('estadia' => $estadia[0],
                    'usuario' => $usuario[0],
                    'fecha_desde' => $desde,
                    'fecha_hasta' => $hasta,
                    'ciudad' => $ciudad);

      $this->template->display('estadias/detalleAdquirida', $data);

    }


}
