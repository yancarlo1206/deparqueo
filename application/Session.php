<?php

class Session
{
    public static function init() {
        $session_path = TEMP_PATH;
        $session_path.="sess".DS;
        if(!file_exists($session_path)){
            mkdir($session_path, 0700, true);
        }
        session_save_path($session_path);
        session_start();
    }
    
    public static function destroy($clave = false) {
        if($clave){
            if(is_array($clave)){
                for($i = 0; $i < count($clave); $i++){
                    if(isset($_SESSION[$clave[$i]])){
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            }
            else{
                if(isset($_SESSION[$clave])){
                    unset($_SESSION[$clave]);
                }
            }
        }
        else{
            @session_destroy();
        }
    }
    
    public static function set($clave, $valor) {
        if(!empty($clave))
        $_SESSION[$clave] = $valor;
    }
    
    public static function get($clave) {   
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
        else
            return false;
    }
    
    public static function acceso($level) {
        if(!Session::get('autenticado')){
            if(Session::get('error') != ''){
                header('location:' . BASE_URL);
            }else{
                header('location:' . BASE_URL . 'error/access/5050/');
            }
            exit;
        }
        Session::tiempo();
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }
    
    public static function accesoView($level) {
        if(!Session::get('autenticado')){
            return false;
        }
        if(Session::getLevel($level) != Session::getLevel(Session::get('level'))){
            return false;
        }
        return true;
    }
    
    public static function getLevel($level) {
        $role['ADMINISTRADOR'] = 4;
        $role['AUXILIAR'] = 3;
        $role['CAJERO'] = 2;
        $role['PORTERO'] = 1;
        if(!array_key_exists($level, $role)){
            throw new Exception('Error de acceso');
        }
        else{
            return $role[$level];
        }
    }
    
    public static function accesoEstricto(array $level, $noAdmin = false) {
        if(!Session::get('autenticado')){
            if(Session::get('error') != ''){
                header('location:' . BASE_URL);
            }else{
                header('location:' . BASE_URL . 'error/access/5050/');
            }
            exit;
        }
        Session::tiempo();
        if($noAdmin == false){
            if(Session::get('level') == 'admin'){
                return;
            }
        }
        if(count($level)){
            if(in_array(Session::get('level'), $level)){
                return;
            }
        }
        if(Session::get('error') != ''){
            header('location:' . BASE_URL);
        }else{
            header('location:' . BASE_URL . 'error/access/5050/');
        }
        
    }
    
    public static function accesoViewEstricto(array $level, $noAdmin = false) {
        if(!Session::get('autenticado')){
            return false;
        }
        if($noAdmin == false){
            if(Session::get('level') == 'admin'){
                return true;
            }
        }
        if(count($level)){
            if(in_array(Session::get('level'), $level)){
                return true;
            }
        }
        return false;
    }

    public static function numtempkeys($cadena) {
        if(!Session::get('rnd')){Session::set('rnd',rand(1,99));}
        $cadenaTemp = $cadena;
        $aVocales = array( "a","e","i","o","u","6","3", "1", "2","4","5","6","7","8","9","0","g","c","t","w","l","j","m","n","s" );
        foreach($aVocales as $vocal) { 
            $cadena = str_replace( $vocal,"",$cadena );
        } 
        $numtempkey = strlen( $cadenaTemp ) - strlen( $cadena ) + (int)Session::get('rnd') ;
        return $numtempkey ;
    }

    public static function tiempo() {   
        if(!Session::get('tiempo') || !defined('SESSION_TIME')){
            throw new Exception('No se ha definido el tiempo de sesion'); 
        }
        if(SESSION_TIME == 0){
            return;
        }
        if(time() - Session::get('tiempo') > (SESSION_TIME * 60)){
            Session::destroy();
            Session::init();
            Session::set('error','Tiempo de la sesion agotado.');
            header('location:' . BASE_URL);
        }
        else{
            Session::set('tiempo', time());
        }
    }

    public static function isLogin($id) {
        $session_path=TEMP_PATH;
        $session_path.="sess".DS;
        if(!file_exists($session_path)){
            mkdir($session_path, 0700, true);
        }
        Session::removeSession();
        $d = opendir($session_path);
        while (false !== ($f = readdir($d))){
            if ($f != "." && $f != "..") {
                $ruta=$session_path.$f;
                $file=@fopen($ruta, "r");
                $string=fgets($file,4096);
                fclose($file);
                $esta = strripos($string, $id);
                if($esta){
                    //unlink($ruta);
                    $file = fopen($ruta, "w");
                    fwrite($file, 'error|s:79:"Su sesión fue cerrada por otro usuario que inicio con su codigo y contraseña.";' . PHP_EOL);
                    fclose($file);
                    return true;
                }
            }
        }
        return false;
    }

    public static function removeSession(){
        $session_path=TEMP_PATH;
        $session_path.="sess".DS;
        $fecha = strtotime('-1 day',time());
        $d = opendir($session_path);
        while (false !== ($f = readdir($d))){
            if ($f != "." && $f != "..") {
                $ruta=$session_path.$f;
                $fArchivo = filectime($ruta);
                if($fArchivo<$fecha){
                    unlink($ruta);
                }
            }
        }
    }

}

?>