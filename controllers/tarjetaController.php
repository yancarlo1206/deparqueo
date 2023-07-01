<?php

class tarjetaController extends Controller {   
    public function __construct() {
        parent::__construct();
        Session::accesoEstricto(array('AUXILIAR'));
        $this->_cliente = $this->loadModel("cliente");
        $this->_tarifa = $this->loadModel("tarifa");
        $this->_tipoVehiculo = $this->loadModel("tipovehiculo");
        $this->_usuario = $this->loadModel("usuario");
        $this->_tarjetaBathroom = $this->loadModel("tarjetabathroom");
    }

    public function index() {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Listado';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        //$this->_view->datos = $this->_model->resultList();
        $this->_view->datos = $this->_model->findBy(array('estado' => 1));
        $this->_view->text = "";
        $this->_view->renderizar('index', strtolower($this->_presentRequest->getControlador()));
    }
    
    public function agregar() {
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Agregar';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
	    $this->_view->clientes = $this->_cliente->findBy(array(),array('nombre' => 'asc'));
        $this->_view->tarifas = $this->_tarifa->findBy(array(),array('descripcion' => 'asc'));
        $this->_view->tipoVehiculos = $this->_tipoVehiculo->resultList();
        if($_POST){
            $this->_model = $this->loadModel($this->_presentRequest->getControlador());
            $this->obj();
        }
        $this->_view->renderizar('obj', strtolower($this->_presentRequest->getControlador()));
    }

    public function actualizar($id=0) {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Actualizar';
        $this->_view->miga = "Actualizar";
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
	    $this->_view->clientes = $this->_cliente->findBy(array(),array('nombre' => 'asc'));
        $this->_view->tarifas = $this->_tarifa->findBy(array(),array('descripcion' => 'asc'));
        $this->_view->tipoVehiculos = $this->_tipoVehiculo->resultList();
        /*if($this->filtrarInt($id)<1){
            Session::set('error','Registro No Encontrado.');
            $this->redireccionar();
        }*/
        $this->_model->get($id);
        if(!$this->_model->getInstance()){
            Session::set('error','Registro No Encontrado.');
            $this->redireccionar();
        }
        $this->_view->dato = $this->_model->getInstance();
        if($_POST){
            $this->obj(false);
        }
        $this->_view->renderizar('obj', strtolower($this->_presentRequest->getControlador()));
    }

    private function obj($new = true) {
        $arrayTexto = array('rfid', 'fechaInicio', 'fechaFin');
        $arrayInt = array('cliente','tipoVehiculo','estado');
        $rta = $this->validarArrays($arrayTexto, $arrayInt);
        if($rta){
            Session::set('error','Falto digitar o seleccionar <b>'.$rta.'</b>');
            $this->redireccionar($this->_presentRequest->getUrl());
        }
        $this->_model->getInstance()->setRfid($this->getTexto('rfid'));
        $this->_model->getInstance()->setFechaInicio(new \DateTime($this->getFecha($this->getTexto('fechaInicio'))));
        $this->_model->getInstance()->setFechaFin(new \DateTime($this->getFecha($this->getTexto('fechaFin'))));
        $this->_model->getInstance()->setCliente($this->_cliente->get($this->getInt('cliente')));
        $this->_model->getInstance()->setTipoVehiculo($this->_tipoVehiculo->get($this->getInt('tipoVehiculo')));
        $this->_model->getInstance()->setTarifa($this->_tarifa->get($this->getInt('tarifa')));
        $this->_model->getInstance()->setUsuarioActivo($this->_usuario->get(Session::get('codigo')));
        $this->_model->getInstance()->setEstado($this->getInt('estado'));
        if($new){
            $this->_model->save(); 
            Session::set('mensaje','Registro Creado con Exito.');
        }else{
            $this->_model->update(); 
            Session::set('mensaje','Registro Actualizado con Exito.');
        }
        $this->redireccionar($this->_presentRequest->getControlador().'/');
    }

    public function vencidas() {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Listado';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        $fecha = new \DateTime();
        $this->_view->datos = $this->_model->dql("SELECT t FROM Entities\Tarjeta t WHERE t.fechafin <:fecha AND t.estado = 1",
        array('fecha' => $fecha->format('Y-m-d')));
        $this->_view->text = "Vencidas";
        $this->_view->renderizar('index', strtolower($this->_presentRequest->getControlador()));
    }

    public function inactivas() {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Listado';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        $this->_view->datos = $this->_model->findBy(array('estado' => 2));
        $this->_view->text = "Inactivas";
        $this->_view->renderizar('index', strtolower($this->_presentRequest->getControlador()));
    }

    public function bathroom() {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->datos = $this->_tarjetaBathroom->findBy(array('estado' => 1));
        $this->_view->renderizar('bathroom', strtolower($this->_presentRequest->getControlador()));
    }

}

?>