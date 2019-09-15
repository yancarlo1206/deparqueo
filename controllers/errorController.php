<?php

class errorController extends Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError();
        $this->_view->renderizar('index','Error');
    }
    
    public function access($codigo=0) {
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError($codigo);
        $this->_view->renderizar('index','Error');
    }
    
    private function _getError($codigo = false) {
        if($codigo){
            $codigo = $this->filtrarInt($codigo);
            if(is_int($codigo))
                $codigo = $codigo;
        }
        else{
            $codigo = 'default';
        }        
        $error['default'] = 'Ha ocurrido un error y la página no puede mostrarse';
        $error['5050'] = 'Acceso restringido';
        $error['8080'] = 'Tiempo de la sesion agotado';
        $error['404'] = 'Archivo no encontrado';
        $error['5643'] = 'El usuario no existe';
        $error['9423'] = 'error de controlador';
        $error['7345'] = 'error de modelo';
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }
        else{
            return $error['default'];
        }
    }
    
}

?>