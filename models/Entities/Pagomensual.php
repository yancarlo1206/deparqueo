<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Pagomensual
 *
 * @Table(name="pagomensual", indexes={@Index(name="IXFK_pagomensual_tarjeta", columns={"tarjeta"})})
 * @Entity
 */
class Pagomensual
{

function __construct() {}

    /**
     * @var string
     *
     * @Column(name="valor", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $valor;

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
     * @var \Pago
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Pago")
     * @JoinColumns({
     *   @JoinColumn(name="id", referencedColumnName="id")
     * })
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
