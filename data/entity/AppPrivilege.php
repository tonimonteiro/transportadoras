<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppPrivilege
 *
 * @ORM\Table(name="app_privilege", indexes={@ORM\Index(name="fk_app_role_has_app_navigation_app_navigation1_idx", columns={"app_navigation_id"}), @ORM\Index(name="fk_app_role_has_app_navigation_app_role1_idx", columns={"app_role_id"})})
 * @ORM\Entity
 */
class AppPrivilege
{
    /**
     * @var integer
     *
     * @ORM\Column(name="app_navigation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $appNavigationId;

    /**
     * @var \AppRole
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_role_id", referencedColumnName="id")
     * })
     */
    private $appRole;


}
