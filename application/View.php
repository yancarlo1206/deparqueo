<?php

class View {

    private $_controlador;
    private $_js;
    private $_css;
    private $_url;
    public  $tipo = false;
    public  $tiempo = true;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_url = $peticion->getUrl();
        $this->_js = array();
        $this->_css = array();
    }
    
    public function renderizar($vista, $item = false, $subItem = false) {
        $menu = array();
        $menuConfiguracion = array();
        if(Session::accesoView('PORTERO')){
            $menu[] = array(
                    'id' => 'ingreso',
                    'titulo' => 'Ingreso',
                    'icono' => 'fa-check-double',
                    'enlace' => BASE_URL . 'ingreso/'
                    );
            $menu[] = array(
                    'id' => 'salida',
                    'titulo' => 'Salida',
                    'icono' => 'fa-check-double',
                    'enlace' => BASE_URL . 'salida/'
                    );
        }
        if(Session::accesoView('AUXILIAR')){
             $menu[] = array(
                    'id' => 'ticket',
                    'titulo' => 'Tickets',
                    'icono' => 'fa fa-ticket-alt',
                    'enlace' => BASE_URL . 'ticket/'
                    );
            $menu[] = array(
                    'id' => 'cliente',
                    'titulo' => 'Clientes',
                    'icono' => 'fa fa-user-friends',
                    'enlace' => BASE_URL . 'cliente/'
                    );
            $menu[] = array(
                    'id' => 'tarjeta',
                    'titulo' => 'Tarjetas',
                    'icono' => 'fas fa-address-card',
                    'enlace' => BASE_URL . 'tarjeta/'
                    );
             $menu[] = array(
                    'id' => 'tarifa',
                    'titulo' => 'Tarifas',
                    'icono' => 'fas fa-comment-dollar',
                    'enlace' => BASE_URL . 'tarifa/'
                    );
        }
        if(Session::accesoView('CAJERO')){
            $menu[] = array(
                    'id' => 'pagos',
                    'titulo' => 'Pagos',
                    'icono' => 'fa-money-bill-alt',
                    'enlace' => BASE_URL . 'pago/'
                    );
            $menu[] = array(
                    'id' => 'pagosmensual',
                    'titulo' => 'Pagos Mensual',
                    'icono' => 'fa-money-bill-alt',
                    'enlace' => BASE_URL . 'pago/mensual/'
                    );
            $menu[] = array(
                    'id' => 'pagossancion',
                    'titulo' => 'Pagos Sancion',
                    'icono' => 'fa-money-bill-alt',
                    'enlace' => BASE_URL . 'pago/sancion/'
                    );
        }
        if(Session::accesoView('ADMINISTRADOR')){
            $menu[] = array(
                    'id' => 'usuario',
                    'titulo' => 'Usuarios',
                    'icono' => 'fas fa-users',
                    'enlace' => BASE_URL . 'usuario/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'tipovehiculo',
                    'titulo' => 'Tipo Vehiculos',
                    'icono' => 'fas fa-truck-pickup',
                    'enlace' => BASE_URL . 'tipovehiculo/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'tipotarifa',
                    'titulo' => 'Tipo Tarifas',
                    'icono' => 'fas fa-comments-dollar',
                    'enlace' => BASE_URL . 'tipotarifa/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'tipocliente',
                    'titulo' => 'Tipo Clientes',
                    'icono' => 'fas fa-id-card-alt',
                    'enlace' => BASE_URL . 'tipocliente/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'tiposancion',
                    'titulo' => 'Tipo Sanci&oacute;n',
                    'icono' => 'fas fa-bullhorn',
                    'enlace' => BASE_URL . 'tiposancion/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'caja',
                    'titulo' => 'Cajas',
                    'icono' => 'fas fa-cash-register',
                    'enlace' => BASE_URL . 'caja/'
                    );
            $menuConfiguracion[] = array(
                    'id' => 'rol',
                    'titulo' => 'Roles',
                    'icono' => 'fas fa-user-shield',
                    'enlace' => BASE_URL . 'rol/'
                    );
        }
        $js = array();
        if(count($this->_js)){$js = $this->_js;}
        $css = array();
        if(count($this->_css)){$css = $this->_css;}
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_fonts' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/fonts/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu,
            'menuConfiguracion' => $menuConfiguracion,
            'js' => $js,
            'css' => $css,
            'item' => $item,
            'subItem' => $subItem,
            'vista' => $vista
        );
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        if(is_readable($rutaView)){
            if($vista != 'indexLogin'){
            	include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            }
            include_once $rutaView;
            if($vista != 'indexLogin'){
            	include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
            }
        } 
        else {
            throw new Exception('Error de vista');
        }
    }
    
    public function setJs(array $js) {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }
    
    public function setJsP(array $js) {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }

    }

    public function setJsL(array $js) {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }

    public function setJsE($js) {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] =  $js[$i];
            }
        } else {
            echo file_get_contents(BASE_URL.TEM_T.'error/access/8345/');
            exit;
            header("Location: ". BASE_URL.TEM_T.'error/access/8345/');
        }
    }

    private  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function encodeApp($value){
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, HASH_KEY, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
    public function setCssL(array $css) {
        if(is_array($css) && count($css)){
            for($i=0; $i < count($css); $i++){
                $this->_css[] = BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/' . $css[$i] . '.css';
            }
        } else {
            throw new Exception('Error de css');
        }
    }

    public function setCss(array $css) {
        if(is_array($css) && count($css)){
            for($i=0; $i < count($css); $i++){
                $this->_css[] = BASE_URL . 'views/' . $this->_controlador . '/css/' . $css[$i] . '.css';
            }
        } else {
            throw new Exception('Error de css');
        }
    }

    public function setCssP(array $css) {
        if(is_array($css) && count($css)){
            for($i=0; $i < count($css); $i++){
                $this->_css[] = BASE_URL . 'public/css/' . $css[$i] . '.css';
            }
        } else {
            throw new Exception('Error de css');
        }

    }

    public function includeview($view='') {
        if($view!=''){
            $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $view . '.phtml';
            if(is_readable($rutaView)){
                include_once($rutaView);
            }
        }
    }

    public function fechaLetras($value='') {   
        if($value==''){
            return '';
        }else{
            include_once ROOT.'libs'.DS."lib_fecha_letras.php";

            return FechaLetra::fechaALetras($value);
        }
    }

   public function getFechaFormateada($FechaStamp,$hora=false) { 
      if($hora){
        $hora = ', '.date('h:i A',strtotime($FechaStamp));
      }else{
        $hora = '';
      }
      $ano = date('Y',strtotime($FechaStamp));
      $mes = date('n',strtotime($FechaStamp));
      $dia = date('d',strtotime($FechaStamp));
      $diasemana = date('w',strtotime($FechaStamp));
      $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
                          "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                     "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." del $ano".$hora;
    }

    public function getFechaLetras($value='') {   
        if($value==''){
            return '';
        }else{
            include_once ROOT.'libs'.DS."lib_fecha_letras.php";

            return FechaLetra::fechaALetras($value);
        }
    }

    public function getFormatoMoneda($value='',$s='') {
        if($value==''){
            $value = 0;
        }
        return $s.number_format($value, 2, ".", ",");
    }

    public function calculaedad($fechanacimiento){
        list($ano,$mes,$dia) = explode("-",$fechanacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

    public function combobox($name, $default, $objeto, $selected, $value, $texto, $otros,$title) {
        $select = "<select name =" . $name . " " . $otros . " >";
        if ($default != "")
            $select .= "<option value =''>" . $default . "</option>";
        $options = "";
        foreach ($objeto as $obj) {
            $options .= "<option title='" . $obj->$title() . "' value = '" . $obj->$value() . "'";
            if ($obj->$value() == $selected)
                $options .= "selected>". $obj->$texto() . "</option>";
            else
                $options .= ">" . $obj->$texto() . "</option>";
        }
        $select = $select . $options . "</select>";
        return $select;
    }
}

?>