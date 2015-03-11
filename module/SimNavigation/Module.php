<?php
namespace SimNavigation;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SimNavigation\Service\Navigation' => function ($sm)
                {
                    return new Service\Navigation($sm->get('Doctrine\ORM\Entitymanager'));
                },
            )
        );
    }
}
