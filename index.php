<?php 

ini_set('display_errors', 1); 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);
define('MODELS_PATH', ROOT . 'models' . DS);
define('ENTITIES_PATH', MODELS_PATH . 'Entities' . DS);
define('ENTITIES_PATH_AUTO', MODELS_PATH . 'EntitiesAuto' . DS);
define('LIBS_PATH', ROOT . 'libs' . DS);
define('CONTROLLER_PATH', ROOT . 'controllers' . DS);
define('TEMP_PATH', ROOT . 'tmp' . DS);
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);
date_default_timezone_set('America/Bogota');

try{

	require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Request.php';
    include_once LIBS_PATH .'class.cookie.php';
    require_once APP_PATH . 'Bootstrap.php';
    include_once LIBS_PATH .'doctrine' . DS . 'Doctrine.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'Model.php';
    require_once APP_PATH . 'View.php';
    require_once APP_PATH . 'Database.php';
    require_once APP_PATH . 'Session.php';
    require_once APP_PATH . 'Hash.php';
    Session::init();
	//echo "DEFAULT: ".Hash::getHash('sha1', '1234', HASH_KEY);exit;
    //$tem = new Doctrine;$tem->generateEntities();exit;
	//$tem = new Doctrine;$tem->generateModels();exit;
	Bootstrap::run(new Request);
}catch(Exception $e){
	echo $e->getMessage();
	exit;
}

?>