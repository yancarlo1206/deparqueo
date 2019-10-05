<?php


/* Date: 04/10/2019 21:05:09 */

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
}
