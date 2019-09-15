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

}

?>