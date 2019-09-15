<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Tarifa
 *
 * @Table(name="tarifa", indexes={@Index(name="IXFK_tarifa_tipotarifa", columns={"tipotarifa"}), @Index(name="IXFK_tarifa_tipovehiculo", columns={"tipovehiculo"})})
 * @Entity
 */
class Tarifa
{

function __construct() {}

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="descripcion", type="string", length=100, nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @Column(name="fechainicio", type="date", nullable=true)
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @Column(name="fechafin", type="date", nullable=true)
     */
    private $fechafin;

    /**
     * @var string
     *
     * @Column(name="valor", type="decimal", precision=9, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var \Tipotarifa
     *
     * @ManyToOne(targetEntity="Tipotarifa")
     * @JoinColumns({
     *   @JoinColumn(name="tipotarifa", referencedColumnName="id")
     * })
     */
    private $tipotarifa;

    /**
     * @var \Tipovehiculo
     *
     * @ManyToOne(targetEntity="Tipovehiculo")
     * @JoinColumns({
     *   @JoinColumn(name="tipovehiculo", referencedColumnName="id")
     * })
     */
    private $tipovehiculo;


    /** 
     * Set id
     *
     * @param integer $id
     * @return Tarifa
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /** 
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tarifa
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /** 
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     * @return Tarifa
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    
        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime 
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /** 
     * Set fechafin
     *
     * @param \DateTime $fechafin
     * @return Tarifa
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;
    
        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime 
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /** 
     * Set valor
     *
     * @param string $valor
     * @return Tarifa
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /** 
     * Set tipotarifa
     *
     * @param \Tipotarifa $tipotarifa
     * @return Tarifa
     */
    public function setTipotarifa($tipotarifa = null)
    {
        $this->tipotarifa = $tipotarifa;
    
        return $this;
    }

    /**
     * Get tipotarifa
     *
     * @return \Tipotarifa 
     */
    public function getTipotarifa()
    {
        return $this->tipotarifa;
    }

    /** 
     * Set tipovehiculo
     *
     * @param \Tipovehiculo $tipovehiculo
     * @return Tarifa
     */
    public function setTipovehiculo($tipovehiculo = null)
    {
        $this->tipovehiculo = $tipovehiculo;
    
        return $this;
    }

    /**
     * Get tipovehiculo
     *
     * @return \Tipovehiculo 
     */
    public function getTipovehiculo()
    {
        return $this->tipovehiculo;
    }
}
