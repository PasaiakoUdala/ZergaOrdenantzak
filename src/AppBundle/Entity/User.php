<?php

    namespace AppBundle\Entity;

    use FOS\UserBundle\Model\User as BaseUser;
    use Doctrine\ORM\Mapping as ORM;
    use AppBundle\Annotation\UdalaEgiaztatu;

    /**
     * @ORM\Entity
     * @ORM\Table(
     *     name="fos_user",
     *     uniqueConstraints={@ORM\UniqueConstraint(columns={"username_canonical", "udala_id"})}
     * )
     * @UdalaEgiaztatu(userFieldName="udala_id")
     * @ORM\AttributeOverrides({
     *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
     *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true)),
     *      @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(type="string", name="username_canonical", length=255, unique=false, nullable=true))
     * })
     */
    class User extends BaseUser
    {

        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @var string
         * @ORM\Column(name="hizkuntza", type="string", length=15, nullable=true)
         */
        private $hizkuntza;

        /**
         * @var Udala
         * @ORM\ManyToOne(targetEntity="Udala")
         */
        private $udala;


        public function __construct()
        {
            parent::__construct();
            // your own logic
        }

    /**
     * Set udala
     *
     * @param \AppBundle\Entity\Udala $udala
     *
     * @return User
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
     * Set hizkuntza
     *
     * @param string $hizkuntza
     *
     * @return User
     */
    public function setHizkuntza($hizkuntza)
    {
        $this->hizkuntza = $hizkuntza;

        return $this;
    }

    /**
     * Get hizkuntza
     *
     * @return string
     */
    public function getHizkuntza()
    {
        return $this->hizkuntza;
    }
}
