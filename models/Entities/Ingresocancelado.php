<?php


/* Date: 29/08/2019 23:12:59 */

namespace Entities;

/**
 * Ingresocancelado
 *
 * @Table(name="ingresocancelado", indexes={@Index(name="FK_ingresocancelado_ingresonormal", columns={"ingreso"}), @Index(name="FK_ingresocancelado_usuario", columns={"usuario"})})
 * @Entity
 */
class Ingresocancelado
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
     * @Column(name="observacion", type="string", length=300, nullable=true)
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var \Ingresonormal
     *
     * @ManyToOne(targetEntity="Ingresonormal")
     * @JoinColumns({
     *   @JoinColumn(name="ingreso", referencedColumnName="id")
     * })
     */
    private $ingreso;

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
     * Set id
     *
     * @param integer $id
     * @return Ingresocancelado
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
     * Set observacion
     *
     * @param string $observacion
     * @return Ingresocancelado
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /** 
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Ingresocancelado
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
     * Set ingreso
     *
     * @param \Ingresonormal $ingreso
     * @return Ingresocancelado
     */
    public function setIngreso($ingreso = null)
    {
        $this->ingreso = $ingreso;
    
        return $this;
    }

    /**
     * Get ingreso
     *
     * @return \Ingresonormal 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /** 
     * Set usuario
     *
     * @param \Usuario $usuario
     * @return Ingresocancelado
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
