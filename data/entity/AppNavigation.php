<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppNavigation
 *
 * @ORM\Table(name="app_navigation", indexes={@ORM\Index(name="fk_app_navigation_app_navigation1_idx", columns={"parent_id"})})
 * @ORM\Entity
 */
class AppNavigation
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
     * @ORM\Column(name="name_group", type="string", length=45, nullable=false)
     */
    private $nameGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
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
    private $resource = 'null';

    /**
     * @var string
     *
     * @ORM\Column(name="privilege", type="string", length=45, nullable=true)
     */
    private $privilege;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="number_order", type="integer", nullable=true)
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
     * @var \AppNavigation
     *
     * @ORM\ManyToOne(targetEntity="AppNavigation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;


}
