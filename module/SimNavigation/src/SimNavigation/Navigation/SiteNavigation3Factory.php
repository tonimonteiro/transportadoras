<?php
namespace SimNavigation\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SiteNavigation3Factory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new DefaultNavigation('navigation_3', 167);
        $navigation->setCriteria(array('visible' => 1));
        return $navigation->createService($serviceLocator);
    }
}