<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Pago
 *
 * @Table(name="pago", indexes={@Index(name="IXFK_pago_caja", columns={"caja"}), @Index(name="IXFK_pago_ingresonormal", columns={"ingreso"}), @Index(name="IXFK_pago_usuario", columns={"usuario"})})
 * @Entity
 */
class Pago
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
     * @var \DateTime
     *
     * @Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @Column(name="valor", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $valor;

    /**
     * @var integer
     *
     * @Column(name="ingreso", type="integer", nullable=true)
     */
    private $ingreso;

    /**
     * @var string
     *
     * @Column(name="entrego", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $entrego;

    /**
     * @var string
     *
     * @Column(name="cambio", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $cambio;

    /**
     * @var string
     *
     * @Column(name="iva", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $iva;

    /**
     * @var \Caja
     *
     * @ManyToOne(targetEntity="Caja")
     * @JoinColumns({
     *   @JoinColumn(name="caja", referencedColumnName="id")
     * })
     */
    private $caja;

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
     * @return Pago
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
     * @param \DateTime $fecha
     * @return Pago
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
     * Set valor
     *
     * @param string $valor
     * @return Pago
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
     * Set ingreso
     *
     * @param integer $ingreso
     * @return Pago
     */
    public function setIngreso($ingreso)
    {
        $this->ingreso = $ingreso;
    
        return $this;
    }

    /**
     * Get ingreso
     *
     * @return integer 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /** 
     * Set entrego
     *
     * @param string $entrego
     * @return Pago
     */
    public function setEntrego($entrego)
    {
        $this->entrego = $entrego;
    
        return $this;
    }

    /**
     * Get entrego
     *
     * @return string 
     */
    public function getEntrego()
    {
        return $this->entrego;
    }

    /** 
     * Set cambio
     *
     * @param string $cambio
     * @return Pago
     */
    public function setCambio($cambio)
    {
        $this->cambio = $cambio;
    
        return $this;
    }

    /**
     * Get cambio
     *
     * @return string 
     */
    public function getCambio()
    {
        return $this->cambio;
    }

    /** 
     * Set iva
     *
     * @param string $iva
     * @return Pago
     */
    public function setIva($iva)
    {
        $this->iva = $iva;
    
        return $this;
    }

    /**
     * Get iva
     *
     * @return string 
     */
    public function getIva()
    {
        return $this->iva;
    }

    /** 
     * Set caja
     *
     * @param \Caja $caja
     * @return Pago
     */
    public function setCaja($caja = null)
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
     * @return Pago
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
