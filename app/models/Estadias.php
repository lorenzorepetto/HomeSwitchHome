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
 * Modelo Estadias
 */
class Estadias extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

    /*
    ----------------------------------INSERTAR ESTADIA----------------------------------------
    */

    public function insertar($semana, $monto, $id_residencia){
        

        $e = array(
        	'caducada' => 0,
        	'id_residencia' => $id_residencia,
            'semana' => $semana,
            'ocupada'=> 0,
            'monto' => $monto,
            'estado_logico' => 0
        );


        $this->db->insert('estadias',$e);

    }
}