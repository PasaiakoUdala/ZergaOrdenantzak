<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotation\UdalaEgiaztatu;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Eremumota
 *
 * @ORM\Table(name="eremumota")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Eremumota
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
     * @ORM\Column(name="motaeu", type="text", length=65535, nullable=true)
     */
    private $motaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="motaes", type="text", length=65535, nullable=true)
     */
    private $motaes;

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
    }

    public function __toString()
    {
        return $this->getMotaeu();
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
     * Set motaeu
     *
     * @param string $motaeu
     *
     * @return Eremumota
     */
    public function setMotaeu($motaeu)
    {
        $this->motaeu = $motaeu;

        return $this;
    }

    /**
     * Get motaeu
     *
     * @return string
     */
    public function getMotaeu()
    {
        return $this->motaeu;
    }

    /**
     * Set motaes
     *
     * @param string $motaes
     *
     * @return Eremumota
     */
    public function setMotaes($motaes)
    {
        $this->motaes = $motaes;

        return $this;
    }

    /**
     * Get motaes
     *
     * @return string
     */
    public function getMotaes()
    {
        return $this->motaes;
    }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return Eremumota
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
     * @return Eremumota
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
     * @return Eremumota
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
