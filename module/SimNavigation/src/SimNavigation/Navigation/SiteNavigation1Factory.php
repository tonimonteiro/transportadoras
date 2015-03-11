<?php
namespace SimNavigation\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SiteNavigation1Factory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new DefaultNavigation('navigation_1', 82);
        $navigation->setCriteria(array('visible' => 1));
        return $navigation->createService($serviceLocator);
    }
}