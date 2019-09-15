<?php

class Model extends Doctrine {

    protected $instance;
    protected $instanceHome;
    protected $nameInstance;    

    public function __construct() {

    }

    protected function loadObjeto($objeto) {
        $objeto = ucwords(strtolower($objeto));
        $this->nameInstance = $objeto;
        $this->instanceHome = $this->getEm()->getRepository('Entities\\'.$objeto);
        $t = "Entities\\" . $objeto;
        return $this->instance = new $t;
    }

    public function getInstanceHome() {
        return $this->instanceHome;
    }

    public function getInstance() {
        return $this->instance;
    }

    public function setInstance($instance) {
        $this->instance = $instance;
    }

    public function save() {
        $this->getEm()->persist($this->instance);
        $this->getEm()->flush();
    }

    public function update() {
        $this->getEm()->flush();
    }

    public function delete() {
        $this->getEm()->remove($this->instance);
        $this->getEm()->flush();
    }
    
    public function resultList() {
        return $this->instanceHome->findAll();
    }

    public function findByOrder($where  = array(),$orderBy = array(),$limit = 0) {
        return $this->instanceHome->findBy($where, $orderBy, $limit, 0);
    }

    public function get($id) {
        $this->instance = $this->instanceHome->find($id);
        return $this->instance;
    }
    
    public function findBy($arreglo, $order = array()) {
        return $this->instanceHome->findBy($arreglo, $order);
    }

    public function findByObject($arreglo) {
        $objetos = $this->instanceHome->findBy($arreglo);
        if(count($objetos)){
            $this->instance = $objetos[0];
            return $this->instance;
        }
        else return null;
    }        
    
    public function nativeQuery($sql) {
        $conn = $this->getEm()->getConnection();
        return $conn->query($sql)->fetchAll();                
    }        
    
    public function exec($sql) {
        $conn = $this->getEm()->getConnection();
        return $conn->exec($sql);                
    }
    
    public function dql($dql, $parametros = array()) {
        $query = $this->getEm()->createQuery($dql);
        foreach ($parametros as $key => $valor)
            $query->setParameter($key, $valor);
        return $query->getResult();        
    }

    public function reloadInstance() {
       $this->instance = $this->loadObjeto($this->nameInstance);
    }
}

?>