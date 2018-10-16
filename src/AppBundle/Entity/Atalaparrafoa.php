<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;

/**
 * Atalaparrafoa
 *
 * @ORM\Table(name="atalaparrafoa", indexes={@ORM\Index(name="atala_id_idx", columns={"atala_id"})})
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Atalaparrafoa
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
   * @var string $createdBy
   *
   * @Gedmo\Blameable(on="create")
   * @ORM\Column
   */
  private $createdBy;

  /**
   * @var string $updatedBy
   *
   * @Gedmo\Blameable(on="update")
   * @ORM\Column
   */
  private $updatedBy;

    /**
     * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     * ***** ERLAZIOAK
 * ************************************************************************************************************************************************************************
     * ************************************************************************************************************************************************************************
     */
    
    /**
     * @var \Atala
     *
     * @ORM\ManyToOne(targetEntity="Atala",inversedBy="parrafoak")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="atala_id", referencedColumnName="id")
     * })
     */
    private $atala;

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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * Set atala
     *
     * @param \AppBundle\Entity\Atala $atala
     *
     * @return Atalaparrafoa
     */
    public function setAtala(\AppBundle\Entity\Atala $atala = null)
    {
        $this->atala = $atala;

        return $this;
    }

    /**
     * Get atala
     *
     * @return \AppBundle\Entity\Atala
     */
    public function getAtala()
    {
        return $this->atala;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * @return Atalaparrafoa
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
     * Set position
     *
     * @param integer $position
     *
     * @return Atalaparrafoa
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Atalaparrafoa
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     *
     * @return Atalaparrafoa
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
