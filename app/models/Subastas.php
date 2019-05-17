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
 * Modelo Subastas
 */
class Subastas extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

     /*

    ------------------------  CREAR SUBASTA  ---------------------------------------------------------------------

    */

    
    public function insertar($id_estadia, $monto){
        $subasta = array('fecha_inicio' => date("m.d.y"),
                        'fecha_fin' => date("m.d.y"),
                        'estado' => 0,
                        'usuario_ganador' => 'meli',
                        'id_estadia' => $id_estadia,
                        'monto' => $monto);

        $this->db->insert('subastas',$subasta);

    }

    /*

    ------------------------  ELIMINAR SUBASTA  ---------------------------------------------------------------------

    */


    /*

    ------------------------  CONSULTAS  ----------------------------------------------------------

    */

    public function existe($id_estadia){
        $resultado = $this->db->select('*', 'subastas', null, "estado = 0 and id_estadia = '$id_estadia'");
        return $resultado;
    }

    public function getSubastas(){

        $resultado = $this->db->select('*', 'subastas', null, "estado = 0");
        return $resultado;
    }

}