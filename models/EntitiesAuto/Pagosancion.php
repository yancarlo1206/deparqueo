<?php


/* Date: 04/10/2019 21:05:09 */

namespace Entities;

/**
 * Pagosancion
 *
 * @Table(name="pagosancion", indexes={@Index(name="FK_pagosancion_tiposancion", columns={"tiposancion"})})
 * @Entity
 */
class Pagosancion
{

function __construct() {}

    /**
     * @var string
     *
     * @Column(name="documento", type="string", length=20, nullable=true)
     */
    private $documento;

    /**
     * @var \DateTime
     *
     * @Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

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
     * @var \Tiposancion
     *
     * @ManyToOne(targetEntity="Tiposancion")
     * @JoinColumns({
     *   @JoinColumn(name="tiposancion", referencedColumnName="id")
     * })
     */
    private $tiposancion;


    /** 
     * Set documento
     *
     * @param string $documento
     * @return Pagosancion
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    
        return $this;
    }

    /**
     * Get documento
     *
     * @return string 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /** 
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Pagosancion
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
     * Set id
     *
     * @param \Pago $id
     * @return Pagosancion
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
     * Set tiposancion
     *
     * @param \Tiposancion $tiposancion
     * @return Pagosancion
     */
    public function setTiposancion($tiposancion = null)
    {
        $this->tiposancion = $tiposancion;
    
        return $this;
    }

    /**
     * Get tiposancion
     *
     * @return \Tiposancion 
     */
    public function getTiposancion()
    {
        return $this->tiposancion;
    }
}
