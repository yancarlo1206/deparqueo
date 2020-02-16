<?php

abstract class Controller {

  protected $_view;
  protected $_presentRequest;

  public function __construct() {
    $request = new Request;
    $this->_presentRequest = $request;
    $this->_view = new View($request);
    $this->_view->_presentRequest = $request;
  }

  abstract public function index();

  protected function loadModel($modelo) {
    $modelo = strtolower($modelo) . 'Model';
    $rutaModelo = MODELS_PATH . $modelo . '.php';
    if (is_readable($rutaModelo)) {
      require_once $rutaModelo;
      $modelo = new $modelo;
      return $modelo;
    } else {            
      header("Location: ". BASE_URL);
    }
  }

  protected function getLibrary($libreria) {
    $rutaLibreria = LIBS_PATH. $libreria . '.php';
    echo $rutaLibreria;
    if(is_readable($rutaLibreria)){
      require_once $rutaLibreria;
    }
    else{
      throw new Exception('Error de libreria');
    }
  }

  protected function getTexto($clave) {
    if(isset($_POST[$clave]) && !empty($_POST[$clave])){
      $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
      return $_POST[$clave];
    }
    return '';
  }

  public function getFecha($fecha){
    if($fecha != ""){
      $split = explode("/", $fecha);
      return $fecha = $split[1] . "/" . $split[0] . "/" . $split[2];
    }
    else
      return null;
  }

  public function filtrarFecha($clave) {
    if(isset($clave) && !empty($clave)){
      $hora='';
      $a='';
      $fecha = $clave;
      @list($fecha,$hora,$a) = explode(' ', $fecha);

      list($dia,$mes,$ano) = explode('-', $fecha);
      if($dia=='' or $mes=='' or $ano==''){
        list($ano,$mes,$dia) = explode('-', $fecha);
      }
      $fecha =  $ano.'-'.$mes.'-'.$dia.' '.$hora.' '.$a;
      return date("Y-m-d H:i:s",strtotime($fecha));
    }
    else
      return null;
  }

  public function getFechaLetras($value='') {   
    if($value==''){
      return '';
    }else{
      include_once ROOT.'libs'.DS."lib_fecha_letras.php";
      return FechaLetra::fechaALetras($value);
    }
  }

