<?php

class usuarioController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_rol = $this->loadModel("rol");
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
        $this->_view->roles = $this->_rol->resultList();
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
        $this->_view->roles = $this->_rol->resultList();
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
        $arrayTexto = array('documento', 'nombre', 'fechaNacimiento','correo');
        $arrayInt = array('rol');
        $rta = $this->validarArrays($arrayTexto, $arrayInt);
        if($rta){
            Session::set('error','Falto digitar o seleccionar <b>'.$rta.'</b>');
            $this->redireccionar($this->_presentRequest->getUrl());
        }
        $this->_model->getInstance()->setDocumento($this->getTexto('documento'));
        $this->_model->getInstance()->setNombre($this->getTexto('nombre'));
        $this->_model->getInstance()->setFechaNacimiento(new \DateTime($this->getFecha($this->getTexto('fechaNacimiento'))));
        $this->_model->getInstance()->setUsuario($this->getTexto('usuario'));
        $this->_model->getInstance()->setClave(Hash::getHash('sha1', '1234', HASH_KEY));
        $this->_model->getInstance()->setEmail($this->getTexto('correo'));
        $this->_model->getInstance()->setRol($this->_rol->get($this->getInt('rol')));
        if($new){
            $this->_model->save(); 
            Session::set('mensaje','Registro Creado con Exito.');
        }else{
            $this->_model->update(); 
            Session::set('mensaje','Registro Actualizado con Exito.');
        }
        $this->redireccionar($this->_presentRequest->getControlador().'/');
    }

    public function cambiar_clave(){
        if($this->getInt('guardar') == 1){
            $this->_usuario = $this->loadModel('usuario');
            $this->_usuario->get(Session::get('codigo'));
            if($this->_usuario->getInstance()->getClave() != Hash::getHash('sha1', $this->getTexto('actual'), HASH_KEY)){
                Session::set('error','La Clave Actual no Coindice');
                $this->redireccionar('usuario/cambiar_clave/');
            }
            if($this->getTexto('nueva') != $this->getTexto('repetida')){
                Session::set('error','No Coinciden las Claves');
                $this->redireccionar('usuario/cambiar_clave/');
            }
            $this->_usuario->getInstance()->setClave(Hash::getHash('sha1', $this->getTexto('nueva'), HASH_KEY));            
            $this->_usuario->update();
            Session::set('mensaje','Clave Actualizada Correctamente');
            $this->redireccionar('usuario/cambiar_clave/');
        }
        $this->_view->renderizar('clave', '');
    }

}

?>