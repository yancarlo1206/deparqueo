<?php


/* Date: 17/06/2019 21:52:50 */

namespace Entities;

/**
 * Tarjeta
 *
 * @Table(name="tarjeta", indexes={@Index(name="IXFK_tarjeta_cliente", columns={"cliente"}), @Index(name="IXFK_tarjeta_tipovehiculo", columns={"tipovehiculo"}), @Index(name="IXFK_tarjeta_usuario", columns={"usuarioactivo"})})
 * @Entity
 */
class Tarjeta
{

function __construct() {}

    /**
     * @var string
     *
     * @Column(name="rfid", type="string", length=50, nullable=false)
     * @Id
     */
    private $rfid;

    /**
     * @var integer
     *
     * @Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

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
     * @var \Cliente
     *
     * @ManyToOne(targetEntity="Cliente")
     * @JoinColumns({
     *   @JoinColumn(name="cliente", referencedColumnName="id")
     * })
     */
    private $cliente;

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
     * @var \Usuario
     *
     * @ManyToOne(targetEntity="Usuario")
     * @JoinColumns({
     *   @JoinColumn(name="usuarioactivo", referencedColumnName="id")
     * })
     */
    private $usuarioactivo;


    /** 
     * Set rfid
     *
     * @param string $rfid
     * @return Tarjeta
     */
    public function setRfid($rfid)
    {
        $this->rfid = $rfid;
    
        return $this;
    }

    /**
     * Get rfid
     *
     * @return string 
     */
    public function getRfid()
    {
        return $this->rfid;
    }

    /** 
     * Set estado
     *
     * @param integer $estado
     * @return Tarjeta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /** 
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     * @return Tarjeta
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
     * @return Tarjeta
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
     * Set cliente
     *
     * @param \Cliente $cliente
     * @return Tarjeta
     */
    public function setCliente($cliente = null)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /** 
     * Set tipovehiculo
     *
     * @param \Tipovehiculo $tipovehiculo
     * @return Tarjeta
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

    /** 
     * Set usuarioactivo
     *
     * @param \Usuario $usuarioactivo
     * @return Tarjeta
     */
    public function setUsuarioactivo($usuarioactivo = null)
    {
        $this->usuarioactivo = $usuarioactivo;
    
        return $this;
    }

    /**
     * Get usuarioactivo
     *
     * @return \Usuario 
     */
    public function getUsuarioactivo()
    {
        return $this->usuarioactivo;
    }
}
