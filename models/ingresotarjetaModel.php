<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* ingresotarjetaModel.php
* -------------------------------------
*/
class ingresotarjetaModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Ingresotarjeta'); 
    }
}
?>