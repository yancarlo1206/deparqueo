<?php

class clienteController extends Controller {   
    public function __construct() {
        parent::__construct();
        Session::accesoEstricto(array('AUXILIAR'));
        $this->_tipoCliente = $this->loadModel("tipocliente");
        $this->_usuario = $this->loadModel("usuario");
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
        $this->_view->tipoClientes = $this->_tipoCliente->resultList();
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
        $this->_view->tipoClientes = $this->_tipoCliente->resultList();
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
        $this->_view->renderizar('obj', strtolower($this->_presentRequest->getControlador()));
    }

    private function obj($new = true) {
        $arrayTexto = array('documento', 'nombre', 'telefono');
        $arrayInt = array('tipoCliente');
        $rta = $this->validarArrays($arrayTexto, $arrayInt);
        if($rta){
            Session::set('error','Falto digitar o seleccionar <b>'.$rta.'</b>');
            $this->redireccionar($this->_presentRequest->getUrl());
        }
        $this->_model->getInstance()->setDocumento($this->getTexto('documento'));
        $this->_model->getInstance()->setNombre($this->getTexto('nombre'));
	    $this->_model->getInstance()->setFechaNacimiento(new \DateTime($this->getFecha($this->getTexto('fechaNacimiento'))));
        $this->_model->getInstance()->setDireccion($this->getTexto('direccion'));
        $this->_model->getInstance()->setObservacion($this->getTexto('observacion'));
        $this->_model->getInstance()->setTelefono($this->getTexto('telefono'));
        $this->_model->getInstance()->setEmail($this->getTexto('correo'));
        $this->_model->getInstance()->setTipoCliente($this->_tipoCliente->get($this->getInt('tipoCliente')));
        $this->_model->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
        if($new){
            $this->_model->save(); 
            Session::set('mensaje','Registro Creado con Exito.');
        }else{
            $this->_model->update(); 
            Session::set('mensaje','Registro Actualizado con Exito.');
        }
        $this->redireccionar($this->_presentRequest->getControlador().'/');
    }

    public function eliminar($id=null){
        $this->_cliente = $this->loadModel("cliente");
        $this->_tarjeta = $this->loadModel("tarjeta");
        $clente = $this->_cliente->get($id);
        $tarjetas = $this->_tarjeta->findBy(array('cliente' => $id));
        if(count($tarjetas)){
            Session::set('error','El Cliente no se puede eliminar por tener una <b>Tarjeta Asignada</b>');
            $this->redireccionar($this->_presentRequest->getControlador().'/');
        }
        try {
            $this->_cliente->delete();
            Session::set('mensaje','Se Elimin&oacute; Correctamente el Cliente');
        } catch (Exception $e) {
            Session::set('error','Error en el Proceso');
        }
        $this->redireccionar($this->_presentRequest->getControlador().'/');
    }

}

?>