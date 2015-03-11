<?php
namespace SimNavigation\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SiteNavigation2Factory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new DefaultNavigation('navigation_2', 109);
        $navigation->setCriteria(array('visible' => 1));
        return $navigation->createService($serviceLocator);
    }
}