<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppRole
 *
 * @ORM\Table(name="app_role", indexes={@ORM\Index(name="fk_app_roles_app_roles1_idx", columns={"role_id"})})
 * @ORM\Entity
 */
class AppRole
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
     * @var integer
     *
     * @ORM\Column(name="is_admin", type="integer", nullable=true)
     */
    private $isAdmin = '2';

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
