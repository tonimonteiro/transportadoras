<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Site for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Site;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Site\Route\PageRoute;
use SimAuth\View\Helper\UserIdentity;
use Zend\Session\Container;

class Module implements AutoloaderProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /**
         * Definir automaticamente um layout para cada módulo configurado.
         */
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);

    }

    public function getRouteConfig()
    {
        return array(
            'factories' => array(
                'pageRoute' => function ($routePluginManager)
                {
                    $locator = $routePluginManager->getServiceLocator();
                    $params = array(
                        'defaults' => array(
                            '__NAMESPACE__' => 'Site\Controller',
                            'controller'    => 'Index',
                            'action'        => 'page',
                            'id'            => 'pages'
                        )
                    );
                    $route = PageRoute::factory($params);
                    $route->setServiceManager($locator);
                    return $route;
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'flashMessages' => function($sm) {
                    $flashmessenger = $sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger');
                    $messages = new \SimBase\View\Helper\FlashMessages();
                    $messages->setFlashMessenger($flashmessenger);
                    return $messages;
                },
                'config' => function($serviceManager) {
                    $helper = new \SimBase\View\Helper\Config($serviceManager);
                    return $helper;
                },
            ),
            'invokables' => array (
                'SubstrText' => new \SimBase\View\Helper\SubstrText(),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Site\Service\Site' => function ($sm)
                {
                    return new Service\Site($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Session' => function($sm) {
                    $config = $sm->get('config');
                    return new Container($config['params']['session']['site']);
                },
                'UserIdentity' => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    $userIdentity = new UserIdentity();
                    $auth = $userIdentity($config['params']['session']['site']);

                    if (! empty($auth)) {
                    	return $auth;
                    } else {

                        $url = $serviceManager->get('Router')->assemble(array('action' => 'index'), array('name' => 'site'));
                        $response = $serviceManager->get('Response');
                        $response->getHeaders()->addHeaderLine('Location', $url);
                        $response->setStatusCode(302);
                        return array();
                    }
                }
            ),

        );
    }

}
