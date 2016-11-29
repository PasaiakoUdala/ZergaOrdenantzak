<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Azpiatalaparrafoaondoren
 *
 * @ORM\Table(name="azpiatalaparrafoaondoren")
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AzpiatalaparrafoaondorenRepository")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Azpiatalaparrafoaondoren
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
     *
     * @ORM\Column(name="ordena", type="bigint", nullable=true)
     */
    private $ordena;

    /**
     * @var integer
     * @Expose
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
     * @Expose
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
     * @Expose
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
     * @var \Azpiatala
     *
     * @ORM\ManyToOne(targetEntity="Azpiatala",inversedBy="parrafoakondoren")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="azpiatala_id", referencedColumnName="id")
     * })
     */
    private $azpiatala;

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
     * @return Azpiatalaparrafoaondoren
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
     * Set ordenaProd
     *
     * @param integer $ordenaProd
     *
     * @return Azpiatalaparrafoaondoren
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
     * Set testuaeu
     *
     * @param string $testuaeu
     *
     * @return Azpiatalaparrafoaondoren
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
     * Set testuaeuProd
     *
     * @param string $testuaeuProd
     *
     * @return Azpiatalaparrafoaondoren
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
     * Set testuaes
     *
     * @param string $testuaes
     *
     * @return Azpiatalaparrafoaondoren
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
     * Set testuaesProd
     *
     * @param string $testuaesProd
     *
     * @return Azpiatalaparrafoaondoren
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
     * @return Azpiatalaparrafoaondoren
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Azpiatalaparrafoaondoren
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
     * @return Azpiatalaparrafoaondoren
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
     * Set azpiatala
     *
     * @param \AppBundle\Entity\Azpiatala $azpiatala
     *
     * @return Azpiatalaparrafoaondoren
     */
    public function setAzpiatala(\AppBundle\Entity\Azpiatala $azpiatala = null)
    {
        $this->azpiatala = $azpiatala;

        return $this;
    }

    /**
     * Get azpiatala
     *
     * @return \AppBundle\Entity\Azpiatala
     */
    public function getAzpiatala()
    {
        return $this->azpiatala;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Azpiatalaparrafoaondoren
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
}
