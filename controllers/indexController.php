<?php

class indexController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_usuario = $this->loadModel('usuario');
    }
    
    public function index() {
    	$this->_view->titulo = '';
    	if(Session::get('autenticado')){
            if(Session::get('level') == 'PORTERO'){
                $this->redireccionar('ingreso');
            }else if(Session::get('level') == 'CAJERO'){
                $this->redireccionar('pago');
            }else{
                $this->_view->renderizar('index', 'inicio');
            }
        }else{
        	$this->_view->renderizar('indexLogin', 'inicio');
        }
         //$this->_view->renderizar('index', 'inicio');
    }

}

?>