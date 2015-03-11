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
 * @category   Media.php
 * @package    Entity
 * @subpackage IndexController
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAds\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimBase\Entity\AbstractEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use SimBase\Hydrator\Strategy\DateTimeStrategy;

/**
 * AdsMedia
 *
 * @ORM\Table(name="ads_media", indexes={@ORM\Index(name="fk_ads_media_ads_position1_idx", columns={"position_id"})})
 * @ORM\Entity(repositoryClass="SimAds\Entity\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media extends AbstractEntity
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=false)
     */
    private $active = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="url_destination", type="string", length=255, nullable=true)
     */
    private $urlDestination;

    /**
     * @var string
     *
     * @ORM\Column(name="external_code", type="string", length=255, nullable=true)
     */
    private $externalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="media_file", type="string", length=255, nullable=true)
     */
    private $mediaFile;

    /**
     * @var string
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entry", type="datetime", nullable=false)
     */
    private $dateEntry;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_out", type="datetime", nullable=true)
     */
    private $dateOut;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_view", type="integer", nullable=true)
     */
    private $limitView;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_click", type="integer", nullable=true)
     */
    private $limitClick;

    /**
     * @var integer
     *
     * @ORM\Column(name="view", type="integer", nullable=false)
     */
    private $view = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="click", type="integer", nullable=false)
     */
    private $click;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_by", type="integer", nullable=false)
     */
    private $orderBy;

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
     * @var \Position
     *
     * @ORM\ManyToOne(targetEntity="Position")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * })
     */
    private $position;

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
        $hydrator->addStrategy('date_entry', new DateTimeStrategy());
        $hydrator->addStrategy('date_out', new DateTimeStrategy());
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
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param number $id
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
     * Gets the $description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

	/**
     * Sets the $description.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

	/**
     * @return the $active
     */
    public function getActive()
    {
        return $this->active;
    }

	/**
     * @param number $active
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

	/**
     * @return the $urlDestination
     */
    public function getUrlDestination()
    {
        return $this->urlDestination;
    }

	/**
     * @param string $urlDestination
     */
    public function setUrlDestination($urlDestination)
    {
        $this->urlDestination = $urlDestination;
        return $this;
    }

	/**
     * @return the $externalCode
     */
    public function getExternalCode()
    {
        return $this->externalCode;
    }

	/**
     * @param string $externalCode
     */
    public function setExternalCode($externalCode)
    {
        $this->externalCode = $externalCode;
        return $this;
    }

	/**
     * @return the $mediaName
     */
    public function getMediaFile()
    {
        return $this->mediaFile;
    }

	/**
     * @param string $mediaName
     */
    public function setMediaFile($mediaFile)
    {
        $this->mediaFile = $mediaFile;
        return $this;
    }

	/**
     * @return the $cost
     */
    public function getCost()
    {
        return $this->cost;
    }

	/**
     * @param string $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

	/**
     * @return the $dateEntry
     */
    public function getDateEntry()
    {
        return $this->dateEntry;
    }

	/**
     * @param DateTime $dateEntry
     */
    public function setDateEntry($dateEntry)
    {
        $this->dateEntry = $dateEntry;
        return $this;
    }

	/**
     * @return the $dateOut
     */
    public function getDateOut()
    {
        return $this->dateOut;
    }

	/**
     * @param DateTime $dateOut
     */
    public function setDateOut($dateOut)
    {
        $this->dateOut = $dateOut;
        return $this;
    }

	/**
     * @return the $limitView
     */
    public function getLimitView()
    {
        return $this->limitView;
    }

	/**
     * @param number $limitView
     */
    public function setLimitView($limitView)
    {
        $this->limitView = $limitView;
        return $this;
    }

	/**
     * @return the $limitClick
     */
    public function getLimitClick()
    {
        return $this->limitClick;
    }

	/**
     * @param number $limitClick
     */
    public function setLimitClick($limitClick)
    {
        $this->limitClick = $limitClick;
        return $this;
    }

	/**
     * @return the $view
     */
    public function getView()
    {
        return $this->view;
    }

	/**
     * @param number $view
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

	/**
     * @return the $click
     */
    public function getClick()
    {
        return $this->click;
    }

	/**
     * @param number $click
     */
    public function setClick($click)
    {
        $this->click = $click;
        return $this;
    }

	/**
     * Gets the $orderBy.
     *
     * @return number
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

	/**
     * Sets the $orderBy.
     *
     * @param number $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

	/**
     * @return the $position
     */
    public function getPosition()
    {
        return $this->position;
    }

	/**
     * @param Position $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
     * Get array copy.
     *
     * @return multitype:
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('registered_in', new DateTimeStrategy());
        $hydrator->addStrategy('modified_in', new DateTimeStrategy());
        $hydrator->addStrategy('date_entry', new DateTimeStrategy());
        $hydrator->addStrategy('date_out', new DateTimeStrategy());

        $objectVars = $this->prepare($hydrator->extract($this));
        $objectVars['position'] = $this->getPosition()->getId();

        return $objectVars;
    }

}
