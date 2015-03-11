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
 * @category   Navigation
 * @package    SimNavigation\Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimNavigation\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimBase\Entity\AbstractEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use SimBase\Hydrator\Strategy\DateTimeStrategy;

/**
 * Navigation
 *
 * @ORM\Table(name="app_navigation", indexes={@ORM\Index(name="fk_app_navigation_app_navigation1_idx", columns={"parent_id"})})
 * @ORM\Entity(repositoryClass="SimNavigation\Entity\NavigationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Navigation extends AbstractEntity
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
     * @ORM\Column(name="name_group", type="string", length=10, nullable=false)
     */
    private $nameGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=45, nullable=true)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=45, nullable=true)
     */
    private $controller;

    /**
     * @var string
     *
     * @ORM\Column(name="name_action", type="string", length=45, nullable=true)
     */
    private $nameAction;

    /**
     * @var string
     *
     * @ORM\Column(name="resource", type="string", length=125, nullable=true)
     */
    private $resource;

    /**
     * @var string
     *
     * @ORM\Column(name="privilege", type="string", length=45, nullable=true)
     */
    private $privilege;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=45, nullable=true)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="fragment", type="string", length=45, nullable=true)
     */
    private $fragment;

    /**
     * @var string
     *
     * @ORM\Column(name="identification", type="string", length=45, nullable=true)
     */
    private $identification;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=45, nullable=true)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=45, nullable=true)
     */
    private $target;

    /**
     * @var string
     *
     * @ORM\Column(name="rel", type="string", length=45, nullable=true)
     */
    private $rel;

    /**
     * @var string
     *
     * @ORM\Column(name="rev", type="string", length=45, nullable=true)
     */
    private $rev;

    /**
     * @var string
     *
     * @ORM\Column(name="number_order", type="string", length=3, nullable=true)
     */
    private $numberOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="visible", type="integer", nullable=true)
     */
    private $visible;

    /**
     * @var string
     *
     * @ORM\Column(name="params", type="string", length=255, nullable=true)
     */
    private $params;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_by", type="string", length=45, nullable=true)
     */
    private $registeredBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registered_in", type="datetime", nullable=true)
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
     * @var \Navigation
     *
     * @ORM\ManyToOne(targetEntity="SimNavigation\Entity\Navigation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SimAcl\Entity\Role", mappedBy="navigation")
     */
    private $role;

    /**
     * Construct.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();

        $hydrator = new ClassMethods();
        $hydrator->addStrategy('registered_in', new DateTimeStrategy());
        $hydrator->addStrategy('modified_in', new DateTimeStrategy());
        $hydrator->hydrate($options, $this);

        if (empty($options['registeredBy'])) {
        	$this->registeredBy = $this->getSession('SimUserEntityUser')->getName();
        }

        if (empty($options['modifiedBy'])) {
        	$this->modifiedBy = $this->getSession('SimUserEntityUser')->getName();
        }

        $this->registeredIn = new \DateTime("now");
        $this->modifiedIn = new \DateTime("now");
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return the $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Gets the $nameGroup.
     *
     * @return string
     */
    public function getNameGroup()
    {
        return $this->nameGroup;
    }

	/**
     * Sets the $nameGroup.
     *
     * @param string $nameGroup
     */
    public function setNameGroup($nameGroup)
    {
        $this->nameGroup = $nameGroup;
        return $this;
    }

	/**
     * Gets the $nameAction.
     *
     * @return string
     */
    public function getNameAction()
    {
        return $this->nameAction;
    }

	/**
     * Sets the $nameAction.
     *
     * @param string $nameAction
     */
    public function setNameAction($nameAction)
    {
        $this->nameAction = empty($nameAction) ? NULL : $nameAction;
        return $this;
    }

	/**
     * Gets the $numberOrder.
     *
     * @return string
     */
    public function getNumberOrder()
    {
        return $this->numberOrder;
    }

	/**
     * Sets the $numberOrder.
     *
     * @param string $numberOrder
     */
    public function setNumberOrder($numberOrder)
    {
        $this->numberOrder = $numberOrder;
        return $this;
    }

	/**
     *
     * @return the $fragment
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     *
     * @param string $fragment
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     *
     * @return the $identification
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     *
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
        return $this;
    }

    /**
     *
     * @return the $class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     *
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return the $target
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     *
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     *
     * @return the $rel
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     *
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     *
     * @return the $rev
     */
    public function getRev()
    {
        return $this->rev;
    }

    /**
     *
     * @param string $rev
     */
    public function setRev($rev)
    {
        $this->rev = $rev;
        return $this;
    }

    /**
     *
     * @return the $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     *
     * @param number $active
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     *
     * @return the $visible
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     *
     * @param number $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     *
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * TODO: refatorar
     * @return the $controller
     */
    public function getControllerName()
    {
        $controller = explode('-', $this->controller);
        $controllerName = '';
        foreach($controller as $key => $name) {
        	$controllerName .= ucfirst($name);
        }
        if (! $controllerName) {
        	$controllerName = ucfirst($this->controller);
        }
        return $controllerName;
    }

    /**
     *
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = empty($controller) ? NULL : $controller;
        return $this;
    }

    /**
     *
     * @return the $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     *
     * @param string $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     *
     * @return the $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     *
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return the $resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    public function getResourceNamespace()
    {
        return $this->resource . '\\Controller\\' . $this->getControllerName();
    }

	/**
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = empty($resource) ? NULL : $resource;
        return $this;
    }

	/**
     *
     * @return the $uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     *
     * @return the $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     *
     * @param $parent
     * @return object $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     *
     * @return the $privilege
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     *
     * @param Privilege $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    /**
     *
     * @return the $registeredBy
     */
    public function getRegisteredBy()
    {
        return $this->registeredBy;
    }

    /**
     *
     * @param string $registeredBy
     */
    public function setRegisteredBy($registeredBy)
    {
    	if (empty($registeredBy)) {
    		$registeredBy = $this->getSession('SimUserEntityUser')->getName();
    	}
    	$this->registeredBy = $registeredBy;
    	return $this;
    }

    /**
     *
     * @return the $registeredIn
     */
    public function getRegisteredIn()
    {
        return $this->registeredIn;
    }

    /**
     *
     * @param DateTime $registeredIn
     */
    public function setRegisteredIn($registeredIn)
    {
        if (empty($registeredIn)) {
            $registeredIn = new \DateTime("now");
        }
        $this->registeredIn = $registeredIn;
        return $this;
    }

    /**
     *
     * @return the $modifiedBy
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param string $modifiedBy
     */
    public function setModifiedBy($modifiedBy)
    {
    	$modifiedBy = $this->getSession('SimUserEntityUser')->getName();
    	$this->modifiedBy = $modifiedBy;
    	return $this;
    }

    /**
     *
     * @return the $modifiedIn
     */
    public function getModifiedIn()
    {
        return $this->modifiedIn;
    }

    /**
     *
     *
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param DateTime $modifiedIn
     */
    public function setModifiedIn()
    {
        $this->modifiedIn = new \DateTime("now");

        return $this;
    }

    /**
     * Gets the $role.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole()
    {
        return $this->role;
    }

	/**
     * Sets the $role.
     *
     * @param \Doctrine\Common\Collections\Collection $role
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

	/**
     * Get array copy.
     *
     * @return multitype:
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('registered_in', new DateTimeStrategy());
        $hydrator->addStrategy('modified_in', new DateTimeStrategy());

        $objectVars = $this->prepare($hydrator->extract($this));

        if (! empty($this->getParent())) {
            $objectVars['parent'] = $this->getParent()->getId();
        }

//         if (! empty($this->getRole())) {
//             /* @var $this->getRole() SimAcl\Entity\Role */
//             $objectVars['role'] = $this->getRole()->toArray();
//         }
        return $objectVars;
    }
}
