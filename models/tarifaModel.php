<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* tarifaModel.php
* -------------------------------------
*/
class tarifaModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Tarifa'); 
    }
}
?>