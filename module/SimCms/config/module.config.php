<?php
namespace SimCms;

return array(
    'router' => array(
        'routes' => array(
            'simcms-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/cms',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SimCms\Controller',
                        'controller' => 'Cms',
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
                                '__NAMESPACE__' => 'SimCms\Controller',
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
            'SimCms\Controller\Cms' => 'SimCms\Controller\CmsController',
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'UrlCustom' => 'SimCms\Controller\Plugin\UrlCustom',
            'Path' => 'SimCms\Controller\Plugin\Path',
        )
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