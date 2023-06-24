<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Ingresobathroom
 *
 * @Table(name="ingresobathroom", indexes={@Index(name="IXFK_ingresobathroom_tarjetabathroom", columns={"tarjeta"})})
 * @Entity
 */
class Ingresobathroom
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
     * @var \Tarjeta
     *
     * @ManyToOne(targetEntity="Tarjetabathroom")
     * @JoinColumns({
     *   @JoinColumn(name="tarjeta", referencedColumnName="rfid")
     * })
     */
    private $tarjeta;

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
     * Set tarjeta
     *
     * @param \Tipovehiculo $tarjeta
     * @return Ingresobathroom
     */
    public function setTarjeta($tarjeta = null)
    {
        $this->tarjeta = $tarjeta;
    
        return $this;
    }

    /**
     * Get tarjeta
     *
     * @return \Tarjeta
     */
    public function getTarjeta()
    {
        return $this->tarjeta;
    }

}
