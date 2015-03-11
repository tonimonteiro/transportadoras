<?php
namespace SimNavigation\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationNavigationFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new DefaultNavigation('navigation_admin');
        return $navigation->createService($serviceLocator);
    }
}