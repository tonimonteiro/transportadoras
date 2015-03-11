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
 * @category   Module.php
 * @package    SimUser
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimUser;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
// use Zend\Mail\Transport\Smtp as SmtpTransport;
// use Zend\Mail\Transport\SmtpOptions;
// use Zend\Mvc\I18n\Translator;

class Module
{

    /**
     * On Bootstrap.
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /**
         * Compatibility type enum to mysql.
         */
        $entityManager = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

    /**
     * Translate.
     */
        // $translator = new Translator();
        // $translator->addTranslationFile(
        // 'phpArray',
        // './vendor/zendframework/zendframework/resources/pt_BR/Zend_Validate.php',
        // 'default',
        // 'pt_BR'
        // );

        // $cache = $this->getServiceLocator()->get('Cache');
        // $translator->setCache($cache);
        // $translator = $e->getApplication()->getServiceManager()->get('translator');
        // \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

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
                'SimUser\Service\User' => function ($entityManager)
                {
                    return new \SimUser\Service\User($entityManager->get('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array()
        );
    }
}
