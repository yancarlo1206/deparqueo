<?php

class ticketController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingresoNormal = $this->loadModel('ingresonormal');
        $this->_ingresoCancelado = $this->loadModel('ingresocancelado');
        $this->_noPagoServicio = $this->loadModel('nopagoservicio');
        $this->_usuario = $this->loadModel('usuario');

        $this->_view->setJs(array('validar'));
    }
    
    public function index() {
        $fecha = (new \DateTime())->format('Y-m-d');
        $this->_view->fecha = (new \DateTime())->format('d/m/Y');
    	if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            //$fecha = new \DateTime($this->getTexto('fecha'));
            $this->_view->fecha = $fecha->format('d/m/Y');
        }
        $this->_view->tickets = $this->_ingreso->dql(
            "SELECT i FROM Entities\Ingreso i INNER JOIN Entities\IngresoNormal ing 
            WITH i.id = ing.id WHERE i.fecha =:fecha",
           array('fecha' => $fecha)
        );
    	$this->_view->titulo = 'Listado de Tickets';
        $this->_view->renderizar('index', 'ticket');
    }

    public function pasecortesia($ticket=null){
    	if($this->getInt('guardar') == 1){
            $this->_noPagoServicio->findByObject(array('ingreso' => $this->getInt('ingreso')));
            if($this->_noPagoServicio->getInstance()->getId()){
               Session::set('error','El Ticket ya tiene Registrado el No Pago'); 
               $this->redireccionar('ticket/');
            }
            $this->_ingresoNormal->get($this->getInt('ingreso'));
    		$this->_noPagoServicio->getInstance()->setIngreso($this->_ingresoNormal->getInstance());
    		$this->_noPagoServicio->getInstance()->setObservacion($this->getTexto('observacion'));
            $this->_noPagoServicio->getInstance()->setFecha(new \DateTime());
            $this->_noPagoServicio->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
    		try {
    			$this->_noPagoServicio->save();
				Session::set('mensaje','Registro de No Pago Correcto');
    		} catch (Exception $e) {
    			Session::set('error','Error en el Proceso');
    		}
			$this->redireccionar('ticket/');
    	}
        $this->_view->ticket = $this->_ingreso->get($ticket);
    	$this->_view->titulo = 'Pase Cortesia';
        $this->_view->renderizar('registro', 'ticket');	
    }

    public function anular($ticket=null){
        if($this->getInt('guardar') == 1){
            $this->_ingresoCancelado->findByObject(array('ingreso' => $this->getInt('ingreso')));
            if($this->_ingresoCancelado->getInstance()->getId()){
               Session::set('error','El Ticket ya est&aacute; cancelado'); 
               $this->redireccionar('ticket/');
            }
            $this->_ingresoNormal->get($this->getInt('ingreso'));
            $this->_ingresoCancelado->getInstance()->setIngreso($this->_ingresoNormal->getInstance());
            $this->_ingresoCancelado->getInstance()->setObservacion($this->getTexto('observacion'));
            $this->_ingresoCancelado->getInstance()->setFecha(new \DateTime());
            $this->_ingresoCancelado->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            try {
                $this->_ingresoCancelado->save();
                Session::set('mensaje','Registro de Cancelaci&oacute;n Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('ticket/');
        }
        $this->_view->ticket = $this->_ingreso->get($ticket);
        $this->_view->titulo = 'Anulaci&oacute;n Ticket';
        $this->_view->renderizar('cancelacion', 'ticket');   
    }

    public function imprimir($ticket=null){
        $ingreso = $this->_ingreso->findByObject(array('numero' => $ticket));
        $data = array(
        "ticket" => $ticket,
        "fecha" => $ingreso->getFecha()->format('d/m/Y'));
        $ch = curl_init("http://190.145.239.11:8086/pdf/0/ticket_210");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        header("Location:http://190.145.239.11:8085/files/informes/".$response);
    }


}

?>