<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Historikoa
 *
 * @ORM\Table(name="historikoa")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Historikoa
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
     * @var \DateTime
     *
     * @ORM\Column(name="onartzedata", type="date", nullable=true)
     */
    private $onartzedata;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bogargitaratzedata", type="date", nullable=true)
     */
    private $bogargitaratzedata;

    /**
     * @var string
     *
     * @ORM\Column(name="$bogargitaratzedatatestua", type="string", length=255, nullable=true)
     */
    private $bogargitaratzedatatestua;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bogbehinbetikodata", type="date", nullable=true)
     */
    private $bogbehinbetikodata;

    /**
     * @var string
     *
     * @ORM\Column(name="bogestekaeu", type="string", length=255, nullable=true)
     */
    private $bogestekaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="bogestekaes", type="string", length=255, nullable=true)
     */
    private $bogestekaes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="indarreandata", type="date", nullable=true)
     */
    private $indarreandata;

    /**
     * @var string
     *
     * @ORM\Column(name="aldaketakeu", type="text", length=65535, nullable=true)
     */
    private $aldaketakeu;

    /**
     * @var string
     *
     * @ORM\Column(name="aldaketakes", type="text", length=65535, nullable=true)
     */
    private $aldaketakes;

    /**
     * @var string
     *
     * @ORM\Column(name="fitxategia", type="string", length=255, nullable=true)
     */
    private $fitxategia;

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
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * @var Udala
     * @ORM\ManyToOne(targetEntity="Udala")
     */
    private $udala;

    public function __construct()
    {
        $this->createdAt = New \DateTime();
        $this->updatedAt = New \DateTime();
    }

    public function __toString()
    {
        return $this->getOnartzedata()->format("Y-m-d");
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
     * Set onartzedata
     *
     * @param \DateTime $onartzedata
     *
     * @return Historikoa
     */
    public function setOnartzedata($onartzedata)
    {
        $this->onartzedata = $onartzedata;

        return $this;
    }

    /**
     * Get onartzedata
     *
     * @return \DateTime
     */
    public function getOnartzedata()
    {
        return $this->onartzedata;
    }

    /**
     * Set bogargitaratzedata
     *
     * @param \DateTime $bogargitaratzedata
     *
     * @return Historikoa
     */
    public function setBogargitaratzedata($bogargitaratzedata)
    {
        $this->bogargitaratzedata = $bogargitaratzedata;

        return $this;
    }

    /**
     * Get bogargitaratzedata
     *
     * @return \DateTime
     */
    public function getBogargitaratzedata()
    {
        return $this->bogargitaratzedata;
    }

    /**
     * Set bogbehinbetikodata
     *
     * @param \DateTime $bogbehinbetikodata
     *
     * @return Historikoa
     */
    public function setBogbehinbetikodata($bogbehinbetikodata)
    {
        $this->bogbehinbetikodata = $bogbehinbetikodata;

        return $this;
    }

    /**
     * Get bogbehinbetikodata
     *
     * @return \DateTime
     */
    public function getBogbehinbetikodata()
    {
        return $this->bogbehinbetikodata;
    }

    /**
     * Set bogestekaeu
     *
     * @param string $bogestekaeu
     *
     * @return Historikoa
     */
    public function setBogestekaeu($bogestekaeu)
    {
        $this->bogestekaeu = $bogestekaeu;

        return $this;
    }

    /**
     * Get bogestekaeu
     *
     * @return string
     */
    public function getBogestekaeu()
    {
        return $this->bogestekaeu;
    }

    /**
     * Set bogestekaes
     *
     * @param string $bogestekaes
     *
     * @return Historikoa
     */
    public function setBogestekaes($bogestekaes)
    {
        $this->bogestekaes = $bogestekaes;

        return $this;
    }

    /**
     * Get bogestekaes
     *
     * @return string
     */
    public function getBogestekaes()
    {
        return $this->bogestekaes;
    }

    /**
     * Set indarreandata
     *
     * @param \DateTime $indarreandata
     *
     * @return Historikoa
     */
    public function setIndarreandata($indarreandata)
    {
        $this->indarreandata = $indarreandata;

        return $this;
    }

    /**
     * Get indarreandata
     *
     * @return \DateTime
     */
    public function getIndarreandata()
    {
        return $this->indarreandata;
    }

    /**
     * Set aldaketakeu
     *
     * @param string $aldaketakeu
     *
     * @return Historikoa
     */
    public function setAldaketakeu($aldaketakeu)
    {
        $this->aldaketakeu = $aldaketakeu;

        return $this;
    }

    /**
     * Get aldaketakeu
     *
     * @return string
     */
    public function getAldaketakeu()
    {
        return $this->aldaketakeu;
    }

    /**
     * Set aldaketakes
     *
     * @param string $aldaketakes
     *
     * @return Historikoa
     */
    public function setAldaketakes($aldaketakes)
    {
        $this->aldaketakes = $aldaketakes;

        return $this;
    }

    /**
     * Get aldaketakes
     *
     * @return string
     */
    public function getAldaketakes()
    {
        return $this->aldaketakes;
    }

    /**
     * Set fitxategia
     *
     * @param string $fitxategia
     *
     * @return Historikoa
     */
    public function setFitxategia($fitxategia)
    {
        $this->fitxategia = $fitxategia;

        return $this;
    }

    /**
     * Get fitxategia
     *
     * @return string
     */
    public function getFitxategia()
    {
        return $this->fitxategia;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Historikoa
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
     * @return Historikoa
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
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Historikoa
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
     * Set bogargitaratzedatatestua
     *
     * @param string $bogargitaratzedatatestua
     *
     * @return Historikoa
     */
    public function setBogargitaratzedatatestua($bogargitaratzedatatestua)
    {
        $this->bogargitaratzedatatestua = $bogargitaratzedatatestua;

        return $this;
    }

    /**
     * Get bogargitaratzedatatestua
     *
     * @return string
     */
    public function getBogargitaratzedatatestua()
    {
        return $this->bogargitaratzedatatestua;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Historikoa
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Historikoa
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
     * @return Historikoa
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
