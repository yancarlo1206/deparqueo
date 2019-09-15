<?php
/*
* -------------------------------------
* 
* Date: 29/08/2019 23:06:05 
* ingresocanceladoModel.php
* -------------------------------------
*/
class ingresocanceladoModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Ingresocancelado'); 
    }
}
?>