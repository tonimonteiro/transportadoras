<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

/**
 * Params config.
 */
$params['session'] = array(
    'administrator' => 'SimUserEntityUser',
);

$params['route'] = array(
    'public' =>  array(
        'site',
        'simauth-admin',
        'simauth-logout',
        'search',
        'search/paginator-site',
    ),
);

$params['navigation'] = array(
    'navigation_admin' => 'Módulos do Sistema',
);

$params['sn'] = array(
    '2' => 'Não',
    '1' => 'Sim',
);

$params['situacao'] = array(
    '1' => 'Ativo',
    '2' => 'Inativo',
);

/**
 * Return values of the configuration.
 */
return array(
    'params' => $params,
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => '',
                    'password' => '',
                    'dbname' => '',
                    'driverOptions' => array(
                        1002 => "SET NAMES 'UTF8'"
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array()
    ),
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'myapp',
            ),
        ),
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            array(
                'Zend\Session\Validator\RemoteAddr',
                'Zend\Session\Validator\HttpUserAgent',
            ),
        ),
    ),
);