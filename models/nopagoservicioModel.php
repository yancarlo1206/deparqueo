<?php
/*
* -------------------------------------
* 
* Date: 29/08/2019 23:06:05 
* nopagoservicioModel.php
* -------------------------------------
*/
class nopagoservicioModel extends Model {
    public function __construct() {
        parent::__construct(); 
        $this->instance = $this->loadObjeto('Nopagoservicio'); 
    }
}
?>