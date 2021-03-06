<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Baldintza
 *
 * @ORM\Table(name="baldintza")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Baldintza {

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
   * @ORM\Column(name="origenid", type="bigint", nullable=true)
   */
  private $origenid;

  /**
   * @var string
   *
   * @ORM\Column(name="baldintzaeu", type="text", length=65535, nullable=true)
   */
  private $baldintzaeu;

  /**
   * @var string
   *
   * @ORM\Column(name="baldintzaes", type="text", length=65535, nullable=true)
   */
  private $baldintzaes;

  /**
   * @var string $createdBy
   *
   * @Gedmo\Blameable(on="create")
   * @ORM\Column(nullable=true)
   */
  private $createdBy;

  /**
   * @var string $updatedBy
   *
   * @Gedmo\Blameable(on="update")
   * @ORM\Column(nullable=true)
   */
  private $updatedBy;

  /**
   * ************************************************************************************************************************************************************************
   * ************************************************************************************************************************************************************************
   * ***** ERLAZIOAK
   * ************************************************************************************************************************************************************************
   * ************************************************************************************************************************************************************************
   */
//
//  /**
//   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Kontzeptua", mappedBy="baldintza", cascade={"remove"}, orphanRemoval=true)
//   * @ORM\OrderBy({"ordena" = "ASC"})
//   */
//  protected $kontzeptuak;

  /**
   * @var Udala
   * @ORM\ManyToOne(targetEntity="Udala")
   */
  private $udala;

  public function __construct()
  {
  }

  public function __toString()
  {
    return $this->getBaldintzaeu();
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
   * Set baldintzaeu
   *
   * @param string $baldintzaeu
   *
   * @return Baldintza
   */
  public function setBaldintzaeu($baldintzaeu)
  {
    $this->baldintzaeu = $baldintzaeu;

    return $this;
  }

  /**
   * Get baldintzaeu
   *
   * @return string
   */
  public function getBaldintzaeu()
  {
    return $this->baldintzaeu;
  }

  /**
   * Set baldintzaes
   *
   * @param string $baldintzaes
   *
   * @return Baldintza
   */
  public function setBaldintzaes($baldintzaes)
  {
    $this->baldintzaes = $baldintzaes;

    return $this;
  }

  /**
   * Get baldintzaes
   *
   * @return string
   */
  public function getBaldintzaes()
  {
    return $this->baldintzaes;
  }

  /**
   * Set udala
   *
   * @param \AppBundle\Entity\Udala $udala
   *
   * @return Baldintza
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
   * Set createdBy
   *
   * @param string $createdBy
   *
   * @return Baldintza
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
   * @return Baldintza
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

    /**
     * Set origenid
     *
     * @param integer $origenid
     *
     * @return Baldintza
     */
    public function setOrigenid($origenid)
    {
        $this->origenid = $origenid;

        return $this;
    }

    /**
     * Get origenid
     *
     * @return integer
     */
    public function getOrigenid()
    {
        return $this->origenid;
    }

    /**
     * Add kontzeptuak
     *
     * @param \AppBundle\Entity\Kontzeptua $kontzeptuak
     *
     * @return Baldintza
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
}
