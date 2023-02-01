<?php
/*
* -------------------------------------
* 
* Date: 04/10/2019 21:05:10 
* pagosancionModel.php
* -------------------------------------
*/
class pagosancionModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Pagosancion'); 
    }
}
?>