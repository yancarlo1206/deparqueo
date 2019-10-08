<?php

class cierreController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_accesoCaja = $this->loadModel('accesocaja');
        $this->_pago = $this->loadModel('pago');
    }
    
    public function index() {
        $accesoCaja = $this->_accesoCaja->findByObject(array('usuario' => Session::get('codigo')));
        $pagos = $this->_pago->findBy(array('caja' => $accesoCaja->getCaja()->getId()));
        $totalRecibido = 0;
        foreach ($pagos as $key => $value) {
            $totalRecibido += $value->getValor();
        }
    }

    public function sql(){
	$sql = "SELECT usuario.usuario, SUM(pago.valor+pago.iva) AS total, COUNT(pago.id) AS cantidad 
        FROM pago INNER JOIN usuario ON usuario.id = pago.usuario INNER JOIN rol ON rol.id = usuario.rol
        WHERE DATE(fecha) = CURDATE() AND rol.id=4
        GROUP BY usuario.usuario";
	$temp =	$this->_pago->nativeQuery($sql);
	$arrayInt = array();
	$array = array();
	foreach ($temp as $key => $value) {
	   $arrayInt['usuario'] = $value['usuario'];
	   $arrayInt['cantidad'] = $value['cantidad'];
	   $arrayInt['total'] = $value['total'];
           $array[] = $arrayInt;
        }
        echo json_encode($array);
    }

    public function foto(){
    	if (file_exists("/home/var/dparqueo/fotos/0000699586-out.jpg")){
          echo "El fichero existe";
        }else{
          echo "El fichero no existe";
}
    }

}

?>