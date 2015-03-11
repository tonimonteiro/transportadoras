<?php
namespace SimAds\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Ads extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var object
     */
    protected $entityManager;

    /**
     * Construct.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
    	$this->setServiceLocator($serviceLocator);
    	$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * Set service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \SimPoll\View\Helper\Poll
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        if($this->serviceLocator !== null)
            return $this;

        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Get service locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Get data to form.
     *
     * @return string
     */
    public function getListMedia($limit, $position = null, $order = 'orderBy ASC')
    {
        $repository = $this->entityManager->getRepository('SimAds\Entity\Media');
        return $repository->getList($limit, $position, $order);
    }


}