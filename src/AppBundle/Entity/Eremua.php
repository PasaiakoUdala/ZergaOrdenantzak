<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Eremua
 *
 * @ORM\Table(name="eremua", indexes={@ORM\Index(name="eremumota_id_idx", columns={"eremumota_id"}), @ORM\Index(name="formula_id_idx", columns={"formula_id"})})
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Eremua
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
     * @ORM\Column(name="izena", type="text", length=65535, nullable=true)
     */
    private $izena;

    /**
     * @var string
     *
     * @ORM\Column(name="etiketaeu", type="text", length=65535, nullable=true)
     */
    private $etiketaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="etiketaes", type="text", length=65535, nullable=true)
     */
    private $etiketaes;

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
     * @var \Eremumota
     *
     * @ORM\ManyToOne(targetEntity="Eremumota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eremumota_id", referencedColumnName="id")
     * })
     */
    private $eremumota;

    /**
     * @var \Formula
     *
     * @ORM\ManyToOne(targetEntity="Formula")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formula_id", referencedColumnName="id")
     * })
     */
    private $formula;

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
        return $this->getIzena();
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
     * Set izena
     *
     * @param string $izena
     *
     * @return Eremua
     */
    public function setIzena($izena)
    {
        $this->izena = $izena;

        return $this;
    }

    /**
     * Get izena
     *
     * @return string
     */
    public function getIzena()
    {
        return $this->izena;
    }

    /**
     * Set etiketaeu
     *
     * @param string $etiketaeu
     *
     * @return Eremua
     */
    public function setEtiketaeu($etiketaeu)
    {
        $this->etiketaeu = $etiketaeu;

        return $this;
    }

    /**
     * Get etiketaeu
     *
     * @return string
     */
    public function getEtiketaeu()
    {
        return $this->etiketaeu;
    }

    /**
     * Set etiketaes
     *
     * @param string $etiketaes
     *
     * @return Eremua
     */
    public function setEtiketaes($etiketaes)
    {
        $this->etiketaes = $etiketaes;

        return $this;
    }

    /**
     * Get etiketaes
     *
     * @return string
     */
    public function getEtiketaes()
    {
        return $this->etiketaes;
    }

    /**
     * Set eremumota
     *
     * @param \AppBundle\Entity\Eremumota $eremumota
     *
     * @return Eremua
     */
    public function setEremumota(\AppBundle\Entity\Eremumota $eremumota = null)
    {
        $this->eremumota = $eremumota;

        return $this;
    }

    /**
     * Get eremumota
     *
     * @return \AppBundle\Entity\Eremumota
     */
    public function getEremumota()
    {
        return $this->eremumota;
    }

    /**
     * Set formula
     *
     * @param \AppBundle\Entity\Formula $formula
     *
     * @return Eremua
     */
    public function setFormula(\AppBundle\Entity\Formula $formula = null)
    {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return \AppBundle\Entity\Formula
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Eremua
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
     * @return Eremua
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
     * @return Eremua
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
