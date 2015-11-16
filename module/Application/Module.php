<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\ModuleManager\ModuleManager;
use Zend\Session\SessionManager;
use Zend\Session\Container;
//use SisTransportadora\View\Helper\Transportadora;
//use SisCep\View\Helper\Cep;
use SimBase\View\Helper\RouteMatch;

class Module
{

    /**
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()
            ->getServiceManager()
            ->get('viewhelpermanager')
            ->setFactory('RouteMatch', function ($sm) use($e)
        {
            $viewHelper = new RouteMatch($e->getRouteMatch());
            return $viewHelper;
        });

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->bootstrapSession($e);
        $this->initAcl($e);
    }

    /**
     *
     * @param MvcEvent $e
     */
    public function bootstrapSession(MvcEvent $e)
    {
        // serviceManager.
        $serviceManager = $e->getApplication()->getServiceManager();

        // config.
        $config = $serviceManager->get('config');

        // params session
        $session = $serviceManager->get('Zend\Session\SessionManager');
        $session->setName($config['params']['session']['administrator']);
        $session->start();

        // container options.
        $container = new Container('initialized');
        if (! isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    /**
     *
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, array(
            $this,
            'mvcPreDispatch'
        ), 100);
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
                'navigation' => 'SimNavigation\Navigation\ApplicationNavigationFactory',
                'Zend\Session\SessionManager' => function ($sm)
                {
                    $config = $sm->get('config');

                    if (isset($config['session'])) {
                        $session = $config['session'];

                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class']) ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }

                        $sessionStorage = null;
                        if (isset($session['storage'])) {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }

                        $sessionSaveHandler = null;
                        if (isset($session['save_handler'])) {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get($session['save_handler']);
                        }

                        $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

                        if (isset($session['validator'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validator'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array(
                                    $validator,
                                    'isValid'
                                ));
                            }
                        }
                    } else {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
                'SessionAdmin' => function ($sm)
                {
                    $config = $sm->get('config');
                    $session = new Container($config['params']['session']['administrator']);
                    return $session->storage;
                },
                'SessionAdminSearch' => function ($sm)
                {
                    $config = $sm->get('config');
                    return new Container('SessionAdminSearch');
                }
                ,
                'SessionAdminAdditional' => function ($sm)
                {
                $config = $sm->get('config');
                return new Container('SessionAdminAdditional');
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'flashMessages' => function ($serviceManager)
                {
                    $flashmessenger = $serviceManager->getServiceLocator()
                        ->get('ControllerPluginManager')
                        ->get('flashmessenger');

                    $messages = new \SimBase\View\Helper\FlashMessages();
                    $messages->setFlashMessenger($flashmessenger);

                    return $messages;
                },
                'config' => function ($serviceManager)
                {
                    $helper = new \SimBase\View\Helper\Config($serviceManager);
                    return $helper;
                },
                /*
                'Transportadora' => function ($pluginManager)
                {
                    $serviceLocator = $pluginManager->getServiceLocator();
                    return new Transportadora($serviceLocator);
                },
                'Cep' => function ($pluginManager)
                {
                    $serviceLocator = $pluginManager->getServiceLocator();
                    return new Cep($serviceLocator);
                },
                */
                'DataGridSort' => function ($serviceManager)
                {
                    $mvcEvent = $serviceManager->getServiceLocator()->get('application')->getMvcEvent();
                    return new \SimBase\View\Helper\DataGridSort($mvcEvent);
                }
            )
        );
    }

    /**
     * Acl
     *
     * @param MvcEvent $e
     */
    public function initAcl(MvcEvent $e)
    {
        $acl = $e->getApplication()
            ->getServiceManager()
            ->get('SimAcl\Permissions\Acl');

        $e->getViewModel()->acl = $acl;
    }

    /**
     *
     * @param MvcEvent $e
     */
    public function mvcPreDispatch(MvcEvent $e)
    {
        $config = $e->getApplication()
            ->getServiceManager()
            ->get('config');

        // Auth.
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage($config['params']['session']['administrator']));

        // Session.
        $session = $auth->getIdentity();

        // Service manager and params.
        $serviceManager = $e->getApplication()->getServiceManager();
        $router = $serviceManager->get('router');
        $request = $serviceManager->get('request');
        $routeMatch = $router->match($request);
        $params = $e->getRouteMatch()->getParams();

        // Role
        $role = $auth->hasIdentity() ? $session->getRole()->getName() : '';
        $routePublic = $config['params']['route']['public'];

        if (in_array($routeMatch->getMatchedRouteName(), $routePublic)) {
            return true;
        }

        if (empty($role) || ((! $e->getViewModel()->acl->isAllowed($role, $params['controller'], $params['action'])) && ($routeMatch->getMatchedRouteName() != 'simauth-admin'))) {
            // redirecina para login
            $url = $e->getRouter()->assemble(array(
                'action' => 'logout'
            ), array(
                'name' => 'simauth-logout'
            ));

            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);

            return $response;
        }
    }
}
