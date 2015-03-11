<?php

namespace DoctrineORMModule\Proxy\__CG__\SimAcl\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Role extends \SimAcl\Entity\Role implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'name', 'isAdmin', 'registeredBy', 'registeredIn', 'modifiedBy', 'modifiedIn', 'role', 'navigation');
        }

        return array('__isInitialized__', 'id', 'name', 'isAdmin', 'registeredBy', 'registeredIn', 'modifiedBy', 'modifiedIn', 'role', 'navigation');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Role $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsAdmin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsAdmin', array());

        return parent::getIsAdmin();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsAdmin($isAdmin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsAdmin', array($isAdmin));

        return parent::setIsAdmin($isAdmin);
    }

    /**
     * {@inheritDoc}
     */
    public function setRegisteredBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegisteredBy', array());

        return parent::setRegisteredBy();
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegisteredBy', array());

        return parent::getRegisteredBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setRegisteredIn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegisteredIn', array());

        return parent::setRegisteredIn();
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredIn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegisteredIn', array());

        return parent::getRegisteredIn();
    }

    /**
     * {@inheritDoc}
     */
    public function setModifiedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModifiedBy', array());

        return parent::setModifiedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function getModifiedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModifiedBy', array());

        return parent::getModifiedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setModifiedIn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModifiedIn', array());

        return parent::setModifiedIn();
    }

    /**
     * {@inheritDoc}
     */
    public function getModifiedIn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModifiedIn', array());

        return parent::getModifiedIn();
    }

    /**
     * {@inheritDoc}
     */
    public function getRole()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRole', array());

        return parent::getRole();
    }

    /**
     * {@inheritDoc}
     */
    public function setRole($role)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRole', array($role));

        return parent::setRole($role);
    }

    /**
     * {@inheritDoc}
     */
    public function setNavigation($navigation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNavigation', array($navigation));

        return parent::setNavigation($navigation);
    }

    /**
     * {@inheritDoc}
     */
    public function getNavigation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNavigation', array());

        return parent::getNavigation();
    }

    /**
     * {@inheritDoc}
     */
    public function getNavigationList()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNavigationList', array());

        return parent::getNavigationList();
    }

    /**
     * {@inheritDoc}
     */
    public function addNavigation(\Doctrine\Common\Collections\ArrayCollection $navigation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addNavigation', array($navigation));

        return parent::addNavigation($navigation);
    }

    /**
     * {@inheritDoc}
     */
    public function removeNavigation(\Doctrine\Common\Collections\ArrayCollection $navigation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeNavigation', array($navigation));

        return parent::removeNavigation($navigation);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', array());

        return parent::__toString();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', array());

        return parent::toArray();
    }

}