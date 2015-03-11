<?php
/**
 * Sim Tecnologia Application
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.simtecnologia.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Role.php
 * @package    SimAcl\Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */

namespace SimAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="app_role", indexes={@ORM\Index(name="fk_app_roles_app_roles1_idx", columns={"role_id"})})
 * @ORM\Entity(repositoryClass="SimAcl\Entity\RoleRepository")
 */
class Role
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", name="is_admin")
     *
     * @var integer
     */
    protected $isAdmin;

    /**
     *
     * @var string @ORM\Column(name="registered_by", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $registeredBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="registered_in", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $registeredIn;

    /**
     *
     * @var string @ORM\Column(name="modified_by", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $modifiedBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_in", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $modifiedIn;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SimNavigation\Entity\Navigation", inversedBy="role")
     * @ORM\JoinTable(name="app_privilege",
     *   joinColumns={
     *     @ORM\JoinColumn(name="app_role_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="app_navigation_id", referencedColumnName="id")
     *   }
     * )
     */
    private $navigation;

    /**
     * Construct users.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->navigation = new \Doctrine\Common\Collections\ArrayCollection();

        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);

        $this->registeredIn = new \DateTime("now");
        $this->registeredBy = 'SessionName';

        $this->modifiedIn = new \DateTime("now");
        $this->modifiedBy = 'SessionName';
    }

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
     * @return the $isAdmin
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

	/**
     * @param boolean $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * Set registeredBy
     *
     * @param string $registeredBy
     * @return User
     */
    public function setRegisteredBy()
    {
        $this->registeredBy = 'SessionName';

        return $this;
    }

    /**
     * Get registeredBy
     *
     * @return string
     */
    public function getRegisteredBy()
    {
        return $this->registeredBy;
    }

    /**
     * Set registeredIn
     *
     * @param \DateTime $registeredIn
     * @return User
     */
    public function setRegisteredIn()
    {
        $this->registeredIn = new \DateTime("now");

        return $this;
    }

    /**
     * Get registeredIn
     *
     * @return \DateTime
     */
    public function getRegisteredIn()
    {
        return $this->registeredIn;
    }

    /**
     * Set modifiedBy
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param string $modifiedBy
     * @return User
     */
    public function setModifiedBy()
    {
        $this->modifiedBy = 'SessionName';
        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setModifiedIn()
    {
        $this->modifiedIn = new \DateTime("now");
        return $this;
    }

    /**
     * Get modifiedIn
     *
     * @return \DateTime
     */
    public function getModifiedIn()
    {
        return $this->modifiedIn;
    }

    /**
     * Gets the $role.
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

	/**
     * Sets the $role.
     *
     * @param Role $role
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

	/**
     * Sets the $navigation.
     *
     * @param \Doctrine\Common\Collections\Collection $navigation
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;
        return $this;
    }

    /**
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     *
     * @return array
     */
    public function getNavigationList()
    {
            if (! empty($this->navigation)) {
        	return $this->navigation->toArray();
        }
    	return array();
    }

    public function addNavigation(ArrayCollection $navigation)
    {
        foreach ($navigation as $nav) {
            if (!$this->navigation->contains($navigation)) {
                $this->navigation->add($nav);
            }
        }

        return $this;
    }

    public function removeNavigation(ArrayCollection $navigation)
    {
        foreach ($navigation as $nav) {
            if ($this->navigation->contains($nav)) {
                $this->navigation->removeElement($nav);
            }
        }

        return $this;
    }

	/**
     * @return string
     */
    public function __toString()
    {
    	return $this->name;
    }

    /**
     * Get array copy.
     *
     * @return multitype:
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();

        $objectVars = $hydrator->extract($this);

        $objectVars['isAdmin'] = $this->getIsAdmin();
        if ($this->getRole()) {
            $objectVars['role'] = $this->getRole()->getId();
        }

        return $objectVars;
    }
}
