<?php

class salidaController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingresoNormal = $this->loadModel('ingresonormal');
        $this->_tarjeta = $this->loadModel('tarjeta');
        $this->_ingresoTarjeta = $this->loadModel('ingresoTarjeta');
    }
    
    public function index() {
    	$this->_view->titulo = 'Salida Parqueadero';
        $this->_view->renderizar('index', 'salida');
    }

    public function salidaNormal(){
        $ticket = $this->getTexto('ticket');
        $this->_ingreso->findByObject(array('numero' => $ticket));
        if(!$this->_ingreso->getInstance()){
            Session::set('error','No se encuentra el TICKET');
            $this->redireccionar('salida');
        }
        if($this->_ingreso->getInstance()->getFechaSalida()){
            Session::set('error','El TICKET ya se encuentra registrado');
            $this->redireccionar('salida');   
        }
        $this->_ingresoNormal->get($this->_ingreso->getInstance()->getId());
        $salida = false;
        if(count($this->_ingresoNormal->getInstance()->getNoPagos())){
            $salida = true;
        }
        if(count($this->_ingresoNormal->getInstance()->getCancelados())){
            $salida = true;
        }
        if(!$salida && !count($this->_ingresoNormal->getInstance()->getPagos())){
            Session::set('error','El TICKET no tiene un PAGO registrado');
            $this->redireccionar('salida');
        }
        $this->_ingreso->getInstance()->setFechaSalida(new \DateTime());
        try {
            $this->_ingreso->save();
            Session::set('mensaje','Registro de Salida Correcto');
        } catch (Exception $e) {
            Session::set('error','Error en el Proceso');
        }
        $this->redireccionar('salida');
    }

    public function salidaTarjeta(){
        $tarjeta = $this->getTexto('tarjeta');
        $ingresoTarjeta = $this->_ingresoTarjeta->dql(
            "SELECT i FROM Entities\IngresoTarjeta i INNER JOIN Entities\Ingreso ing WITH ing.id = i.id
            WHERE i.tarjeta =:tarjeta AND ing.fechasalida is NULL", 
            array('tarjeta' => $tarjeta)
        );
        if(!$ingresoTarjeta){
            Session::set('error','No se encuentra el Ingreso de la Tarjeta');
            $this->redireccionar('salida');
        }
        /*if($ingresoTarjeta[0]->getId()->getFechaSalida()){
            Session::set('error','La Tarjeta ya tiene salida registrada');
            $this->redireccionar('salida');   
        }*/
        $this->_ingreso->get($ingresoTarjeta[0]->getId()->getId());
        $this->_ingreso->getInstance()->setFechaSalida(new \DateTime());
        try {
            $this->_ingreso->save();
            Session::set('mensaje','Registro de Salida Correcto');
        } catch (Exception $e) {
            Session::set('error','Error en el Proceso');
        }
        $this->redireccionar('salida');
    }

}

?>