<?php
/*
* -------------------------------------
* 
* Date: 17/06/2019 21:52:50 
* ingresonormalModel.php
* -------------------------------------
*/
class ingresonormalModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Ingresonormal'); 
    }
}
?>