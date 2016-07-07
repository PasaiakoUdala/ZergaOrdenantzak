<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;

/**
 * Ordenantzaparrafoa
 *
 * @ORM\Table(name="ordenantzaparrafoa", indexes={@ORM\Index(name="ordenantza_id_idx", columns={"ordenantza_id"})})
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Ordenantzaparrafoa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="ordena", type="integer", nullable=true)
     */
    private $ordena;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordena_prod", type="bigint", nullable=true)
     */
    private $ordena_prod;

    /**
     * @var string
     *
     * @ORM\Column(name="testuaeu", type="text", length=65535, nullable=true)
     */
    private $testuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="testuaeu_prod", type="text", length=65535, nullable=true)
     */
    private $testuaeu_prod;

    /**
     * @var string
     *
     * @ORM\Column(name="testuaes", type="text", length=65535, nullable=true)
     */
    private $testuaes;

    /**
     * @var string
     *
     * @ORM\Column(name="testuaes_prod", type="text", length=65535, nullable=true)
     */
    private $testuaes_prod;

    /**
     * @var bool
     *
     * @ORM\Column(name="ezabatu", type="boolean", nullable=true)
     */
    private $ezabatu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     * ***** ERLAZIOAK
     * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     */

    /**
     * @var \Ordenantza
     *
     * @ORM\ManyToOne(targetEntity="Ordenantza", inversedBy="parrafoak")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ordenantza_id", referencedColumnName="id")
     * })
     */
    private $ordenantza;

    /**
     * @var Udala
     * @ORM\ManyToOne(targetEntity="Udala")
     */
    private $udala;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->getTestuaeu();
    }

    /**
     * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     * ***** ERLAZIOAK
     * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     */

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
     * Set ordena
     *
     * @param integer $ordena
     *
     * @return Ordenantzaparrafoa
     */
    public function setOrdena($ordena)
    {
        $this->ordena = $ordena;

        return $this;
    }

    /**
     * Get ordena
     *
     * @return integer
     */
    public function getOrdena()
    {
        return $this->ordena;
    }

    /**
     * Set testuaeu
     *
     * @param string $testuaeu
     *
     * @return Ordenantzaparrafoa
     */
    public function setTestuaeu($testuaeu)
    {
        $this->testuaeu = $testuaeu;

        return $this;
    }

    /**
     * Get testuaeu
     *
     * @return string
     */
    public function getTestuaeu()
    {
        return $this->testuaeu;
    }

    /**
     * Set testuaes
     *
     * @param string $testuaes
     *
     * @return Ordenantzaparrafoa
     */
    public function setTestuaes($testuaes)
    {
        $this->testuaes = $testuaes;

        return $this;
    }

    /**
     * Get testuaes
     *
     * @return string
     */
    public function getTestuaes()
    {
        return $this->testuaes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ordenantzaparrafoa
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ordenantzaparrafoa
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set ordenantza
     *
     * @param \AppBundle\Entity\Ordenantza $ordenantza
     *
     * @return Ordenantzaparrafoa
     */
    public function setOrdenantza(\AppBundle\Entity\Ordenantza $ordenantza = null)
    {
        $this->ordenantza = $ordenantza;

        return $this;
    }

    /**
     * Get ordenantza
     *
     * @return \AppBundle\Entity\Ordenantza
     */
    public function getOrdenantza()
    {
        return $this->ordenantza;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Ordenantzaparrafoa
     */
    public function setUdala(\AppBundle\Entity\Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return \AppBundle\Entity\Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Set ordenaProd
     *
     * @param integer $ordenaProd
     *
     * @return Ordenantzaparrafoa
     */
    public function setOrdenaProd($ordenaProd)
    {
        $this->ordena_prod = $ordenaProd;

        return $this;
    }

    /**
     * Get ordenaProd
     *
     * @return integer
     */
    public function getOrdenaProd()
    {
        return $this->ordena_prod;
    }

    /**
     * Set testuaeuProd
     *
     * @param string $testuaeuProd
     *
     * @return Ordenantzaparrafoa
     */
    public function setTestuaeuProd($testuaeuProd)
    {
        $this->testuaeu_prod = $testuaeuProd;

        return $this;
    }

    /**
     * Get testuaeuProd
     *
     * @return string
     */
    public function getTestuaeuProd()
    {
        return $this->testuaeu_prod;
    }

    /**
     * Set testuaesProd
     *
     * @param string $testuaesProd
     *
     * @return Ordenantzaparrafoa
     */
    public function setTestuaesProd($testuaesProd)
    {
        $this->testuaes_prod = $testuaesProd;

        return $this;
    }

    /**
     * Get testuaesProd
     *
     * @return string
     */
    public function getTestuaesProd()
    {
        return $this->testuaes_prod;
    }

    /**
     * Set ezabatu
     *
     * @param boolean $ezabatu
     *
     * @return Ordenantzaparrafoa
     */
    public function setEzabatu($ezabatu)
    {
        $this->ezabatu = $ezabatu;

        return $this;
    }

    /**
     * Get ezabatu
     *
     * @return boolean
     */
    public function getEzabatu()
    {
        return $this->ezabatu;
    }
}
