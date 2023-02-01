<?php

class operacionController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingresoTarjeta = $this->loadModel('ingresotarjeta');
        $this->_tarjeta = $this->loadModel('tarjeta');
        $this->_usuario = $this->loadModel('usuario');
        $this->_variable = $this->loadModel('variable');
        $this->_configuracion = $this->loadModel('configuracion');
        $this->_view->setJs(array('validar'));
    }
    
    public function index() {
        Session::accesoEstricto(array('AUXILIAR'));
        $fecha = (new \DateTime())->format('Y-m-d');
    	$this->_view->ingresos = $this->_tarjeta->dql(
            "SELECT i FROM Entities\Ingreso i 
            INNER JOIN Entities\IngresoTarjeta it WITH i.id = it.id
            INNER JOIN Entities\Tarjeta t WITH t.rfid = it.tarjeta
            INNER JOIN Entities\Tarifa ta WITH ta.id = t.tarifa
            WHERE i.fechasalida is null AND ta.tipotarifa <> 7 AND t.estado = 1 order by i.fechaingreso desc",
           array()
        );
        $this->_view->fecha = $fecha;
        $this->_view->titulo = ucwords('Operaciones :: Listado');
        $this->_view->renderizar('index', 'operacion');
    }

    public function darSalida($ingreso=null){
        $this->_ingreso->get($ingreso);
        $this->_ingreso->getInstance()->setFechaSalida(new \DateTime());
        $this->_ingreso->update();
        Session::set('mensaje','Se Registr&oacute; la Salida de la Tarjeta');
        $this->redireccionar('operacion');
    }

    public function abrirTalanquera($tipo=null){
        $entrada = $this->_configuracion->get(1);
        $salida = $this->_configuracion->get(2);
        if($tipo == 1){
            $ch = curl_init("http://".$entrada->getValor().":8080");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_exec($ch);
            curl_close($ch);
            Session::set('mensaje','La Talanquera de Entrada se Abri&oacute; Correctamente');
        }else{
            $ch = curl_init("http://".$salida->getValor().":8080");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_exec($ch);
            curl_close($ch);
            Session::set('mensaje','La Talanquera de Salida se Abri&oacute; Correctamente');
        }
        $this->redireccionar('operacion');
    }

}

?>