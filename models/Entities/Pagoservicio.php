<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Pagoservicio
 *
 * @Table(name="pagoservicio", indexes={@Index(name="IXFK_pagoservicio_ingresonormal", columns={"ingreso"})})
 * @Entity
 */
class Pagoservicio
{

function __construct() {}

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
     * Set ingreso
     *
     * @param \Ingresonormal $ingreso
     * @return Pagoservicio
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
     * Set id
     *
     * @param \Pago $id
     * @return Pagoservicio
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
}
