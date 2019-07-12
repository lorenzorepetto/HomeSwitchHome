<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Models\Models;
use Ocrend\Kernel\Models\IModels;
use Ocrend\Kernel\Models\ModelsException;
use Ocrend\Kernel\Models\Traits\DBModel;
use Ocrend\Kernel\Router\IRouter;

/**
 * Modelo Tarjeta
 */
class Tarjeta extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

    public function insertar($tarjeta){

    	$id=$this->db->insert('tarjetas', $tarjeta);
    }

    public function getTarjetas($id){
    	$resultado = $this->db->select('*', 'tarjetas', null, "estado_logico = 0 and id_usuario='$id'");
    	return $resultado;

    }

    public function cambiar_principal($id_usuario, $id_tarjeta){
      //pongo todas las tarjetas del usuario en 0
      $datos = array('principal' => 0 );
      $resultado = $this->db->update('tarjetas', $datos, "id_usuario = '$id_usuario' AND estado_logico = 0");

      //pongo la nueva en 1
      $datos['principal'] = 1;
      $resultado = $this->db->update('tarjetas', $datos, "id_usuario = '$id_usuario' AND estado_logico = 0 AND id = '$id_tarjeta'");

      return $resultado;
    }


}
