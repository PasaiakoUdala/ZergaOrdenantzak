<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Azpiatala
 *
 * @ORM\Table(name="azpiatala", indexes={@ORM\Index(name="atala_id_idx", columns={"atala_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Azpiatala
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @Expose
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="kodea", type="string", length=9, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="kodea_prod", type="string", length=9, nullable=true)
     */
    private $kodea_prod;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="izenburuaeu", type="text", length=65535, nullable=true)
     */
    private $izenburuaeu;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="izenburuaeu_prod", type="text", length=65535, nullable=true)
     */
    private $izenburuaeu_prod;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="izenburuaes", type="text", length=65535, nullable=true)
     */
    private $izenburuaes;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="izenburuaes_prod", type="text", length=65535, nullable=true)
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
     * @var \Atala
     *
     * @ORM\ManyToOne(targetEntity="Atala",inversedBy="azpiatalak")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="atala_id", referencedColumnName="id")
     * })
     */
    private $atala;

    /**
     * @var Azpiatalaparrafoa
     * @expose
     * @ORM\OneToMany(targetEntity="Azpiatalaparrafoa", mappedBy="azpiatala", cascade={"remove"})
     * @ORM\OrderBy({"ordena" = "ASC"})
     */
    protected $parrafoak;

    /**
     * @var Kontzeptua
     * @Expose
     * @ORM\OneToMany(targetEntity="Kontzeptua", mappedBy="azpiatala", cascade={"remove"})
     */
    protected $kontzeptuak;

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
        return $this->getIzenburuaeu();
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
     * @return Azpiatala
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
     * @return Azpiatala
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
     * @return Azpiatala
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
     * @return Azpiatala
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
     * @return Azpiatala
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
     * @return Azpiatala
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
     * Add parrafoak
     *
     * @param \AppBundle\Entity\Azpiatalaparrafoa $parrafoak
     *
     * @return Azpiatala
     */
    public function addParrafoak(\AppBundle\Entity\Azpiatalaparrafoa $parrafoak)
    {
        $this->parrafoak[] = $parrafoak;

        return $this;
    }

    /**
     * Remove parrafoak
     *
     * @param \AppBundle\Entity\Azpiatalaparrafoa $parrafoak
     */
    public function removeParrafoak(\AppBundle\Entity\Azpiatalaparrafoa $parrafoak)
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
     * Add kontzeptuak
     *
     * @param \AppBundle\Entity\Kontzeptua $kontzeptuak
     *
     * @return Azpiatala
     */
    public function addKontzeptuak(\AppBundle\Entity\Kontzeptua $kontzeptuak)
    {
        $this->kontzeptuak[] = $kontzeptuak;

        return $this;
    }

    /**
     * Remove kontzeptuak
     *
     * @param \AppBundle\Entity\Kontzeptua $kontzeptuak
     */
    public function removeKontzeptuak(\AppBundle\Entity\Kontzeptua $kontzeptuak)
    {
        $this->kontzeptuak->removeElement($kontzeptuak);
    }

    /**
     * Get kontzeptuak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKontzeptuak()
    {
        return $this->kontzeptuak;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Azpiatala
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
     * Set kodeaProd
     *
     * @param string $kodeaProd
     *
     * @return Azpiatala
     */
    public function setKodeaProd($kodeaProd)
    {
        $this->kodea_prod = $kodeaProd;

        return $this;
    }

    /**
     * Get kodeaProd
     *
     * @return string
     */
    public function getKodeaProd()
    {
        return $this->kodea_prod;
    }

    /**
     * Set izenburuaeuProd
     *
     * @param string $izenburuaeuProd
     *
     * @return Azpiatala
     */
    public function setIzenburuaeuProd($izenburuaeuProd)
    {
        $this->izenburuaeu_prod = $izenburuaeuProd;

        return $this;
    }

    /**
     * Get izenburuaeuProd
     *
     * @return string
     */
    public function getIzenburuaeuProd()
    {
        return $this->izenburuaeu_prod;
    }

    /**
     * Set izenburuaesProd
     *
     * @param string $izenburuaesProd
     *
     * @return Azpiatala
     */
    public function setIzenburuaesProd($izenburuaesProd)
    {
        $this->izenburuaes_prod = $izenburuaesProd;

        return $this;
    }

    /**
     * Get izenburuaesProd
     *
     * @return string
     */
    public function getIzenburuaesProd()
    {
        return $this->izenburuaes_prod;
    }

    /**
     * Set ezabatu
     *
     * @param boolean $ezabatu
     *
     * @return Azpiatala
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
