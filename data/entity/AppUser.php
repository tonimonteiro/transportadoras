<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppUser
 *
 * @ORM\Table(name="app_user", uniqueConstraints={@ORM\UniqueConstraint(name="username", columns={"username"})}, indexes={@ORM\Index(name="fk_app_user_app_role1_idx", columns={"role_id"})})
 * @ORM\Entity
 */
class AppUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_in", type="datetime", nullable=true)
     */
    private $expireIn;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_by", type="string", length=45, nullable=false)
     */
    private $registeredBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registered_in", type="datetime", nullable=false)
     */
    private $registeredIn;

    /**
     * @var string
     *
     * @ORM\Column(name="modified_by", type="string", length=45, nullable=true)
     */
    private $modifiedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_in", type="datetime", nullable=true)
     */
    private $modifiedIn;

    /**
     * @var \AppRole
     *
     * @ORM\ManyToOne(targetEntity="AppRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;


}
