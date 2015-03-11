<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Site\Controller\Index' => 'Site\Controller\IndexController',
            'Site\Controller\Contact' => 'Site\Controller\ContactController',
        ),
    ),
    'module_layouts' => array(
        'SimUser' => 'layout/application.phtml',
        'SimAds' => 'layout/application.phtml',
        'SimNavigation' => 'layout/application.phtml',
        'SimAuth' => 'layout/simauth.phtml',
        'SimAcl' => 'layout/application.phtml',
        'SimCms' => 'layout/application.phtml',
        'Application' => 'layout/application.phtml',
        'Site' => 'layout/site.phtml',
    ),
    'router' => array(
        'routes' => array(
            'site-map' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/mapa-do-site',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Site\Controller',
                        'controller'    => 'Index',
                        'action'        => 'site-map',
                    ),
                ),
            ),
            // contact
            'contact' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/contato',
                    'defaults' => array(
                        'controller' => 'Site\Controller\Contact',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Site\Controller\Contact',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            // search
            'search' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/busca',
                    'defaults' => array(
                        'controller' => 'Site\Controller\Index',
                        'action'     => 'search',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'paginator-site' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => array(
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                'controller' => 'Site\Controller\Index',
                                'action' => 'search'
                            )
                        )
                    ),
                ),
            ),
            // page route
            'pageRoute' => array(
                'type' => 'pageRoute',
            ),
            'site' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Site\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/site.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
