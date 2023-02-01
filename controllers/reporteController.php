<?php

class reporteController extends Controller {   
    public function __construct() {
        parent::__construct();
        $this->_pago = $this->loadModel('pago');
    }

    public function index() {
        if($this->getInt('guardar')){
            $fechaIni = new \DateTime($this->getFecha($this->getTexto('fechaIni')));
            $fechaIni = $fechaIni->format('Y-m-d');
            $fechaFin = new \DateTime($this->getFecha($this->getTexto('fechaFin')));
            $fechaFin = $fechaFin->format('Y-m-d');
            $data = array(
                "FECHAINI" => $fechaIni,
                "FECHAFIN" => $fechaFin,
                "FECHA" => $fechaIni
            );
	        if($this->getInt('reporte') == 1){
                $reporte = 'reporteInformacionDiaria';
            }elseif($this->getInt('reporte') == 2){
                $reporte = 'reporteInformacionCortesia';
            }elseif($this->getInt('reporte') == 3){
                $reporte = 'reporteInformacionTarjetas';
            }elseif($this->getInt('reporte') == 4){
                $reporte = 'reportePagoMensualidad';
            }elseif($this->getInt('reporte') == 5){
                $reporte = 'reporteFechaCorteTarjeta';
            }elseif($this->getInt('reporte') == 10){
                $this->archivoCsv($fechaIni, $fechaFin);
            }

            $ch = curl_init("http://192.168.0.150:8086/pdf/1/".$reporte);
            //$ch = curl_init("http://".$_SERVER['HTTP_HOST'].":8086/pdf/1/".$reporte);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
            $response = curl_exec($ch);
            var_dump(curl_error($ch));
            var_dump(curl_errno($ch));
            curl_close($ch);
            header("Location:http://".$_SERVER['HTTP_HOST'].":8085/files/informes/".$response);
        }
        $this->_view->fecha = (new \DateTime())->format('d/m/Y');
        $this->_view->titulo = "Reportes";
        $this->_view->renderizar('obj', 'reporte');
    }

    public function archivoCsv($fechaIni, $fechaFin){
        $sql = "SELECT CONCAT('415505.07,D,',pago.valor,',',cliente.nombre,'/',cliente.documento,',',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagomensual ON pago.id = pagomensual.id 
        INNER JOIN tarjeta ON tarjeta.rfid = pagomensual.tarjeta
        INNER JOIN cliente ON tarjeta.cliente = cliente.id
        WHERE pago.fecha BETWEEN '".$fechaIni."' AND '".$fechaFin."'
        UNION ALL
        SELECT CONCAT('240801.03,D,',pago.iva,',',cliente.nombre,'/',cliente.documento,',',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagomensual ON pago.id = pagomensual.id 
        INNER JOIN tarjeta ON tarjeta.rfid = pagomensual.tarjeta
        INNER JOIN cliente ON tarjeta.cliente = cliente.id
        WHERE pago.fecha BETWEEN '".$fechaIni."' AND '".$fechaFin."'
        UNION ALL
        SELECT CONCAT('415505.08,D,',pago.valor,',No registra/22222222,',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagoservicio ON pago.id = pagoservicio.id 
        WHERE pago.fecha BETWEEN '".$fechaIni."' AND '".$fechaFin."'
        UNION ALL
        SELECT CONCAT('240801.03,D,',pago.iva,',No registra/22222222,',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagoservicio ON pago.id = pagoservicio.id 
        WHERE pago.fecha BETWEEN '".$fechaIni."' AND '".$fechaFin."'
        UNION ALL
        SELECT CONCAT('42959501.10,D,',pago.valor,',',coalesce(cliente.nombre,'No registra'),'/',coalesce(cliente.documento,'22222222'),',',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagosancion ON pago.id = pagosancion.id 
        LEFT OUTER JOIN tarjeta ON tarjeta.rfid = pagosancion.documento
        LEFT OUTER JOIN cliente ON tarjeta.cliente = cliente.id
        UNION ALL
        SELECT CONCAT('240801.03,D,',pago.iva,',',coalesce(cliente.nombre,'No registra'),'/',coalesce(cliente.documento,'22222222'),',',pago.factura,',02') AS datos
        FROM pago INNER JOIN pagosancion ON pago.id = pagosancion.id 
        LEFT OUTER JOIN tarjeta ON tarjeta.rfid = pagosancion.documento
        LEFT OUTER JOIN cliente ON tarjeta.cliente = cliente.id";
        $resultado = $this->_pago->nativeQuery($sql);
        $filename = "facturacion_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');
        foreach ($resultado as $key => $value) {
            fputcsv($f, $value);
        }
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
        exit;
    }
    
}

?>