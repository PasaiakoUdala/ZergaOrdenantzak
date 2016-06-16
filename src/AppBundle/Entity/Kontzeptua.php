<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kontzeptua
 *
 * @ORM\Table(name="kontzeptua", indexes={@ORM\Index(name="azpiatala_id_idx", columns={"azpiatala_id"}), @ORM\Index(name="baldintza_id_idx", columns={"baldintza_id"}), @ORM\Index(name="kontzeptumota_id_idx", columns={"kontzeptumota_id"})})
 * @ORM\Entity
 */
class Kontzeptua
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
     * @ORM\Column(name="kontzeptuaeu", type="text", length=65535, nullable=true)
     */
    private $kontzeptuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="kontzeptuaes", type="text", length=65535, nullable=true)
     */
    private $kontzeptuaes;

    /**
     * @var string
     *
     * @ORM\Column(name="kopurua", type="string", length=50, nullable=true)
     */
    private $kopurua;

    /**
     * @var string
     *
     * @ORM\Column(name="unitatea", type="string", length=50, nullable=true)
     */
    private $unitatea;

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
     * @ORM\ManyToOne(targetEntity="Azpiatala")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="azpiatala_id", referencedColumnName="id")
     * })
     */
    private $azpiatala;

    /**
     * @var \Baldintza
     *
     * @ORM\ManyToOne(targetEntity="Baldintza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="baldintza_id", referencedColumnName="id")
     * })
     */
    private $baldintza;

    /**
     * @var \Kontzeptumota
     *
     * @ORM\ManyToOne(targetEntity="Kontzeptumota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kontzeptumota_id", referencedColumnName="id")
     * })
     */
    private $kontzeptumota;

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
     * @return Kontzeptua
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
     * Set kontzeptuaeu
     *
     * @param string $kontzeptuaeu
     *
     * @return Kontzeptua
     */
    public function setKontzeptuaeu($kontzeptuaeu)
    {
        $this->kontzeptuaeu = $kontzeptuaeu;

        return $this;
    }

    /**
     * Get kontzeptuaeu
     *
     * @return string
     */
    public function getKontzeptuaeu()
    {
        return $this->kontzeptuaeu;
    }

    /**
     * Set kontzeptuaes
     *
     * @param string $kontzeptuaes
     *
     * @return Kontzeptua
     */
    public function setKontzeptuaes($kontzeptuaes)
    {
        $this->kontzeptuaes = $kontzeptuaes;

        return $this;
    }

    /**
     * Get kontzeptuaes
     *
     * @return string
     */
    public function getKontzeptuaes()
    {
        return $this->kontzeptuaes;
    }

    /**
     * Set kopurua
     *
     * @param string $kopurua
     *
     * @return Kontzeptua
     */
    public function setKopurua($kopurua)
    {
        $this->kopurua = $kopurua;

        return $this;
    }

    /**
     * Get kopurua
     *
     * @return string
     */
    public function getKopurua()
    {
        return $this->kopurua;
    }

    /**
     * Set unitatea
     *
     * @param string $unitatea
     *
     * @return Kontzeptua
     */
    public function setUnitatea($unitatea)
    {
        $this->unitatea = $unitatea;

        return $this;
    }

    /**
     * Get unitatea
     *
     * @return string
     */
    public function getUnitatea()
    {
        return $this->unitatea;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Kontzeptua
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
     * @return Kontzeptua
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
     * @return Kontzeptua
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
     * Set baldintza
     *
     * @param \AppBundle\Entity\Baldintza $baldintza
     *
     * @return Kontzeptua
     */
    public function setBaldintza(\AppBundle\Entity\Baldintza $baldintza = null)
    {
        $this->baldintza = $baldintza;

        return $this;
    }

    /**
     * Get baldintza
     *
     * @return \AppBundle\Entity\Baldintza
     */
    public function getBaldintza()
    {
        return $this->baldintza;
    }

    /**
     * Set kontzeptumota
     *
     * @param \AppBundle\Entity\Kontzeptumota $kontzeptumota
     *
     * @return Kontzeptua
     */
    public function setKontzeptumota(\AppBundle\Entity\Kontzeptumota $kontzeptumota = null)
    {
        $this->kontzeptumota = $kontzeptumota;

        return $this;
    }

    /**
     * Get kontzeptumota
     *
     * @return \AppBundle\Entity\Kontzeptumota
     */
    public function getKontzeptumota()
    {
        return $this->kontzeptumota;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Kontzeptua
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
