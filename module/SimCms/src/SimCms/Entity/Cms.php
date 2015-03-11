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
namespace SimCms\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimBase\Entity\AbstractEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use SimBase\Hydrator\Strategy\DateTimeStrategy;

/**
 * CmsConteudo
 *
 * @ORM\Table(name="cms_conteudo", indexes={@ORM\Index(name="fk_cms_conteudo_app_navigation1_idx", columns={"navigation_id"})})
 * @ORM\Entity(repositoryClass="SimCms\Entity\CmsRepository")
 */
class Cms extends AbstractEntity
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
     * @ORM\Column(name="locale", type="string", length=5, nullable=true)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="urlIndex", type="string", length=255, nullable=true)
     */
    private $urlIndex;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry", type="datetime", nullable=false)
     */
    private $entry;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="output", type="datetime", nullable=true)
     */
    private $output;

    /**
     * @var string
     *
     * @ORM\Column(name="params", type="text", nullable=true)
     */
    private $params;

    /**
     * @var integer
     *
     * @ORM\Column(name="showDate", type="integer", nullable=false)
     */
    private $showDate = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="showTime", type="integer", nullable=false)
     */
    private $showTime = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="destak", type="integer", nullable=false)
     */
    private $destak = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="orderBy", type="integer", nullable=false)
     */
    private $orderBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="revision", type="integer", nullable=false)
     */
    private $revision = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    private $state = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="visible", type="integer", nullable=false)
     */
    private $visible = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="access", type="integer", nullable=false)
     */
    private $access = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="terminal", type="integer", nullable=false)
     */
    private $terminal = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", length=45, nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="modifiedBy", type="string", length=45, nullable=true)
     */
    private $modifiedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="navigationName", type="string", length=100, nullable=true)
     */
    private $navigationName;

    /**
     * @var \AppNavigation
     *
     * @ORM\ManyToOne(targetEntity="SimNavigation\Entity\Navigation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="navigation_id", referencedColumnName="id")
     * })
     */
    private $navigation;

    /**
     * Construct.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('entry', new DateTimeStrategy());
        $hydrator->addStrategy('output', new DateTimeStrategy());
        $hydrator->addStrategy('created', new DateTimeStrategy());
        $hydrator->addStrategy('modified', new DateTimeStrategy());
        $hydrator->hydrate($options, $this);

        if (empty($options['createdBy'])) {
            $this->createdBy = $this->getSession('SimUserEntityUser')->getName();
        }

        if (empty($options['modifiedBy'])) {
            $this->modifiedBy = $this->getSession('SimUserEntityUser')->getName();
        }

        $this->modified = new \DateTime("now");
        $this->created = new \DateTime("now");
    }

    /**
     * Gets the $id.
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * Sets the $id.
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	/**
     * Gets the $locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

	/**
     * Sets the $locale.
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

	/**
     * Gets the $title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

	/**
     * Sets the $title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Gets the $content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

	/**
     * Sets the $content.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

	/**
     * Gets the $url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

	/**
     * Sets the $url.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

	/**
     * Gets the $urlIndex.
     *
     * @return string
     */
    public function getUrlIndex()
    {
        return $this->urlIndex;
    }

	/**
     * Sets the $urlIndex.
     *
     * @param string $urlIndex
     */
    public function setUrlIndex($urlIndex)
    {
        $this->urlIndex = $urlIndex;
        return $this;
    }

	/**
     * Gets the $entry.
     *
     * @return DateTime
     */
    public function getentry()
    {
        return $this->entry;
    }

	/**
     * Sets the $entry.
     *
     * @param DateTime $entry
     */
    public function setentry($entry)
    {
        $this->entry = $entry;
        return $this;
    }

	/**
     * Gets the $output.
     *
     * @return DateTime
     */
    public function getoutput()
    {
        return $this->output;
    }

	/**
     * Sets the $output.
     *
     * @param DateTime $output
     */
    public function setoutput($output)
    {
        $this->output = $output;
        return $this;
    }

	/**
     * Gets the $params.
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

	/**
     * Sets the $params.
     *
     * @param string $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

	/**
     * Gets the $showDate.
     *
     * @return number
     */
    public function getShowDate()
    {
        return $this->showDate;
    }

	/**
     * Sets the $showDate.
     *
     * @param number $showDate
     */
    public function setShowDate($showDate)
    {
        $this->showDate = $showDate;
        return $this;
    }

	/**
     * Gets the $showTime.
     *
     * @return number
     */
    public function getShowTime()
    {
        return $this->showTime;
    }

	/**
     * Sets the $showTime.
     *
     * @param number $showTime
     */
    public function setShowTime($showTime)
    {
        $this->showTime = $showTime;
        return $this;
    }

	/**
     * Gets the $destak.
     *
     * @return number
     */
    public function getDestak()
    {
        return $this->destak;
    }

	/**
     * Sets the $destak.
     *
     * @param number $destak
     */
    public function setDestak($destak)
    {
        $this->destak = $destak;
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
     * Gets the $revision.
     *
     * @return number
     */
    public function getRevision()
    {
        return $this->revision;
    }

	/**
     * Sets the $revision.
     *
     * @param number $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
        return $this;
    }

	/**
     * Gets the $state.
     *
     * @return number
     */
    public function getState()
    {
        return $this->state;
    }

	/**
     * Sets the $state.
     *
     * @param number $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

	/**
     * Gets the $visible.
     *
     * @return number
     */
    public function getVisible()
    {
        return $this->visible;
    }

	/**
     * Sets the $visible.
     *
     * @param number $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

	/**
     * Gets the $access.
     *
     * @return number
     */
    public function getAccess()
    {
        return $this->access;
    }

	/**
     * Sets the $restrict.
     *
     * @param number $restrict
     */
    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }

	/**
     * Gets the $terminal.
     *
     * @return string
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

	/**
     * Sets the $terminal.
     *
     * @param string $terminal
     */
    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
        return $this;
    }

	/**
     * Gets the $created.
     *
     * @return DateTime
     */
    public function getCreated()
    {

        return $this->created;
    }

	/**
     * Sets the $created.
     *
     * @param DateTime $created
     */
    public function setCreated($created)
    {
        if (empty($created)) {
        	$created =  new \DateTime("now");
        }
        $this->created = $created;
        return $this;
    }

	/**
     * Gets the $createdby.
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

	/**
     * Sets the $createdby.
     *
     * @param string $createdby
     */
    public function setCreatedBy($createdBy)
    {
        if (empty($createdBy)) {
            $createdBy = $this->getSession('SimUserEntityUser')->getName();
        }
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Gets the $modified.
     *
     * @return DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

	/**
     * Sets the $modified.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param DateTime $modified
     */
    public function setModified($modified)
    {
        if (empty($modified)) {
            $modified =  new \DateTime("now");
        }
        $this->modified = $modified;
        return $this;
    }

	/**
     * Gets the $modifiedby.
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

	/**
     * Sets the $modifiedby.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param string $modifiedby
     */
    public function setModifiedBy($modifiedBy)
    {
        $modifiedBy = $this->getSession('SimUserEntityUser')->getName();
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

	/**
     * Gets the $navigationName.
     *
     * @return string
     */
    public function getNavigationName()
    {
        return $this->navigationName;
    }

	/**
     * Sets the $navigationName.
     *
     * @param string $navigationName
     */
    public function setNavigationName($navigationName)
    {
        $this->navigationName = $navigationName;
        return $this;
    }

	/**
     * Gets the $navigation.
     *
     * @return AppNavigation
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

	/**
     * Sets the $navigation.
     *
     * @param AppNavigation $navigation
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;
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
        $hydrator->addStrategy('entry', new DateTimeStrategy());
        $hydrator->addStrategy('output', new DateTimeStrategy());
        $hydrator->addStrategy('created', new DateTimeStrategy());
        $hydrator->addStrategy('modified', new DateTimeStrategy());

        $objectVars = $this->prepare($hydrator->extract($this));

        if (! empty($this->getNavigation())) {
            $objectVars['navigation'] = $this->getNavigation()->getId();
            $objectVars['navigationRow'] = $this->getNavigation()->toArray();
        }

        return $objectVars;
    }

}