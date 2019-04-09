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
 * Modelo Admin
 */
class Admin extends Models implements IModels {
    use DBModel;

    /**
     * Respuesta generada por defecto para el endpoint
     * 
     * @return array
    */ 
    public function foo() : array {
        try {
            global $http;
                    
            return array('success' => 0, 'message' => 'Funcionando');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }





    /*
        ------------------------------USUARIOS------------------------------------------------
    */



    public function update($id, $datos){

        $resultado = $this->db->update('usuarios', $datos, "id = '$id'");

        if ($resultado){
            return true;
        }

        return false;
    }





    public function cambiarRol($id){

        $usuario = $this->db->select('rol', 'usuarios', null, "id = '$id'");

        if ($usuario['0']['rol'] == 'ESTANDAR'){
            $nuevo_rol = 'PREMIUM';
        }
        elseif ($usuario['0']['rol'] == 'PREMIUM') {
            $nuevo_rol = 'ESTANDAR';
        }

        $this->update($id, array('rol' => $nuevo_rol)); 

    }
    





}