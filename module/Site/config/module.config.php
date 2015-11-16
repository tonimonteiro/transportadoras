<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Site\Controller\Index' => 'Site\Controller\IndexController',
        ),
    ),
    'module_layouts' => array(
        'SisCep' => 'layout/application.phtml',
        'SisTransportadora' => 'layout/application.phtml',
        'SimUser' => 'layout/application.phtml',
        'SimNavigation' => 'layout/application.phtml',
        'SimAuth' => 'layout/simauth.phtml',
        'SimAcl' => 'layout/application.phtml',
        'Application' => 'layout/application.phtml',
        'Site' => 'layout/site.phtml',
    ),
    'router' => array(
        'routes' => array(
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
