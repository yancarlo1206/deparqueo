<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Ingreso
 *
 * @Table(name="ingreso", indexes={@Index(name="IXFK_ingreso_tipovehiculo", columns={"tipo"})})
 * @Entity
 */
class Ingreso
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
     * @var \Date
     *
     * @Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @Column(name="fechaingreso", type="datetime", nullable=true)
     */
    private $fechaingreso;

    /**
     * @var \DateTime
     *
     * @Column(name="fechasalida", type="datetime", nullable=true)
     */
    private $fechasalida;

    /**
     * @var string
     *
     * @Column(name="numero", type="string", length=12, nullable=true)
     */
    private $numero;

    /**
     * @var \Tipovehiculo
     *
     * @ManyToOne(targetEntity="Tipovehiculo")
     * @JoinColumns({
     *   @JoinColumn(name="tipo", referencedColumnName="id")
     * })
     */
    private $tipo;

    /**
     * @OneToMany(targetEntity="Ingresonormal", mappedBy="id")
     */
    private $ingresoNormal;

    /** 
     * Set id
     *
     * @param integer $id
     * @return Ingreso
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
     * Set fecha
     *
     * @param \Date $fecha
     * @return Ingreso
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \Date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /** 
     * Set fechaingreso
     *
     * @param \DateTime $fechaingreso
     * @return Ingreso
     */
    public function setFechaingreso($fechaingreso)
    {
        $this->fechaingreso = $fechaingreso;
    
        return $this;
    }

    /**
     * Get fechaingreso
     *
     * @return \DateTime 
     */
    public function getFechaingreso()
    {
        return $this->fechaingreso;
    }

    /** 
     * Set fechasalida
     *
     * @param \DateTime $fechasalida
     * @return Ingreso
     */
    public function setFechasalida($fechasalida)
    {
        $this->fechasalida = $fechasalida;
    
        return $this;
    }

    /**
     * Get fechasalida
     *
     * @return \DateTime 
     */
    public function getFechasalida()
    {
        return $this->fechasalida;
    }

    /** 
     * Set numero
     *
     * @param string $numero
     * @return Ingreso
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /** 
     * Set tipo
     *
     * @param \Tipovehiculo $tipo
     * @return Ingreso
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Tipovehiculo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function setIngresoNormal($ingresoNormal)
    {
        $this->ingresoNormal = $ingresoNormal;
    
        return $this;
    }

    public function getIngresoNormal()
    {
        return $this->ingresoNormal;
    }
}
