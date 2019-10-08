<?php

class reporteController extends Controller {   
    public function __construct() {
        parent::__construct();
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
            }else{
              $reporte = 'reporteInformacionCortesia';
            }
            $ch = curl_init("http://192.168.0.150:8086/pdf/1/".$reporte);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RpZ28iOiIwMDIwMyIsInRpcG8iOiJkb2NlbnRlIn0.oOf_khS-4ZBzyGomdKd2_QswKCS-w2aJNir4CGV5-iM'));
            $response = curl_exec($ch);
            var_dump(curl_error($ch));
            var_dump(curl_errno($ch));
            curl_close($ch);
            header("Location:http://192.168.0.150:8085/files/informes/".$response);
        }
        $this->_view->titulo = "Reportes";
        $this->_view->renderizar('obj', 'reporte');
    }
    
}

?>