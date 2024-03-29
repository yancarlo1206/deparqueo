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

        $this->_pagoSinIva = $this->loadModel('pagosiniva');        

        $this->_tarifa = $this->loadModel('tarifa');
        $this->_tipoTarifa = $this->loadModel('tipotarifa');

        $this->_pagoSancion = $this->loadModel('pagosancion');
        $this->_tipoSancion = $this->loadModel('tiposancion');

        $this->_usuario = $this->loadModel('usuario');
        $this->_caja = $this->loadModel('caja');

        $this->_variable = $this->loadModel('variable');
        $this->_configuracion = $this->loadModel('configuracion');

        $this->_tarjetaBathroom = $this->loadModel('tarjetabathroom');
        $this->_pagoBathroom = $this->loadModel('pagobathroom');

        $this->_view->setJs(array('validar'));
    }
    
    public function index() {
        Session::accesoEstricto(array('CAJERO'));
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
    	/*$this->_view->pagos = $this->_pago->dql(
            "SELECT p.fecha, i.numero, sum(p.valor+p.iva) as total FROM Entities\Pago p 
            INNER JOIN Entities\Ingreso i WITH i.id = p.ingreso
            WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin AND p.ingreso is not null
            GROUP BY p.ingreso order by p.fecha desc",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );*/
        $this->_view->pagos = null;
    	$this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Listado';
        $this->_view->renderizar('index', 'pagos');
    }

    public function registrar(){
        Session::accesoEstricto(array('CAJERO'));
    	if($this->getInt('guardar') == 1){
    		$this->_pago->getInstance()->setFecha(new \DateTime());
            $totalPagar = $this->getPostParam('totalPagarNumero');
            $ingreso = $this->_ingreso->get($this->getInt('ingreso'));
            if($ingreso->getCasco() > 0){
                $this->_tipoSancion->get(3);
                $valorAdicional = $this->_tipoSancion->getInstance()->getValor() * $ingreso->getCasco();
                $totalPagar = $totalPagar - $valorAdicional;
              }
            $baseGrabable = round($totalPagar / 1.19);
            $iva = $totalPagar - $baseGrabable;
            $valor = $totalPagar - $iva;
    		$this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
    		$this->_pago->getInstance()->setIngreso($this->_ingreso->get($this->getInt('ingreso')));
    		$this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
    		$this->_pago->getInstance()->setCaja($this->_caja->get(1));
            $this->_variable->get(1);
            $consecutivo = $this->_variable->getInstance()->getValor();
            $this->_pago->getInstance()->setFactura($consecutivo);
    		try {
    			$this->_pago->save();
                if($this->getInt('dia')){
                    $this->_ingreso->get($this->getInt('ingreso'));
                    $this->_ingreso->getInstance()->setDia(1);
                    $this->_ingreso->update();
                }
	    		$this->_pagoServicio->getInstance()->setId($this->_pago->getInstance());
	    		$this->_pagoServicio->getInstance()->setIngreso($this->_ingresoNormal->get($this->getInt('ingreso')));
                        $this->_pagoServicio->getInstance()->setAdicional(0);
	    		$this->_pagoServicio->save();
                if($ingreso->getCasco() > 0){
                    $this->_pago = $this->loadModel('pago');
                    $baseGrabable = round($totalPagar / 1.19);
                    $iva = $totalPagar - $baseGrabable;
                    $valor = $totalPagar - $iva;
                    $this->_pago->getInstance()->setFecha(new \DateTime());
                    $this->_pago->getInstance()->setValor($valor);
                    $this->_pago->getInstance()->setIva($iva);
                    $this->_pago->getInstance()->setEntrego(0);
                    $this->_pago->getInstance()->setCambio(0);
                    $this->_pago->getInstance()->setIngreso($this->_ingreso->getInstance());
                    $this->_pago->getInstance()->setUsuario($this->_usuario->getInstance());
                    $this->_pago->getInstance()->setCaja($this->_caja->get(1));
                    $this->_pago->getInstance()->setFactura($consecutivo);
                    $this->_pago->save();
                    $this->_pagoSancion->getInstance()->setId($this->_pago->getInstance());
                    $this->_pagoSancion->getInstance()->setDocumento(0);
                    $this->_pagoSancion->getInstance()->setFecha(new \DateTime());
                    $this->_pagoSancion->getInstance()->setTipoSancion($this->_tipoSancion->get(3));
                    $this->_pagoSancion->save();
                  }
                $consecutivo = $consecutivo+1;
                $this->_variable->getInstance()->setValor($consecutivo);
                $this->_variable->update();
                $this->generarFactura($ingreso->getNumero(), false);
                Session::set('ticketPrint', $ingreso->getNumero());
				Session::set('mensaje','Registro de Pago Correcto');
    		} catch (Exception $e) {
    			Session::set('error','Error en el Proceso');
    		}
			$this->redireccionar('pago/registrar/');
    	}
    	$this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' :: Registrar';
        $this->_view->renderizar('registro', 'pagos');	
    }

    public function cargarPago(){
        $ticket = $this->getPostParam('ticket');
        $check = $this->getPostParam('check');
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
        if(!$check){
            if($ingresoNormal){
                $fechaEntrada = $ingreso->getFechaIngreso();
                $fechaSalida = new \DateTime();
                $fechaIntervalo = $fechaEntrada->diff($fechaSalida);
                $totalPagar = $this->valorPagar($ingreso, $fechaIntervalo);
            }
            $array['data'] = "ok";
            $array['ticket'] = $ingreso->getNumero();
            $array['ingreso'] = $ingreso->getId();
            $array['dia'] = 0;
            $array['fecha'] = $ingreso->getFechaIngreso()->format("d/m/Y");
            $array['horaIni'] = $fechaEntrada->format("h:i A");
            $array['horaFin'] = $fechaSalida->format("h:i A");
            $array['tiempoTotal'] = $fechaIntervalo->format("%h horas %i minutos");
            $valorAdicional = 0;
            if($ingreso->getCasco() > 0){
              $this->_tipoSancion->get(3);
              $valorAdicional = $this->_tipoSancion->getInstance()->getValor() * $ingreso->getCasco();
            }
            $array['totalPagar'] = $totalPagar + $valorAdicional;
        }else{
            $fechaEntrada = $ingreso->getFechaIngreso();
            $fechaSalida = new \DateTime();
            $fechaIntervalo = $fechaEntrada->diff($fechaSalida);
            $tipoVehiculo = $ingreso->getTipo()->getId();
            $tipoTarifa = 6;
            $tarifa = $this->_tarifa->dql("SELECT t FROM Entities\Tarifa t 
            WHERE t.fechainicio <=:fecha AND t.fechafin >=:fecha 
            AND t.tipovehiculo =:tipoVehiculo AND t.tipotarifa =:tipoTarifa",
            array(
                'fecha' => new \DateTime(), 
                'tipoVehiculo' => $tipoVehiculo,
                'tipoTarifa' => $tipoTarifa));
            $totalPagar = $tarifa[0]->getValor();
            $array['data'] = "ok";
            $array['ticket'] = $ingreso->getNumero();
            $array['ingreso'] = $ingreso->getId();
            $array['dia'] = 1;
            $array['fecha'] = $ingreso->getFechaIngreso()->format("d/m/Y");
            $array['horaIni'] = $fechaEntrada->format("h:i A");
            $array['horaFin'] = $fechaSalida->format("h:i A");
            $array['tiempoTotal'] = $fechaIntervalo->format("%h horas %i minutos");
            $valorAdicional = 0;
            $array['totalPagar'] = $totalPagar;
        }
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
        Session::accesoEstricto(array('CAJERO'));
        $fecha = new \DateTime();
        $this->_view->fecha = $fecha->format('d/m/Y');
        $fecha = $fecha->format('Y-m-d');
        if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            $this->_view->fecha = $fecha->format('d/m/Y');
        }
        $this->_view->pagos = $this->_pago->dql(
            "SELECT p FROM Entities\Pagomensual p WHERE p.fecha =:fecha order by p.fecharegistro desc",
           array('fecha' => $fecha)
        );
        $this->_view->pagoSinIva = $this->_pagoSinIva->dql(
            "SELECT p FROM Entities\Pagosiniva p WHERE p.fecha =:fecha order by p.fecharegistro desc",
           array('fecha' => $fecha)
        );
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Mensual :: Listado';
        $this->_view->renderizar('mensual', 'pagosmensual');
    }

    public function registrarmensual(){
        Session::accesoEstricto(array('CAJERO'));
        if($this->getInt('guardar') == 1){
            $tarjeta = $this->_tarjeta->get($this->getPostParam('tarjeta'));
            if($tarjeta->getCliente()->getTipoCliente()->getId() == 1){
                $this->pagosiniva($this->getPostParam('tarjeta'), $this->getPostParam('totalPagarNumero'));                
            }
            $this->_pago->getInstance()->setFecha(new \DateTime());
            $totalPagar = $this->getPostParam('totalPagarNumero');
            $baseGrabable = round($totalPagar / 1.19);
            $iva = $totalPagar - $baseGrabable;
            $valor = $totalPagar - $iva;
            $this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
            $this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            $this->_pago->getInstance()->setCaja($this->_caja->get(1));
            $this->_variable->get(1);
            $consecutivo = $this->_variable->getInstance()->getValor();
            $this->_pago->getInstance()->setFactura($consecutivo);
            try {
                $this->_pago->save();
                $consecutivo = $consecutivo+1;
                $this->_variable->getInstance()->setValor($consecutivo);
                $this->_variable->update();
                $this->_pagoMensual->getInstance()->setId($this->_pago->getInstance());
                $this->_pagoMensual->getInstance()->setTarjeta($this->_tarjeta->get($this->getPostParam('tarjeta')));
                $this->_pagoMensual->getInstance()->setValor($this->getPostParam('totalPagarNumero'));
                $this->_pagoMensual->getInstance()->setFecha(new \DateTime());
                $this->_pagoMensual->getInstance()->setFechaRegistro(new \DateTime());
                $this->_pagoMensual->save();
                $fechaTarjeta = $this->_tarjeta->getInstance()->getFechaFin();
                $fechaTarjeta = $fechaTarjeta->format('d-m-Y');
                $newDate = date("d-m-Y",strtotime($fechaTarjeta."+ 1 month"));
                $this->_tarjeta->getInstance()->setFechaFin(new \DateTime($newDate));
                $this->_tarjeta->update();
                $this->generarFacturaMensual($this->_pago->getInstance()->getId(), true);
                Session::set('mensaje','Registro de Pago Mensual Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('pago/registrarmensual/');
        }
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Mensual :: Registrar';
        $this->_view->renderizar('registromensual', 'pagosmensual');   
    }

    public function pagosiniva($tarjeta=null, $totalPagar = 0){
        $this->_variable->get(3);
        $consecutivo = $this->_variable->getInstance()->getValor();
        $consecutivo = $consecutivo+1;
        $this->_variable->getInstance()->setValor($consecutivo);
        $this->_variable->update();
        $this->_pagoSinIva->getInstance()->setTarjeta($this->_tarjeta->get($tarjeta));
        $this->_pagoSinIva->getInstance()->setValor($totalPagar);
        $this->_pagoSinIva->getInstance()->setFactura($consecutivo);
        $this->_pagoSinIva->getInstance()->setFecha(new \DateTime());
        $this->_pagoSinIva->getInstance()->setFechaRegistro(new \DateTime());
        $this->_pagoSinIva->save();
        $fechaTarjeta = $this->_tarjeta->getInstance()->getFechaFin();
        $fechaTarjeta = $fechaTarjeta->format('d-m-Y');
        $newDate = date("d-m-Y",strtotime($fechaTarjeta."+ 1 month"));
        $this->_tarjeta->getInstance()->setFechaFin(new \DateTime($newDate));
        $this->_tarjeta->update();
        $this->generarFacturaMensualSinIva($this->_pagoSinIva->getInstance()->getId(), true);
        Session::set('mensaje','Registro de Pago Mensual Correcto');
        $this->redireccionar('pago/registrarmensual/');
    }

    public function cargarPagoMensual(){
        $tarjeta = $this->getPostParam('tarjeta');
        $array = array();
        $tarjeta = $this->_tarjeta->findByObject(array('rfid' => $tarjeta));
        if(!$tarjeta){
            $array['data'] = "error";   
            $array['mensaje'] = "La Tarjeta no Existe";
            echo json_encode($array);
            exit;
        }
        if(!$tarjeta->getTarifa()){
            $tipoCliente = $tarjeta->getCliente()->getTipoCliente()->getId();
            if($tipoCliente == 1){
                $tipoTarifa = 3;
            }elseif($tipoCliente == 2){    
                $tipoTarifa = 5;
            }else{
                $tipoTarifa = 12;
            }
            $tarifa = $this->_tarifa->dql("SELECT t FROM Entities\Tarifa t 
                WHERE t.fechainicio <=:fecha AND t.fechafin >=:fecha 
                AND t.tipovehiculo =:tipoVehiculo AND t.tipotarifa =:tipoTarifa",
                array(
                    'fecha' => new \DateTime(), 
                    'tipoVehiculo' => $tarjeta->getTipoVehiculo()->getId(),
                    'tipoTarifa' => $tipoTarifa));
            $totalPagar = $tarifa[0]->getValor();
        }else{
            $totalPagar = $tarjeta->getTarifa()->getValor();
        }
        $array['data'] = "ok";
        $array['tarjeta'] = $tarjeta->getRfid();
        $array['cliente'] = $tarjeta->getCliente()->getNombre();
        $array['totalPagar'] = $totalPagar;
        echo json_encode($array);
    }

    public function sancion() {
        Session::accesoEstricto(array('CAJERO'));
        $fecha = new \DateTime();
        $this->_view->fecha = $fecha->format('d/m/Y');
        //$fecha = $fecha->format('Y-m-d');
        $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
        $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            $this->_view->fecha = $fecha->format('d/m/Y');
            $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
            $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        }
        $this->_view->pagos = $this->_pago->dql(
            "SELECT p FROM Entities\Pagosancion p JOIN p.tiposancion ts WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin AND ts.otro = 0 order by p.fecha desc",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Sancion :: Listado';
        $this->_view->renderizar('sancion', 'pagossancion');
    }

    public function registrarsancion(){
        Session::accesoEstricto(array('CAJERO'));
        if($this->getInt('guardar') == 1){
            $this->_pago->getInstance()->setFecha(new \DateTime());
            $documento = $this->getPostParam('documento');
            $totalPagar = $this->_tipoSancion->get($this->getTexto('tipoSancion'))->getValor();
            $baseGrabable = round($totalPagar / 1.19);
            $iva = $totalPagar - $baseGrabable;
            $valor = $totalPagar - $iva;
            $this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
            $this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            $this->_pago->getInstance()->setCaja($this->_caja->get(1));
            $this->_variable->get(1);
            $consecutivo = $this->_variable->getInstance()->getValor();
            $this->_pago->getInstance()->setFactura($consecutivo);
            try {
                $this->_pago->save();
                $consecutivo = $consecutivo+1;
                $this->_variable->getInstance()->setValor($consecutivo);
                $this->_variable->update();
                $this->_pagoSancion->getInstance()->setId($this->_pago->getInstance());
                $this->_pagoSancion->getInstance()->setDocumento($documento);
                $this->_pagoSancion->getInstance()->setFecha(new \DateTime());
                $this->_pagoSancion->getInstance()->setTipoSancion($this->_tipoSancion->get($this->getTexto('tipoSancion')));
                $this->_pagoSancion->save();
                $this->generarFacturaSancion($this->_pago->getInstance()->getId(), true);
                Session::set('mensaje','Registro de Pago Sanci&oacute;n Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('pago/registrarsancion/');
        }
        $this->_view->tipoSanciones = $this->_tipoSancion->findBy(array('otro' => 0));
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Sanci&oacute;n :: Registrar';
        $this->_view->renderizar('registrosancion', 'pagossancion');   
    }

    public function cargarPagoSancion(){
        $tipoSancion = $this->getPostParam('tipoSancion');
        $array = array();
        $array['data'] = "ok";
        if($tipoSancion){
            $tipoSancion = $this->_tipoSancion->get($tipoSancion);
            $array['totalPagar'] = $tipoSancion->getValor();
        }else{
            $array['totalPagar'] = "";
        }
        echo json_encode($array);
    }

    public function otro() {
        Session::accesoEstricto(array('CAJERO'));
        $fecha = new \DateTime();
        $this->_view->fecha = $fecha->format('d/m/Y');
        $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
        $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            $this->_view->fecha = $fecha->format('d/m/Y');
            $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
            $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        }
        $this->_view->pagos = $this->_pago->dql(
            "SELECT p FROM Entities\Pagosancion p JOIN p.tiposancion ts WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin AND ts.otro = 1 order by p.fecha desc",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Pagos Otro :: Listado';
        $this->_view->renderizar('otro', 'pagosotro');
    }

    public function registrarotro(){
        Session::accesoEstricto(array('CAJERO'));
        if($this->getInt('guardar') == 1){
            $this->_pago->getInstance()->setFecha(new \DateTime());
            $documento = $this->getTexto('documento');
            $totalPagar = $this->_tipoSancion->get($this->getTexto('tipoSancion'))->getValor();
            $baseGrabable = round($totalPagar / 1.19);
            $iva = $totalPagar - $baseGrabable;
            $valor = $totalPagar - $iva;
            $this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
            $this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            $this->_pago->getInstance()->setCaja($this->_caja->get(1));
            $this->_variable->get(1);
            $consecutivo = $this->_variable->getInstance()->getValor();
            $this->_pago->getInstance()->setFactura($consecutivo);
            try {
                $this->_pago->save();
                $consecutivo = $consecutivo+1;
                $this->_variable->getInstance()->setValor($consecutivo);
                $this->_variable->update();
                $this->_pagoSancion->getInstance()->setId($this->_pago->getInstance());
                $this->_pagoSancion->getInstance()->setDocumento($documento);
                $this->_pagoSancion->getInstance()->setFecha(new \DateTime());
                $this->_pagoSancion->getInstance()->setTipoSancion($this->_tipoSancion->get($this->getTexto('tipoSancion')));
                $this->_pagoSancion->save();
                $this->generarFacturaSancion($this->_pago->getInstance()->getId(), true);
                Session::set('mensaje','Registro de Pago Otro Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('pago/otro/');
        }
        $this->_view->tipoSanciones = $this->_tipoSancion->findBy(array('otro' => 1));
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Sanci&oacute;n :: Registrar';
        $this->_view->renderizar('registrootro', 'pagosotro');   
    }

    public function cargarPagoOtro(){
        $tipoSancion = $this->getPostParam('tipoSancion');
        $array = array();
        $array['data'] = "ok";
        if($tipoSancion){
            $tipoSancion = $this->_tipoSancion->get($tipoSancion);
            $array['totalPagar'] = $tipoSancion->getValor();
        }else{
            $array['totalPagar'] = "";
        }
        echo json_encode($array);
    }

    public function bathroom() {
        Session::accesoEstricto(array('CAJERO'));
        $fecha = new \DateTime();
        $this->_view->fecha = $fecha->format('d/m/Y');
        $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
        $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        if($this->getPostParam('fecha')){
            $fecha = new \DateTime($this->getFecha($this->getTexto('fecha')));
            $this->_view->fecha = $fecha->format('d/m/Y');
            $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
            $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        }
        $this->_view->pagos = $this->_pago->dql(
            "SELECT p FROM Entities\Pagobathroom p WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin order by p.fecha desc",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Servicio Baño :: Listado';
        $this->_view->renderizar('bathroom', 'pagosbathroom');
    }

    public function registrarbathroom(){
        Session::accesoEstricto(array('CAJERO'));
        if($this->getInt('guardar') == 1){
            $this->_pago->getInstance()->setFecha(new \DateTime());
            $totalPagar = $this->getPostParam('totalPagarNumero');
            $baseGrabable = round($totalPagar / 1.19);
            $iva = $totalPagar - $baseGrabable;
            $valor = $totalPagar - $iva;
            $this->_pago->getInstance()->setValor($valor);
            $this->_pago->getInstance()->setIva($iva);
            $this->_pago->getInstance()->setEntrego($this->getPostParam('recibidoNumero'));
            $this->_pago->getInstance()->setCambio($this->getPostParam('devolverNumero'));
            $this->_pago->getInstance()->setUsuario($this->_usuario->get(Session::get('codigo')));
            $this->_pago->getInstance()->setCaja($this->_caja->get(1));
            $this->_variable->get(1);
            $consecutivo = $this->_variable->getInstance()->getValor();
            $this->_pago->getInstance()->setFactura($consecutivo);
            try {
                $this->_pago->save();
                $this->_tarjetaBathroom->get($this->getPostParam('tarjeta'));
                if($this->_tarjetaBathroom->getInstance()){
                    $this->_tarjetaBathroom->getInstance()->setEntradas($this->_tarjetaBathroom->getInstance()->getEntradas() + $this->getInt('entradas'));
                    $this->_tarjetaBathroom->update();
                }else{
                    $this->_tarjetaBathroom = $this->loadModel('tarjetabathroom');
                    $this->_tarjetaBathroom->getInstance()->setRfid($this->getPostParam('tarjeta'));
                    $this->_tarjetaBathroom->getInstance()->setEntradas($this->getInt('entradas'));
                    $this->_tarjetaBathroom->getInstance()->setEstado(1);
                    $this->_tarjetaBathroom->save();
                }
                $consecutivo = $consecutivo+1;
                $this->_variable->getInstance()->setValor($consecutivo);
                $this->_variable->update();
                $this->_pagoBathroom->getInstance()->setId($this->_pago->getInstance());
                $this->_pagoBathroom->getInstance()->setTarjeta($this->_tarjetaBathroom->get($this->getPostParam('tarjeta')));
                $this->_pagoBathroom->getInstance()->setValor($this->getPostParam('totalPagarNumero'));
                $this->_pagoBathroom->getInstance()->setFecha(new \DateTime());
                $this->_pagoBathroom->getInstance()->setFechaRegistro(new \DateTime());
                $this->_pagoBathroom->save();
                //$this->generarFacturaMensual($this->_pago->getInstance()->getId(), true);
                Session::set('mensaje','Registro de Pago Servicio de Baño Correcto');
            } catch (Exception $e) {
                Session::set('error','Error en el Proceso');
            }
            $this->redireccionar('pago/registrarbathroom/');
        }
        $this->_view->titulo = ucwords($this->_presentRequest->getControlador()).' Servicio Baño :: Registrar';
        $this->_view->renderizar('registrobathroom', 'pagosbathroom');   
    }

    public function cargarPagoBathroom(){
        $tarjeta = $this->getPostParam('tarjeta');
        $array = array();
        $tarjeta = $this->_tarjeta->findByObject(array('rfid' => $tarjeta));
        if(!$tarjeta){
            $array['data'] = "error";   
            $array['mensaje'] = "La Tarjeta no Existe";
            echo json_encode($array);
            exit;
        }
        $tipoSancion = 9;
        $array = array();
        $array['data'] = "ok";
        if($tipoSancion){
            $tipoSancion = $this->_tipoSancion->get($tipoSancion);
            $array['totalPagar'] = $tipoSancion->getValor();
        }else{
            $array['totalPagar'] = "";
        }
        $array['tarjeta'] = $tarjeta->getRfid();
        $array['cliente'] = $tarjeta->getCliente()->getNombre();
        echo json_encode($array);
    }

    public function generarFactura($ticket=null, $automatico=false){
        $ingreso = $this->_ingreso->findByObject(array('numero' => $ticket));
        $pago = $this->_pago->findBy(array('ingreso' => $ingreso->getId()));
        $iva = 0;
        $valorTotal = 0;
        $entrego = 0;
        $cambio = 0;
        $subtotal = 0;
        foreach ($pago as $key => $value) {
           $iva = $iva + $value->getIva();
           $valorTotal = $valorTotal + $value->getValor() + $value->getIva();
           $entrego = $entrego + $value->getEntrego();
           $cambio = $cambio + $value->getCambio();
           $subtotal = $subtotal + $value->getValor();
        }
        $casco = 0;
        if($ingreso->getCasco() > 0){
            $casco = $ingreso->getCasco();
        }
        $data = array(
        "ticket" => "".$ticket,
        "fecha" => "".$ingreso->getFecha()->format('d/m/Y'),
        "facturaventa" => "".$pago[0]->getFactura(),
        "fechaingreso" => "".$ingreso->getFechaIngreso()->format('d/m/Y H:i A'),
        //"fechasalida" => "".$ingreso->getFecha()->format('d/m/Y'),
        "fechasalida" => "".$pago[0]->getFecha()->format('d/m/Y H:i A'),
        
        "casco" => "".$casco,
        "iva" => "".$iva,
        "valortotal" => "".$valorTotal,
        "entrego" => "".$entrego,
        "cambio" => "".$cambio,
        "subtotal" => "".$subtotal);
        if($automatico){
            $impresion = $this->_configuracion->get(3);
            $ch = curl_init("http://".$impresion->getValor().":8090/reporte/imprimir/factura_210");
        }else{
	       $ch = curl_init("http://192.168.0.150:8086/pdf/0/factura_210");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($automatico){
            return true;
        }else{
            //header("Location:http://192.168.0.150:8085/files/informes/".$response);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
    }

    public function generarFacturaMensual($pago=null, $automatico=false){
        $pagoMensual = $this->_pagoMensual->findByObject(array('id' => $pago));
        $cliente = $pagoMensual->getTarjeta()->getCliente()->getDocumento();
        $placa = $pagoMensual->getTarjeta()->getCliente()->getObservacion();
        $tipoVehiculo = $pagoMensual->getTarjeta()->getTipoVehiculo()->getDescripcion();
        $pago = $this->_pago->findByObject(array('id' => $pago));
        $data = array(
        "facturaventa" => $pago->getFactura(),
        "fecha" => $pago->getFecha()->format('d/m/Y'),
        "concepto" => "Mensualidad ".$tipoVehiculo,
        "cliente" => $cliente,
        "placa" => $placa,
        "iva" => "".$pago->getIva(),
        "valortotal" => "".($pago->getValor() + $pago->getIva()),
        "entrego" => "".$pago->getEntrego(),
        "cambio" => "".$pago->getCambio(),
        "subtotal" => "".$pago->getValor());
        if($automatico){
            $impresion = $this->_configuracion->get(3);
            $ch = curl_init("http://".$impresion->getValor().":8090/reporte/imprimir/facturao_210");
        }else{
           $ch = curl_init("http://192.168.0.150:8086/pdf/0/facturao_210");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($automatico){
            return true;
        }else{
            //header("Location:http://192.168.0.150:8085/files/informes/".$response);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
    }

    public function generarFacturaMensualSinIva($pago=null, $automatico=false){
        $pagoSinIva = $this->_pagoSinIva->findByObject(array('id' => $pago));
        $cliente = $pagoSinIva->getTarjeta()->getCliente()->getDocumento();
        $placa = $pagoSinIva->getTarjeta()->getCliente()->getObservacion();
        $tipoVehiculo = $pagoSinIva->getTarjeta()->getTipoVehiculo()->getDescripcion();
        $data = array(
        "facturaventa" => $pagoSinIva->getFactura(),
        "fecha" => $pagoSinIva->getFecha()->format('d/m/Y'),
        "concepto" => "Mensualidad ".$tipoVehiculo,
        "cliente" => $cliente,
        "placa" => $placa,
        "iva" => "0",
        "valortotal" => "".($pagoSinIva->getValor()),
        "entrego" => "0",
        "cambio" => "0",
        "subtotal" => "".$pagoSinIva->getValor());
        if($automatico){
            $impresion = $this->_configuracion->get(3);
            $ch = curl_init("http://".$impresion->getValor().":8090/reporte/imprimir/facturao_210");
        }else{
           $ch = curl_init("http://192.168.0.150:8086/pdf/0/facturao_210");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($automatico){
            return true;
        }else{
            //header("Location:http://192.168.0.150:8085/files/informes/".$response);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
    }

    public function generarFacturaSancion($pago=null, $automatico=false){
        $pagoSancion = $this->_pagoSancion->findByObject(array('id' => $pago));
        $cliente = $pagoSancion->getDocumento();
        $tipoSancion = $pagoSancion->getTipoSancion()->getDescripcion();
        $pago = $this->_pago->findByObject(array('id' => $pago));
        $data = array(
        "facturaventa" => "".$pago->getFactura(),
        "fecha" => "".$pago->getFecha()->format('d/m/Y'),
        "concepto" => "".$tipoSancion,
        "cliente" => "".$cliente,
        "iva" => "".$pago->getIva(),
        "valortotal" => "".($pago->getValor() + $pago->getIva()),
        "entrego" => "".$pago->getEntrego(),
        "cambio" => "".$pago->getCambio(),
        "subtotal" => "".$pago->getValor());
        if($automatico){
            $impresion = $this->_configuracion->get(3);
            $ch = curl_init("http://".$impresion->getValor().":8090/reporte/imprimir/facturao_210");
        }else{
           $ch = curl_init("http://192.168.0.150:8086/pdf/0/facturao_210");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($automatico){
            return true;
        }else{
            //header("Location:http://192.168.0.150:8085/files/informes/".$response);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
    }

    public function generarFacturaBathroom($pago=null, $automatico=false){
        $pagoBathroom = $this->_pagoBathroom->findByObject(array('id' => $pago));
        $cliente = $pagoSancion->getDocumento();
        $tipoSancion = $pagoSancion->getTipoSancion()->getDescripcion();
        $pago = $this->_pago->findByObject(array('id' => $pago));
        $data = array(
        "facturaventa" => "".$pago->getFactura(),
        "fecha" => "".$pago->getFecha()->format('d/m/Y'),
        "concepto" => "".$tipoSancion,
        "cliente" => "".$cliente,
        "iva" => "".$pago->getIva(),
        "valortotal" => "".($pago->getValor() + $pago->getIva()),
        "entrego" => "".$pago->getEntrego(),
        "cambio" => "".$pago->getCambio(),
        "subtotal" => "".$pago->getValor());
        if($automatico){
            $impresion = $this->_configuracion->get(3);
            $ch = curl_init("http://".$impresion->getValor().":8090/reporte/imprimir/facturao_210");
        }else{
           $ch = curl_init("http://192.168.0.150:8086/pdf/0/facturao_210");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($automatico){
            return true;
        }else{
            //header("Location:http://192.168.0.150:8085/files/informes/".$response);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
    }

    public function reporteDiario(){
        $fecha = new \DateTime();
        $fechaReporte = $fecha->format('Y-m-d');
        $data = array(
        "FECHA" => $fechaReporte);
        $ch = curl_init("http://192.168.0.150:8086/pdf/1/reporteInformacionDiaria");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Location:http://192.168.0.150:8085/files/informes/".$response);
        header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
    }

    public function reporteDia(){
        $data = array(
        "usuario" => Session::get('usuario'));
        $ch = curl_init("http://192.168.0.150:8086/pdf/1/cierrecaja_210");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Location:http://192.168.0.150:8085/files/informes/".$response);
        header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
    }

}

?>