<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* tipoclienteModel.php
* -------------------------------------
*/
class configuracionModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Configuracion'); 
    }
}
?>