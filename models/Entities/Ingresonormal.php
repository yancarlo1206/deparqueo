<?php


/* Date: 17/06/2019 21:52:49 */

namespace Entities;

/**
 * Ingresonormal
 *
 * @Table(name="ingresonormal")
 * @Entity
 */
class Ingresonormal
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
     * @OneToMany(targetEntity="Pagoservicio", mappedBy="ingreso")
     */
    private $pagos;

    /**
     * @OneToMany(targetEntity="Nopagoservicio", mappedBy="ingreso")
     */
    private $noPagos;

    /**
     * @OneToMany(targetEntity="Ingresocancelado", mappedBy="ingreso")
     */
    private $cancelados;


    /** 
     * Set id
     *
     * @param \Ingreso $id
     * @return Ingresonormal
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

    public function setPagos($pagos)
    {
        $this->pagos = $pagos;
    
        return $this;
    }

    public function getPagos()
    {
        return $this->pagos;
    }

    public function setNoPagos($noPagos)
    {
        $this->noPagos = $noPagos;
    
        return $this;
    }

    public function getNoPagos()
    {
        return $this->noPagos;
    }

    public function setCancelados($cancelados)
    {
        $this->cancelados = $cancelados;
    
        return $this;
    }

    public function getCancelados()
    {
        return $this->cancelados;
    }


}
