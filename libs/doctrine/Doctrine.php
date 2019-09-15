<?php

class Doctrine {
	
    static protected $em = null;
	
    public function __construct() {		
	}
	
	public function getEm() {
		if (self::$em == null) {
			require_once 'Doctrine/Common/ClassLoader.php';
			$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
			$classLoader->register();
			$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__."\..\..\models");
			$classLoader->register();
			$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
			$classLoader->register();
			
			// (2) Configuración
			$config = new \Doctrine\ORM\Configuration();

			// (3) Caché
			$cache = new \Doctrine\Common\Cache\ArrayCache();
			$config->setMetadataCacheImpl($cache);
			$config->setQueryCacheImpl($cache);

			// (4) Driver
			$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/Entities"));
			$config->setMetadataDriverImpl($driverImpl);

			// (5) Proxies
			$config->setProxyDir(__DIR__ . '/Proxies');
			$config->setProxyNamespace('Proxies');

			// (6) Conexión

 			$connectionOptions = array(
                'driver' => 'pdo_mysql',
                'host' => DB_HOST,
                'port' => DB_PORT,
                'user' => DB_USER,
                'password' => DB_PASS,
                'dbname' => DB_NAME,
                'charset' => DB_CHAR,
                'driverOptions' => array(
                        'charset'   => DB_CHAR
                    )
            );
			
			self::$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
		}
        return self::$em;
    }

    public function generateEntities(){
        $this->getEm();
        self::$em->getConfiguration()->setMetadataDriverImpl(
            new Doctrine\ORM\Mapping\Driver\DatabaseDriver( self::$em->getConnection()->getSchemaManager())
        );
        $cmf = new Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
        $cmf->setEntityManager(self::$em);
        $metadata = $cmf->getAllMetadata();
        $cme = new Doctrine\ORM\Tools\Export\ClassMetadataExporter();
        $exporter = $cme->getExporter('annotation', 'config/ann');
        $generator = new Doctrine\ORM\Tools\EntityGenerator();
        echo "Generate Entities.... ";
        $generator->setGenerateAnnotations(true);
        $generator->setGenerateStubMethods(true);
        $generator->setRegenerateEntityIfExists(true);
        $generator->setUpdateEntityIfExists(false);
        $result = $generator->generate($metadata, ENTITIES_PATH_AUTO);
        echo "done    ";
        $this->generateModels(ENTITIES_PATH_AUTO,MODELS_PATH);
    }

    public function generateModels($pathEntity=ENTITIES_PATH_AUTO, $pathModel=MODELS_PATH,$type = "php"){
        $d = opendir($pathEntity);
        $tem = "";
        echo "Generate Models ";
        while (false !== ($f = readdir($d))){
            if ($f != "." && $f != "..") {
                $rta = explode('.',$f);
                $entity = $rta[0];
                $model =  strtolower($rta[0])."Model";
                $nombre =  $model.".".$type;
                $dir = $pathModel.DS.$nombre;
                if(!file_exists($dir)){
                    $ar=fopen($dir,"a") or die("Problemas en la creacion");
                    fputs($ar,"<?php\n");
                    fputs($ar,"/*\n* -------------------------------------\n* \n* Date: ".date("d/m/Y H:i:s",time())." \n* ".$model.".".$type."\n* -------------------------------------\n*/\n");
                    fputs($ar,"class ".$model." extends Model {\n");
                    fputs($ar,"    public function __construct() {\n");
                    fputs($ar,"        parent::__construct(); \n");
                    fputs($ar,"        \$this->instance = \$this->loadObjeto('".$entity."'); \n");
                    fputs($ar,"    }\n");
                    fputs($ar,"}\n");
                    fputs($ar,"?>");
                    fclose($ar);
                    $tem.=$model.',';
                }
            }
        }
        echo "(".$tem.").... done    ";
    }

}

?>