<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Cliente
 *
 * @Table(name="cliente", indexes={@Index(name="IXFK_cliente_tipocliente", columns={"tipocliente"}), @Index(name="IXFK_cliente_usuario", columns={"usuario"})})
 * @Entity
 */
class Cliente
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
     * @Column(name="documento", type="string", length=20, nullable=true)
     */
    private $documento;

    /**
     * @var string
     *
     * @Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @Column(name="fechanacimiento", type="date", nullable=true)
     */
    private $fechanacimiento;

    /**
     * @var string
     *
     * @Column(name="direccion", type="string", length=50, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @Column(name="telefono", type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var \Tipocliente
     *
     * @ManyToOne(targetEntity="Tipocliente")
     * @JoinColumns({
     *   @JoinColumn(name="tipocliente", referencedColumnName="id")
     * })
     */
    private $tipocliente;

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
     * @return Cliente
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
     * Set documento
     *
     * @param string $documento
     * @return Cliente
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
     * Set nombre
     *
     * @param string $nombre
     * @return Cliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /** 
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     * @return Cliente
     */
    public function setFechanacimiento($fechanacimiento)
    {
        $this->fechanacimiento = $fechanacimiento;
    
        return $this;
    }

    /**
     * Get fechanacimiento
     *
     * @return \DateTime 
     */
    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /** 
     * Set direccion
     *
     * @param string $direccion
     * @return Cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /** 
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /** 
     * Set email
     *
     * @param string $email
     * @return Cliente
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /** 
     * Set tipocliente
     *
     * @param \Tipocliente $tipocliente
     * @return Cliente
     */
    public function setTipocliente($tipocliente = null)
    {
        $this->tipocliente = $tipocliente;
    
        return $this;
    }

    /**
     * Get tipocliente
     *
     * @return \Tipocliente 
     */
    public function getTipocliente()
    {
        return $this->tipocliente;
    }

    /** 
     * Set usuario
     *
     * @param \Usuario $usuario
     * @return Cliente
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
