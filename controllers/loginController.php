<?php

class loginController extends Controller {
    public function __construct(){
        parent::__construct();
        $this->_usuario = $this->loadModel('usuario');
    }
    
    public function index() {
        if(Session::get('autenticado')){
            $this->redireccionar();
        }
        if($_POST){
            $this->_loginValidate();
        }
        $this->redireccionar();
    }

    public function iniciar() {
        $this->_view->titulo = 'Iniciar Sesión';
        if(Session::get('autenticado')){
            $this->redireccionar();
        }
        $this->_view->renderizar('index', ucwords($this->_view->titulo));
    }

    public function cerrar() {
        Session::destroy();
        $this->redireccionar();
    }

    private function _loginValidate(){
        if($_POST){
            if(!$this->getTexto('usuario')){
                Session::set('error','Debe Introducir un Usuario');
                $this->redireccionar();
                exit;
            }
            if(!$this->getSql('clave')){
                Session::set('error','Debe Introducir una Clave');
                $this->redireccionar();
                exit;
            }
            $usuario = $this->_usuario->findByObject(array('clave' => Hash::getHash('sha1', $this->getSql('clave'), HASH_KEY),'usuario'  => $this->getTexto('usuario')));
            if(!$usuario){
                Session::set('error','Codigo y/o Clave Incorrectos');
                $this->redireccionar();
                exit;
            }
            Session::set('autenticado', true);
            
            Session::set('level', $usuario->getRol()->getDescripcion());
            if($usuario->getRol()->getId() == 3){
                //$this->iniciarCaja($usuario);
            }
            Session::set('usuario', $usuario->getUsuario());
            Session::set('nombre', $usuario->getNombre());
            Session::set('codigo', $usuario->getId());
            Session::set('tiempo', time());
            Session::set('mensaje','Bienvenido <b>'.$usuario->getNombre().'</b>');
        }
    }

    private function iniciarCaja($usuario=null){
        $this->_accesoCaja = $this->loadModel("accesocaja");
        $this->_caja = $this->loadModel("caja");
        $this->_accesoCaja->getInstance()->setCaja($this->_caja->get(1));
        $this->_accesoCaja->getInstance()->setUsuario($usuario);
        $this->_accesoCaja->getInstance()->setFechaInicio(new \DateTime());
        $this->_accesoCaja->save();
    }
    
}

?>