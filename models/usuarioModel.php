<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* usuarioModel.php
* -------------------------------------
*/
class usuarioModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Usuario'); 
    }
}
?>