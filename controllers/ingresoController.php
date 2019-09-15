<?php

class ingresoController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingresoNormal = $this->loadModel('ingresonormal');
        $this->_ingresoTarjeta = $this->loadModel('ingresotarjeta');
        $this->_tarjeta = $this->loadModel('tarjeta');
        $this->_tipoVehiculo = $this->loadModel('tipovehiculo');
    }
    
    public function index() {
    	$this->_view->titulo = 'Ingreso Parqueadero';
        $this->_view->renderizar('index', 'ingreso');
    }

    public function registrar($tipo){
        $tipoVehiculo = $this->_tipoVehiculo->get($tipo);
        $fechaIngreso = new \DateTime();
        $temp = $this->_ingreso->dql("SELECT i FROM Entities\Ingreso i WHERE i.fecha =:fecha",
            array('fecha' => $fechaIngreso->format('Y-m-d')));
        $cuenta = str_pad(count($temp)+1, 3, "0", STR_PAD_LEFT);
        $numero = $tipoVehiculo->getResumen().$fechaIngreso->format('dmy').$cuenta;
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingreso->getInstance()->setTipo($this->_tipoVehiculo->getInstance());
        $this->_ingreso->getInstance()->setFecha($fechaIngreso);
        $this->_ingreso->getInstance()->setFechaingreso($fechaIngreso);
        $this->_ingreso->getInstance()->setNumero($numero);
        try {
            $this->_ingreso->save();
            $this->_ingresoNormal->getInstance()->setId($this->_ingreso->getInstance());
            $this->_ingresoNormal->save();
            Session::set('mensaje','Ingreso Correcto');
        } catch (Exception $e) {
             Session::set('error','Error en el Proceso');       
        }
        $this->redireccionar('ingreso');
    }

    public function registrarTarjeta(){
        $tarjeta = $this->_tarjeta->findByObject(array('rfid' => $this->getPostParam('tarjeta')));
        if(!$tarjeta){
            Session::set('error','La Tarjeta RDIF no Existe');
            $this->redireccionar('ingreso');
        }
        $fechaIngreso = new \DateTime();
        $this->_ingreso->getInstance()->setTipo($this->_tipoVehiculo->get($tarjeta->getTipoVehiculo()->getId()));
        $this->_ingreso->getInstance()->setFecha($fechaIngreso);
        $this->_ingreso->getInstance()->setFechaingreso($fechaIngreso);
        try {
            $this->_ingreso->save();
            $this->_ingresoTarjeta->getInstance()->setId($this->_ingreso->getInstance());
            $this->_ingresoTarjeta->getInstance()->setTarjeta($tarjeta);
            $this->_ingresoTarjeta->save();
            Session::set('mensaje','Ingreso Correcto');
        } catch (Exception $e) {
             Session::set('error','Error en el Proceso');       
        }
        $this->redireccionar('ingreso');
    }

}

?>