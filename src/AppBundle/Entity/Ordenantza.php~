<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;

/**
 * Ordenantza
 *
 * @ORM\Table(name="ordenantza", uniqueConstraints={@ORM\UniqueConstraint(name="kodea", columns={"kodea"})})
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Ordenantza
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
     * @var string
     *
     * @ORM\Column(name="kodea", type="string", length=9, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="kodea_prod", type="string", length=9, nullable=true)
     */
    private $kodea_prod;

    /**
     * @var string
     *
     * @ORM\Column(name="izenburuaeu", type="string", length=255, nullable=true)
     */
    private $izenburuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="izenburuaeu_prod", type="string", length=255, nullable=true)
     */
    private $izenburuaeu_prod;

    /**
     * @var string
     *
     * @ORM\Column(name="izenburuaes", type="string", length=255, nullable=true)
     */
    private $izenburuaes;

   /**
     * @var string
     *
     * @ORM\Column(name="izenburuaes_prod", type="string", length=255, nullable=true)
     */
    private $izenburuaes_prod;

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
     * @var Ordenantza
     * @ORM\OneToMany(targetEntity="Ordenantzaparrafoa", mappedBy="ordenantza", cascade={"remove"})
     */
    protected $parrafoak;

    /**
     * @var Atala
     * @ORM\OneToMany(targetEntity="Atala", mappedBy="ordenantza", cascade={"remove"})
     */
    protected $atalak;

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
        return $this->getKodea();
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
     * Set kodea
     *
     * @param string $kodea
     *
     * @return Ordenantza
     */
    public function setKodea($kodea)
    {
        $this->kodea = $kodea;

        return $this;
    }

    /**
     * Get kodea
     *
     * @return string
     */
    public function getKodea()
    {
        return $this->kodea;
    }

    /**
     * Set izenburuaeu
     *
     * @param string $izenburuaeu
     *
     * @return Ordenantza
     */
    public function setIzenburuaeu($izenburuaeu)
    {
        $this->izenburuaeu = $izenburuaeu;

        return $this;
    }

    /**
     * Get izenburuaeu
     *
     * @return string
     */
    public function getIzenburuaeu()
    {
        return $this->izenburuaeu;
    }

    /**
     * Set izenburuaes
     *
     * @param string $izenburuaes
     *
     * @return Ordenantza
     */
    public function setIzenburuaes($izenburuaes)
    {
        $this->izenburuaes = $izenburuaes;

        return $this;
    }

    /**
     * Get izenburuaes
     *
     * @return string
     */
    public function getIzenburuaes()
    {
        return $this->izenburuaes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ordenantza
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
     * @return Ordenantza
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
     * Add parrafoak
     *
     * @param \AppBundle\Entity\Ordenantzaparrafoa $parrafoak
     *
     * @return Ordenantza
     */
    public function addParrafoak(\AppBundle\Entity\Ordenantzaparrafoa $parrafoak)
    {
        $this->parrafoak[] = $parrafoak;

        return $this;
    }

    /**
     * Remove parrafoak
     *
     * @param \AppBundle\Entity\Ordenantzaparrafoa $parrafoak
     */
    public function removeParrafoak(\AppBundle\Entity\Ordenantzaparrafoa $parrafoak)
    {
        $this->parrafoak->removeElement($parrafoak);
    }

    /**
     * Get parrafoak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParrafoak()
    {
        return $this->parrafoak;
    }

    /**
     * Add atalak
     *
     * @param \AppBundle\Entity\Atala $atalak
     *
     * @return Ordenantza
     */
    public function addAtalak(\AppBundle\Entity\Atala $atalak)
    {
        $this->atalak[] = $atalak;

        return $this;
    }

    /**
     * Remove atalak
     *
     * @param \AppBundle\Entity\Atala $atalak
     */
    public function removeAtalak(\AppBundle\Entity\Atala $atalak)
    {
        $this->atalak->removeElement($atalak);
    }

    /**
     * Get atalak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAtalak()
    {
        return $this->atalak;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Ordenantza
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
