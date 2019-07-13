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
 * Modelo Filtros
 */
class Hotsales extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

    public function crear($id_estadia, $monto){

      $hotsale = array(
        'id_estadia' => $id_estadia,
          'monto' => $monto
      );

      $this->db->insert('hotsales',$hotsale);
    }

    public function getHotsalesConEstadiaYResidencia(){
      $resultado = $this->db->select('h.monto,
                                      h.id,
                                      e.fecha,
                                      r.nombre,
                                      r.foto,
                                      r.calle,
                                      r.altura,
                                      r.ciudad,
                                      r.provincia',
                                      'hotsales h',
                                      'INNER JOIN estadias e ON (h.id_estadia = e.id)
                                      INNER JOIN residencias r ON (e.id_residencia = r.id)',
                                      "h.estado_logico=0");
      return $resultado;
    }

    public function getHotsaleConEstadiaYResidencia($id){
      $resultado = $this->db->select('h.monto,
                                      h.id,
                                      h.id_estadia,
                                      e.fecha,
                                      e.semana,
                                      r.nombre,
                                      r.foto,
                                      r.calle,
                                      r.altura,
                                      r.ciudad,
                                      r.capacidad,
                                      r.descripcion,
                                      r.provincia',
                                      'hotsales h',
                                      'INNER JOIN estadias e ON (h.id_estadia = e.id)
                                      INNER JOIN residencias r ON (e.id_residencia = r.id)',
                                      "h.id = '$id' and h.estado_logico=0");
      return $resultado;
    }


    public function getHotsale($id){
      $resultado = $this->db->select('*', 'hotsales', null, "id = '$id' AND estado_logico = 0");
      return $resultado;
    }



    public function eliminar($id){

      $hotsale = $this->db->select('estado_logico', 'hotsales', null, "id = '$id' AND estado_logico = 0");

      if (!$hotsale['0']['estado_logico']) {

        $resultado = $this->db->update('hotsales', $datos = array('estado_logico' => 1 ), "id = '$id'");

      }

      return $resultado;

    }


}
