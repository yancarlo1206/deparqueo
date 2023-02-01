<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Ingresotarjeta
 *
 * @Table(name="ingresotarjeta", indexes={@Index(name="IXFK_ingresotarjeta_tarjeta", columns={"tarjeta"})})
 * @Entity
 */
class Ingresotarjeta
{

function __construct() {}

    /**
     * @var \Ingreso
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Ingreso")
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
     * Set id
     *
     * @param \Ingreso $id
     * @return Ingresotarjeta
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return \Ingreso 
     */
    public function getId()
    {
        return $this->id;
    }

    /** 
     * Set tarjeta
     *
     * @param \Tarjeta $tarjeta
     * @return Ingresotarjeta
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
