<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* cajaModel.php
* -------------------------------------
*/
class cajaModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Caja'); 
    }
}
?>