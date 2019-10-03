<?php


/* Date: 17/06/2019 21:52:50 */

namespace Entities;

/**
 * Usuario
 *
 * @Table(name="usuario", indexes={@Index(name="IXFK_usuario_rol", columns={"rol"})})
 * @Entity
 */
class Usuario
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
     * @Column(name="usuario", type="string", length=20, nullable=true)
     */
    private $usuario;

    /**
     * @var string
     *
     * @Column(name="clave", type="string", length=100, nullable=true)
     */
    private $clave;

    /**
     * @var string
     *
     * @Column(name="rfid", type="string", length=50, nullable=true)
     */
    private $rfid;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Column(name="documento", type="string", length=20, nullable=true)
     */
    private $documento;

    /**
     * @var \DateTime
     *
     * @Column(name="fechanacimiento", type="date", nullable=true)
     */
    private $fechanacimiento;

    /**
     * @var \Rol
     *
     * @ManyToOne(targetEntity="Rol")
     * @JoinColumns({
     *   @JoinColumn(name="rol", referencedColumnName="id")
     * })
     */
    private $rol;


    /** 
     * Set id
     *
     * @param integer $id
     * @return Usuario
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
     * Set usuario
     *
     * @param string $usuario
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /** 
     * Set clave
     *
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    
        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /** 
     * Set rfid
     *
     * @param string $rfid
     * @return Usuario
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
     * Set email
     *
     * @param string $email
     * @return Usuario
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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set documento
     *
     * @param string $documento
     * @return Usuario
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
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     * @return Usuario
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
     * Set rol
     *
     * @param \Rol $rol
     * @return Usuario
     */
    public function setRol($rol = null)
    {
        $this->rol = $rol;
    
        return $this;
    }

    /**
     * Get rol
     *
     * @return \Rol 
     */
    public function getRol()
    {
        return $this->rol;
    }
}
