<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Pagomensual
 *
 * @Table(name="pagosiniva", indexes={@Index(name="IXFK_pagosiniva_tarjeta", columns={"tarjeta"})})
 * @Entity
 */
class Pagosiniva
{

function __construct() {}

    /**
     * @var string
     *
     * @Column(name="valor", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var string
     *
     * @Column(name="factura", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $factura;

    /**
     * @var \DateTime
     *
     * @Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @Column(name="fecharegistro", type="datetime", nullable=true)
     */
    private $fecharegistro;

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
     * @ManyToOne(targetEntity="Tarjeta")
     * @JoinColumns({
     *   @JoinColumn(name="tarjeta", referencedColumnName="rfid")
     * })
     */
    private $tarjeta;


    /** 
     * Set valor
     *
     * @param string $valor
     * @return Pagomensual
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
     * Set factura
     *
     * @param string $factura
     * @return Pagomensual
     */
    public function setFactura($factura)
    {
        $this->factura = $factura;
    
        return $this;
    }

    /**
     * Get factura
     *
     * @return string 
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /** 
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Pagomensual
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /** 
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return Pagomensual
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;
    
        return $this;
    }

    /**
     * Get fecharegistro
     *
     * @return \DateTime 
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /** 
     * Set id
     *
     * @param \Pago $id
     * @return Pagomensual
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return \Pago 
     */
    public function getId()
    {
        return $this->id;
    }

    /** 
     * Set tarjeta
     *
     * @param \Tarjeta $tarjeta
     * @return Pagomensual
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
