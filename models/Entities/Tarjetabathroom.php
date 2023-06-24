<?php


/* Date: 17/06/2019 21:52:50 */

namespace Entities;

/**
 * Tarjetabathroom
 *
 * @Table(name="tarjetabathroom", indexes={@Index(name="IXFK_tarjetabathroom_usuario", columns={"usuario"})})
 * @Entity
 */
class Tarjetabathroom
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
     * @Column(name="entradas", type="integer", nullable=true)
     */
    private $entradas;

    /**
     * @var integer
     *
     * @Column(name="estado", type="integer", nullable=true)
     */
    private $estado;
  
    /**
     * @var \Usuario
     *
     * @ManyToOne(targetEntity="Usuario")
     * @JoinColumns({
     *   @JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;


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
     * Set entradas
     *
     * @param \entradas $entradas
     * @return Tarjeta
     */
    public function setEntradas($entradas = null)
    {
        $this->entradas = $entradas;
    
        return $this;
    }

    /**
     * Get entradas
     *
     * @return \entradas 
     */
    public function getEntradas()
    {
        return $this->entradas;
    }

    /** 
     * Set usuario
     *
     * @param \Usuario $usuario
     * @return Tarjeta
     */
    public function setUsuario($usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
