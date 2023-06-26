<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Pagobathroom
 *
 * @Table(name="pagobathroom", indexes={@Index(name="IXFK_pagobathroom_tarjetabathroom", columns={"tarjeta"})})
 * @Entity
 */
class Pagobathroom
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
     * @var \Tarjetabathroom
     *
     * @ManyToOne(targetEntity="Tarjetabathroom")
     * @JoinColumns({
     *   @JoinColumn(name="tarjeta", referencedColumnName="rfid")
     * })
     */
    private $tarjeta;


    /** 
     * Set valor
     *
     * @param string $valor
     * @return Pagobathroom
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
     * @return Pagobathroom
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
     * @return Pagobathroom
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
     * @return Pagobathroom
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
     * @return Pagobathroom
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
