<?php

class tarifaController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_tipoTarifa = $this->loadModel("tipoTarifa");
        $this->_tipoVehiculo = $this->loadModel("tipovehiculo");
    }

    public function index() {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Listado';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        $this->_view->datos = $this->_model->resultList();
        $this->_view->renderizar('index', strtolower($this->_presentRequest->getControlador()));
    }
    
    public function agregar() {
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Agregar';
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        $this->_view->tipoTarifas = $this->_tipoTarifa->resultList();
        $this->_view->tipoVehiculos = $this->_tipoVehiculo->resultList();
        if($_POST){
            $this->_model = $this->loadModel($this->_presentRequest->getControlador());
            $this->obj();
        }
        $this->_view->renderizar('obj', ucwords(strtolower($this->_presentRequest->getControlador())));
    }

    public function actualizar($id=0) {
        $this->_model = $this->loadModel($this->_presentRequest->getControlador());
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Actualizar';
        $this->_view->miga = "Actualizar";
        $this->_view->controlador = ucwords($this->_presentRequest->getControlador());
        $this->_view->tipoTarifas = $this->_tipoTarifa->resultList();
        $this->_view->tipoVehiculos = $this->_tipoVehiculo->resultList();
        if($this->filtrarInt($id)<1){
            Session::set('error','Registro No Encontrado.');
            $this->redireccionar();
        }
        $this->_model->get($this->filtrarInt($id));
        if(!$this->_model->getInstance()){
            Session::set('error','Registro No Encontrado.');
            $this->redireccionar();
        }
        $this->_view->dato = $this->_model->getInstance();
        if($_POST){
            $this->obj(false);
        }
        $this->_view->renderizar('obj', ucwords(strtolower($this->_presentRequest->getControlador())));
    }

    private function obj($new = true) {
        $arrayTexto = array('descripcion', 'fechaInicio', 'fechaFin', 'valor');
        $arrayInt = array('tipoTarifa','tipoVehiculo');
        $rta = $this->validarArrays($arrayTexto, $arrayInt);
        if($rta){
            Session::set('error','Falto digitar o seleccionar <b>'.$rta.'</b>');
            $this->redireccionar($this->_presentRequest->getUrl());
        }
        $this->_model->getInstance()->setDescripcion($this->getTexto('descripcion'));
        $this->_model->getInstance()->setFechaInicio(new \DateTime($this->getFecha($this->getTexto('fechaInicio'))));
        $this->_model->getInstance()->setFechaFin(new \DateTime($this->getFecha($this->getTexto('fechaFin'))));
        $this->_model->getInstance()->setTipoVehiculo($this->_tipoVehiculo->get($this->getInt('tipoVehiculo')));
        $this->_model->getInstance()->setTipoTarifa($this->_tipoTarifa->get($this->getInt('tipoTarifa')));
        $this->_model->getInstance()->setValor($this->getPostParam('valor'));
        if($new){
            $this->_model->save(); 
            Session::set('mensaje','Registro Creado con Exito.');
        }else{
            $this->_model->update(); 
            Session::set('mensaje','Registro Actualizado con Exito.');
        }
        $this->redireccionar($this->_presentRequest->getControlador().'/');
    }

}

?>