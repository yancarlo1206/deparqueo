<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Accesocaja
 *
 * @Table(name="accesocaja", indexes={@Index(name="IXFK_accesocaja_caja", columns={"caja"}), @Index(name="IXFK_accesocaja_usuario", columns={"usuario"})})
 * @Entity
 */
class Accesocaja
{

function __construct() {}

    /**
     * @var \DateTime
     *
     * @Column(name="fechainicio", type="datetime", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @Column(name="fechacierre", type="datetime", nullable=true)
     */
    private $fechacierre;

    /**
     * @var string
     *
     * @Column(name="totalrecibido", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $totalrecibido;

    /**
     * @var string
     *
     * @Column(name="totalcierre", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $totalcierre;

    /**
     * @var \Caja
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Caja")
     * @JoinColumns({
     *   @JoinColumn(name="caja", referencedColumnName="id")
     * })
     */
    private $caja;

    /**
     * @var \Usuario
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Usuario")
     * @JoinColumns({
     *   @JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;


    /** 
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     * @return Accesocaja
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
     * Set fechacierre
     *
     * @param \DateTime $fechacierre
     * @return Accesocaja
     */
    public function setFechacierre($fechacierre)
    {
        $this->fechacierre = $fechacierre;
    
        return $this;
    }

    /**
     * Get fechacierre
     *
     * @return \DateTime 
     */
    public function getFechacierre()
    {
        return $this->fechacierre;
    }

    /** 
     * Set totalrecibido
     *
     * @param string $totalrecibido
     * @return Accesocaja
     */
    public function setTotalrecibido($totalrecibido)
    {
        $this->totalrecibido = $totalrecibido;
    
        return $this;
    }

    /**
     * Get totalrecibido
     *
     * @return string 
     */
    public function getTotalrecibido()
    {
        return $this->totalrecibido;
    }

    /** 
     * Set totalcierre
     *
     * @param string $totalcierre
     * @return Accesocaja
     */
    public function setTotalcierre($totalcierre)
    {
        $this->totalcierre = $totalcierre;
    
        return $this;
    }

    /**
     * Get totalcierre
     *
     * @return string 
     */
    public function getTotalcierre()
    {
        return $this->totalcierre;
    }

    /** 
     * Set caja
     *
     * @param \Caja $caja
     * @return Accesocaja
     */
    public function setCaja($caja)
    {
        $this->caja = $caja;
    
        return $this;
    }

    /**
     * Get caja
     *
     * @return \Caja 
     */
    public function getCaja()
    {
        return $this->caja;
    }

    /** 
     * Set usuario
     *
     * @param \Usuario $usuario
     * @return Accesocaja
     */
    public function setUsuario($usuario)
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
