<?php

class indexController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_usuario = $this->loadModel('usuario');
        $this->_tarjeta = $this->loadModel("tarjeta");
        $this->_ingreso = $this->loadModel("ingreso");
        $this->_pago = $this->loadModel("pago");
    }
    
    public function index() {
        $this->_view->titulo = '';
        if(Session::get('autenticado')){
            $this->_view->titulo = "Bienvenido";
            if(Session::get('level') == 'PORTERO'){
                $this->redireccionar('ingreso');
            }else if(Session::get('level') == 'CAJERO'){
                $this->redireccionar('pago');
            }else{
                $this->cargarDatos();
                $this->_view->renderizar('index', 'inicio');
            }
        }else{
            $this->_view->titulo = "Inicio de Sesi&oacute;n";
            $this->_view->renderizar('indexLogin', 'inicio');
        }
         //$this->_view->renderizar('index', 'inicio');
    }

    public function cargarDatos(){
        $fecha = new \DateTime();
        $this->_view->tarjetasPropietarios = $this->_tarjeta->dql("SELECT t FROM Entities\Tarjeta t JOIN t.cliente c 
            JOIN c.tipocliente tc WHERE tc.id =:cliente AND t.estado = 1", array("cliente" => 1));
        $this->_view->tarjetasParticulares = $this->_tarjeta->dql("SELECT t FROM Entities\Tarjeta t JOIN t.cliente c 
            JOIN c.tipocliente tc WHERE tc.id =:cliente AND t.estado = 1", array("cliente" => 2));
        $this->_view->tarjetasParqueadero = $this->_ingreso->dql("SELECT i FROM Entities\Ingreso i INNER JOIN Entities\Ingresotarjeta it WITH i.id = it.id WHERE i.fecha =:fecha", 
            array("fecha" => $fecha->format('Y-m-d')));
        $this->_view->ticketActivos = $this->_ingreso->dql("SELECT i FROM Entities\Ingreso i INNER JOIN Entities\IngresoNormal ino WITH i.id = ino.id WHERE i.fecha =:fecha and i.fechasalida is null", 
            array("fecha" => $fecha->format('Y-m-d')));
        $this->_view->ticketSalidas = $this->_ingreso->dql("SELECT i FROM Entities\Ingreso i INNER JOIN Entities\IngresoNormal ino WITH i.id = ino.id WHERE i.fecha =:fecha and i.fechasalida is not null", 
            array("fecha" => $fecha->format('Y-m-d')));
        $fechaIni = $fecha->format('Y-m-d')." 00:00:00";
        $fechaFin = $fecha->format('Y-m-d')." 23:59:59";
        $this->_view->recaudoTicket = $this->_pago->dql(
            "SELECT sum(p.valor+p.iva) as total FROM Entities\Pago p INNER JOIN Entities\Pagoservicio ps 
            WITH ps.ingreso = p.ingreso WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin
            GROUP BY p.ingreso",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
        $this->_view->recaudoMensualidad = $this->_pago->dql(
            "SELECT sum(p.valor+p.iva) as total FROM Entities\Pago p INNER JOIN Entities\Pagomensual pm 
            WITH pm.id = p.id WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin
            GROUP BY p.id",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
        $this->_view->recaudoSancion = $this->_pago->dql(
            "SELECT sum(p.valor+p.iva) as total FROM Entities\Pago p INNER JOIN Entities\Pagosancion ps 
            WITH ps.id = p.id WHERE p.fecha >=:fechaIni AND p.fecha <=:fechaFin
            GROUP BY p.id",
           array('fechaIni' => $fechaIni, 'fechaFin' => $fechaFin)
        );
    }


}

?>