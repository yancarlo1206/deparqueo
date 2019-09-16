<?php

class pagoController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_ingreso = $this->loadModel('ingreso');
        $this->_ingresoNormal = $this->loadModel('ingresonormal');

        $this->_pago = $this->loadModel('pago');
        $this->_pagoServicio = $this->loadModel('pagoservicio');
        $this->_ingreso = $this->loadModel('ingreso');

        $this->_tarjeta = $this->loadModel('tarjeta');
        $this->_pagoMensual = $this->loadModel('pagomensual');

        $this->_tarifa = $this->loadModel('tarifa');
        $this->_tipoTarifa = $this->loadModel('tipotarifa');

        $this->_usuario = $this->loadModel('usuario');
        $this->_caja = $this->loadModel('caja');

        $this->_view->setJs(array('validar'));
    }
    
    public function index() {
        $fecha = new \DateTime();
        $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
        $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        $this->_view->fecha = $fecha->format('d/m/Y');
        if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            $this->_view->fecha = $fecha->format('d/m/Y');
            $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
            $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        }
    	$this->_view->pagos = $this->_pago->dql(
            "SELECT p FROM Entities\Pago p WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
       );
    	$this->_view->titulo = 'Ingreso Parqueadero';
        $this->_view->renderizar('index', 'pagos');
    }

    public function registrar(){
    	if($this->getInt('guardar') == 1){
    		$this->_pago->getInstance()->setFecha(new \DateTime());
            $totalPagar = $this->getPostParam('totalPagarNumero');
            $iva = $totalPagar * 0.16;
            $valor = $totalPagar - $iva;
    		$this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
    		$this->_pago->getInstance()->setIngreso($this->getInt('ingreso'));
    		$this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
    		$this->_pago->getInstance()->setCaja($this->_caja->get(1));
    		try {
    			$this->_pago->save();
	    		$this->_pagoServicio->getInstance()->setId($this->_pago->getInstance());
	    		$this->_pagoServicio->getInstance()->setIngreso($this->_ingresoNormal->get($this->getInt('ingreso')));
	    		$this->_pagoServicio->save();
				Session::set('mensaje','Registro de Pago Correcto');
    		} catch (Exception $e) {
    			Session::set('error','Error en el Proceso');
    		}
			$this->redireccionar('pago/registrar/');
    	}
    	$this->_view->titulo = 'Pago Parqueadero';
        $this->_view->renderizar('registro', 'pago');	
    }

    public function cargarPago(){
        $ticket = $this->getPostParam('ticket');
    	$array = array();
    	$ingreso = $this->_ingreso->findByObject(array('numero' => $ticket));
        if(!$ingreso){
            $array['data'] = "error";   
            $array['mensaje'] = "El Ticket no Existe";
            echo json_encode($array);
            exit;
        }
        if($ingreso->getFechaSalida() != NULL){
            $array['data'] = "error";   
            $array['mensaje'] = "El Ticket ya salio del sistema";
            echo json_encode($array);
            exit;
        }
    	$ingresoNormal = $this->_ingresoNormal->get($ingreso->getId());
        if(count($ingresoNormal->getPagos())){
            $array['data'] = "error";   
            $array['mensaje'] = "El Ticket ya est&aacute; PAGO";
            echo json_encode($array);
            exit;
        }
        if(count($ingresoNormal->getNoPagos())){
            $array['data'] = "error";   
            $array['mensaje'] = "El Ticket no necesita realizar un PAGO";
            echo json_encode($array);
            exit;
        }
        if(count($ingresoNormal->getCancelados())){
            $array['data'] = "error";   
            $array['mensaje'] = "El Ticket est&aacute; CANCELADO";
            echo json_encode($array);
            exit;
        }
    	if($ingresoNormal){
            $fechaEntrada = $ingreso->getFechaIngreso();
            $fechaSalida = new \DateTime();
            $fechaIntervalo = $fechaEntrada->diff($fechaSalida);
    	    $totalPagar = $this->valorPagar($ingreso, $fechaIntervalo);
    	}
    	$array['data'] = "ok";
    	$array['ticket'] = $ingreso->getNumero();
    	$array['ingreso'] = $ingreso->getId();
    	$array['fecha'] = $ingreso->getFechaIngreso()->format("d/m/Y");
    	$array['horaIni'] = $fechaEntrada->format("h:i A");
    	$array['horaFin'] = $fechaSalida->format("h:i A");
    	$array['tiempoTotal'] = $fechaIntervalo->format("%h horas %i minutos");
    	$array['totalPagar'] = $totalPagar;
    	echo json_encode($array);
    }

    public function valorPagar($ingreso=null, $fechaIntervalo=null){
        $tarifaHora = $this->_tarifa->dql("SELECT t FROM Entities\Tarifa t 
            WHERE t.fechainicio <=:fecha AND t.fechafin >=:fecha 
            AND t.tipovehiculo =:tipoVehiculo AND t.tipotarifa = 1",
            array('fecha' => new \DateTime(), 'tipoVehiculo' => $ingreso->getTipo()->getId()));
        $tarifaFraccion = $this->_tarifa->dql("SELECT t FROM Entities\Tarifa t 
            WHERE t.fechainicio <=:fecha AND t.fechafin >=:fecha 
            AND t.tipovehiculo =:tipoVehiculo AND t.tipotarifa = 2",
            array('fecha' => new \DateTime(), 'tipoVehiculo' => $ingreso->getTipo()->getId()));
        $intervaloHora = $fechaIntervalo->format("%h");
        $intervaloMinuto = $fechaIntervalo->format("%i");
        $valorTemporalHora = 0;
        $valorTemporalFraccion = 0;
        if($intervaloHora > 0){
            $valorTemporalHora = $intervaloHora * $tarifaHora[0]->getValor();
        }
        if($intervaloMinuto > 0){
            if($intervaloMinuto < 16){
                $valorTemporalFraccion = $tarifaFraccion[0]->getValor();
            }else if($intervaloMinuto < 31){
                $valorTemporalFraccion = 2 * $tarifaFraccion[0]->getValor();
            }else if($intervaloMinuto < 46){
                $valorTemporalFraccion = 3 * $tarifaFraccion[0]->getValor();
            }else{
                $valorTemporalFraccion = 4 * $tarifaFraccion[0]->getValor();
            } 
        }
        return $valorTotal = $valorTemporalHora + $valorTemporalFraccion;
    }

    public function mensual() {
        $this->_view->pagos = $this->_pagoMensual->resultList();
        $this->_view->titulo = 'Pago Mensual';
        $this->_view->renderizar('mensual', 'pagosmensual');
    }

    public function registrarmensual(){
        if($this->getInt('guardar') == 1){
            $this->_pago->getInstance()->setFecha(new \DateTime());
            $this->_pago->getInstance()->setValor($this->getPostParam('totalPagarNumero'));
            $this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            $this->_pago->getInstance()->setCaja($this->_caja->get(1));
            try {
                $this->_pago->save();
                $this->_pagoMensual->getInstance()->setId($this->_pago->getInstance());
                $this->_pagoMensual->getInstance()->setTarjeta($this->_tarjeta->get($this->getInt('tarjeta')));
                $this->_pagoMensual->getInstance()->setValor($this->getPostParam('totalPagarNumero'));
                $this->_pagoMensual->getInstance()->setFecha(new \DateTime());
                $this->_pagoMensual->getInstance()->setFechaRegistro(new \DateTime());
                $this->_pagoMensual->save();
                Session::set('mensaje','Registro de Pago Mensual Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('pago/registrarmensual/');
        }
        $this->_view->titulo = 'Pago Mensual Parqueadero';
        $this->_view->renderizar('registromensual', 'pago');   
    }

    public function cargarPagoMensual(){
        $tarjeta = $this->getPostParam('tarjeta');
        $array = array();
        $tarjeta = $this->_tarjeta->findByObject(array('rfid' => $tarjeta));
        $tarifa = $this->_tarifa->dql("SELECT t FROM Entities\Tarifa t 
            WHERE t.fechainicio <=:fecha AND t.fechafin >=:fecha 
            AND t.tipovehiculo =:tipoVehiculo AND t.tipotarifa = 3",
            array('fecha' => new \DateTime(), 'tipoVehiculo' => $tarjeta->getTipoVehiculo()->getId()));
        $totalPagar = $tarifa[0]->getValor();
        $array['data'] = "ok";
        $array['tarjeta'] = $tarjeta->getRfid();
        $array['cliente'] = $tarjeta->getCliente()->getNombre();
        $array['totalPagar'] = $totalPagar;
        echo json_encode($array);
    }

}

?>