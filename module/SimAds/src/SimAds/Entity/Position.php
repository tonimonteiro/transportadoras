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
 * @category   Position.php
 * @package    Entity
 * @subpackage IndexController
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAds\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator\ClassMethods;
use SimBase\Hydrator\Strategy\DateTimeStrategy;
use SimBase\Entity\AbstractEntity;

/**
 * AdsPosition
 *
 * @ORM\Table(name="ads_position")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Position extends AbstractEntity
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var integer @ORM\Column(name="active", type="integer", nullable=false)
     */
    private $active = '1';

    /**
     *
     * @var string @ORM\Column(name="registered_by", type="string", length=45, nullable=false)
     */
    private $registeredBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="registered_in", type="datetime", nullable=false)
     */
    private $registeredIn;

    /**
     *
     * @var string @ORM\Column(name="modified_by", type="string", length=45, nullable=true)
     */
    private $modifiedBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_in", type="datetime", nullable=true)
     */
    private $modifiedIn;

    /**
     * Construct.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('registered_in', new DateTimeStrategy());
        $hydrator->addStrategy('modified_in', new DateTimeStrategy());
        $hydrator->hydrate($options, $this);

        // TODO Colocar o session do usuário logado
        $this->registeredBy = 'SessionName';
        $this->registeredIn = new \DateTime("now");
        // TODO Colocar o session do usuário logado
        $this->modifiedBy = 'SessionName';
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
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
        // TODO Colocar o session do usuário logado
        if (empty($registeredBy)) {
            $registeredBy = 'SessionName';
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
     *
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param string $modifiedBy
     */
    public function setModifiedBy($modifiedBy)
    {
        // TODO Colocar o session do usuário logado
        $this->modifiedBy = 'SessionName';
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
        ;
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
        return $objectVars;
    }
}
