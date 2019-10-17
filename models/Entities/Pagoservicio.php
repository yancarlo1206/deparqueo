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
     * @var integer
     *
     * @Column(name="adicional", type="integer", nullable=true)
     */
    private $adicional;


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

     /** 
     * Set adicional
     *
     * @param \Pago $adicional
     * @return Pagoservicio
     */
    public function setAdicional($adicional)
    {
        $this->adicional = $adicional;
    
        return $this;
    }

    /**
     * Get adicional
     *
     * @return \Pago 
     */
    public function getAdicional()
    {
        return $this->adicional;
    }

}