  private function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
      $data .= substr('====', $mod4);
    }
    return base64_decode($data);
  }

  protected function decodeApp($value) {
    if(!$value){return false;}
    $crypttext = $this->safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, HASH_KEY, $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
  }


  protected function getInt($clave) {
    if(isset($_POST[$clave]) && !empty($_POST[$clave])){
      $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
      return $_POST[$clave];
    }
    return 0;
  }

  protected function getFloat($clave) {
    if(isset($_POST[$clave]) && !empty($_POST[$clave])){
      $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_FLOAT);
      return $_POST[$clave];
    }
    return 0;
  }

  protected function redireccionar($ruta = false) {
    if($ruta){
      header('location:' . BASE_URL . $ruta);
      exit;
    }
    else{
      header('location:' . BASE_URL);
      exit;
    }
  }

  protected function validarArrays($text=false,$int=false,$float=false) {
    if($text && is_array($text)){
      $rta = $this->validarArrayText($text);
      if($rta != ''){ return $rta; }
    }
    if($int && is_array($int)){
      $rta = $this->validarArrayInt($int);
      if($rta != ''){ return $rta; }
    }
    if($float && is_array($float)){
      $rta = $this->validarArrayFloat($float);
      if($rta != ''){ return $rta; }
    }
    return '';
  }

  protected function validarArrayInt($array=false) {
    if($array && is_array($array)){
      foreach ($array  as  $required) {
        if($this->getInt($required)<1){
          return $required;
        }
      }
      return '';
    }else{
      return 'error';
    }
  }

  protected function validarArrayText($array=false) {
    if($array && is_array($array)){
      foreach ($array  as  $required) {
        if(!$this->getTexto($required)){
          return $required;
        }
      }
      return '';
    }else{
      return 'error';
    }
  }

  protected function validarArrayFloat($array=false) {
    if($array && is_array($array)){
      foreach ($array  as  $required) {
        if($this->getFloat($required)<1){
          return $required;
        }
      }
      return '';
    }else{
      return 'error';
    }
  }

  protected function filtrarInt($int) {
    $int = (int) $int;
    if(is_int($int)){
      return $int;
    }else{
      return 0;
    }
  }

  protected function filtrarTexto($clave) {
    if(isset($clave) && !empty($clave)){
      $clave = (string) $clave;
      $clave = htmlspecialchars($clave, ENT_QUOTES);
      return $clave;
    }
    return '';
  }

  protected function getPostParam($clave) {
    if(isset($_POST[$clave])){
      return $_POST[$clave];
    }
  }

  protected function getSql($clave) {
    if(isset($_POST[$clave]) && !empty($_POST[$clave])){
      $_POST[$clave] = strip_tags($_POST[$clave]);
      if(!get_magic_quotes_gpc()){
        //$_POST[$clave] = @mysql_escape_string($_POST[$clave]);
        $_POST[$clave] = $_POST[$clave];
      }
      return trim($_POST[$clave]);
    }
  }

  protected function getAlphaNum($clave) {
    if(isset($_POST[$clave]) && !empty($_POST[$clave])){
      $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]);
      return trim($_POST[$clave]);
    }
  }

  public function validarEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      return false;
    }
    return true;
  }

  public function curl( $url, $data ){
    $request_data = http_build_query($data);
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, $request_data);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($c);
    if( $result === FALSE ){
      return curl_error($c);
      exit;
    }
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);
    return $result;
  }


  public function templateMail($text){
    $rta='';
    $rta.='<div style="width: 500px; margin: 0 auto;background-color: #fff;border: 1px solid #428bca;border-radius: 4px;-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);overflow: hidden;box-shadow: 0 1px 1px rgba(0,0,0,.05);font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;">';
    $rta.='<div style="border-bottom: 1px solid #ccc;margin: 0px;padding: 10px;text-align: center;background-color: #fff;color: #333;background-color: #007EB8;border-color: #e7e7e7;"><img style="height: 50px;max-height: 50px;" height="50" src="'.BASE_URL.'public/img/logo.png" alt="Logo"></div>';
    $rta.='<div style="min-height: 150px;">';
    $rta.='<p style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;padding: 20px 15px;margin: 0;text-align: justify;">';

    $rta.= $text;

    $rta.='</p>';
    $rta.='</div>';
    $rta.='<div style="text-align: center;padding: 10px 15px;background-color: #f5f5f5;border-top: 1px solid #ddd;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px;">';
    $rta.='<a style="text-decoration: none;color: #428bca;font-weight: 700;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;" href="'.BASE_URL.'">'.APP_NAME.'</a>';
    $rta.='</div>';
    $rta.='</div>';

    return $rta;
  }

  public function sendMail($de,$deNombre,$para,$paraNombre,$msj,$asunto="",$archvio=false) {
    $this->getLibrary('class.phpmailer');
    $mail = new PHPMailer();
    $mail->CharSet = "UTF­8";
    /*$mail->Encoding = "quoted­printable";*/
    $mail->isHTML(true);
    $mail->SetFrom($de, $deNombre);
    $mail->AddAddress($para, $paraNombre);
    $mail->Subject = $asunto;
    $mail->MsgHTML($this->templateMail($msj)); 
    if($archvio){
      $varname = $archvio['name'];
      $vartemp = $archvio['tmp_name'];
      $mail->AddAttachment($vartemp, $varname);
    }
    if(!@$mail->Send()) {
     return false;
   }else{
     return true;
   }

  }

  function numberPad($number,$n = 6,$s = "0") {
    return str_pad((int) $number,$n,$s,STR_PAD_LEFT);
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

  function create_url_slug($string=''){
    $string = strtolower($string);
    $slug=preg_replace('/[^A-Za-z0-9-]+/', '_', $string);
    return $slug;
  }

public function calcularEdad($fecha='') {
  $fecha_de_nacimiento = date("Y-m-d",strtotime($fecha)); 
  $fecha_actual = date("Y-m-d"); 
  $form1 = explode ( "-", $fecha_de_nacimiento ); 
  $form2 = explode ( "-", $fecha_actual ); 
  $anos = $form2[0] - $form1[0];
  $meses = $form2[1] - $form1[1];
  if ($meses > 0){
    return ($anos . " años y " . $meses . " mes(es)");
  }else{
    if ($meses < 0){
      return (($anos-1) . " años y " . ((12-$form1[1])+$form2[1]) . " mes(es)");
    }else{
      return ($anos . " años");
    }
  }
}

public function randomText($length) {
  $key='';
  $pattern = "abcdefghijklmnopqrstuvwxyz1234567890";
  for($i=0;$i<$length;$i++) {
    $key.= $pattern[rand(0,35)];
  }
  return $key;
}

function arrayVacuum($array='') {
  if (!is_array($array)) {
    return $array;
  }
  $newArray = array();
  foreach ($array as $key => $value) {
    if($value) {
      $newArray[$key] = $this->arrayVacuum($value);
    }
  }
  return $newArray;
}

  public function subirImg($configSubir,$configRender,$img){
    $this->getLibrary('img/Upload');
    $upload = new Upload($configSubir);
    if (!$upload->do_upload($img)){
      return $upload->error;
    }else{
      foreach ($upload->data() as $item => $value){
        if($item =='file_path'){                  
          $path = $value; 
        }elseif($item =='file_name'){              
          $name = $value;
        }elseif($item =='image_width'){
          $width = $value;                     
        }elseif(($item =='image_height')){                      
          $height = $value;
        }
      }
      $this->resizeImg($path,$name,$configRender);
    } 
  }

  public function resizeImg($path,$name,$configRender){   
    $upload = explode('/',$path); 
    $size = sizeof($upload); 
    $final_folder = '';
    for($i=0; $i<($size-2); $i++){ 
      $final_folder .= $upload[$i].DS;
    }
    $configRender['source_image']=$path.$name;
    $this->getLibrary('img/Image_lib');
    $imagen = new Image_lib($configRender);
    if (!$imagen->resize()){
      echo $imagen->display_errors();
    }
    $imagen->resize();
    unlink($path.$name);
  }

  public function correo($destino=null, $texto=null){
    $this->getLibrary("mail" . DS . "class.phpmailer");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = false;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "SMTP.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "codeteinpbx@gmail.com";
    $mail->Password = "C0d3t31n-0nt1m3";
    $mail->SetFrom('Codetein', 'Cucuta');
    $mail->From = "Ontime";
    $mail->FromName = "Ontime";
    $mail->Subject = "Recordatorio - Ontime";
    $mail->MsgHTML($texto);
    $mail->AddAddress($destino);
    if ($mail->Send()) {
        return true;
    } else {
        return false;
    }
  }

  public function mensajeTexto($numero=null, $sms=null){
      $url = 'https://api.hablame.co/sms/envio/';
      $data = array(
        'cliente' => 10010722, //Numero de cliente
        'api' => 'BTlsFz9gwVI7h6UQax1ciGcupytLkt', //Clave API suministrada
        'numero' => $numero, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
        'sms' => $sms, //Mensaje de texto a enviar
        'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
        'referencia' => 'Referenca Envio Hablame', //(campo opcional) Numero de referencio ó nombre de campaña
      );
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'method'  => 'POST',
              'content' => http_build_query($data)
          )
      );
      $context  = stream_context_create($options);
      $result = json_decode((file_get_contents($url, false, $context)), true);
      if($result["resultado"]===0){
        return true;
      }else{
        return false;
      }
    }

}

?>