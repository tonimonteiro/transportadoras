<?php
namespace SimAds;

return array(
    'router' => array(
        'routes' => array(
            /**
             * Public users.
             */

            /**
             * Administrator.
             */
            'simads-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/ads',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimAds\Controller',
                        'controller' => 'Media',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id][/page/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'SimAds\Controller',
                                'controller' => 'index'
                            )
                        )
                    ),
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'SimAds\Controller\Media' => 'SimAds\Controller\MediaController',
            'SimAds\Controller\Position' => 'SimAds\Controller\PositionController'
        )
    ),
    // translate
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory'
        )
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php'
            )
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'router' => function ($sm)
            {
                return new \SimBase\View\Helper\Router($sm->getServiceLocator()
                    ->get('application')
                    ->getMvcEvent()
                    ->getRouteMatch());
            }
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'data-fixture' => array(
        __NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture'
    )
);