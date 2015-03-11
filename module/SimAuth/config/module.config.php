<?php
namespace SimAuth;

return array(
    'router' => array(
        'routes' => array(
            /**
             * Public users.
             */
            'simauth-site' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/site/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimAuth\Controller',
                        'controller' => 'Site',
                        'action' => 'index'
                    )
                )
            ),
            'simauth-site-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/site/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimAuth\Controller',
                        'controller' => 'Site',
                        'action' => 'logout'
                    )
                )
            ),
            'simauth-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimAuth\Controller',
                        'controller' => 'Admin',
                        'action' => 'index'
                    )
                )
            ),
            'simauth-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimAuth\Controller',
                        'controller' => 'Admin',
                        'action' => 'logout'
                    )
                )
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'SimAuth\Controller\Admin' => 'SimAuth\Controller\AdminController',
            'SimAuth\Controller\Site' => 'SimAuth\Controller\SiteController'
        )
    ),
    'service_manager' => array(
        'factories' => array()
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index' => __DIR__ . '/../../Application/view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
);