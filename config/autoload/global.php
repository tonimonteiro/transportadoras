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
        'contact',
        'contact/default',
        'search',
        'search/paginator-site',
        'site-map',
        'pageRoute'
    ),
);

$params['navigation'] = array(
    'navigation_admin' => 'Módulos do Sistema',
    'navigation_1' => 'Lista 1 - Menu Topo',
    'navigation_2' => 'Lista 2 - Menu Principal',
    'navigation_3' => 'Lista 3 - Sem Menu',
);

$params['sn'] = array(
        '1' => 'Sim',
        '2' => 'Não',
);

$params['situacao'] = array(
    '1' => 'Ativo',
    '2' => 'Inativo',
);

$params['cms'] = array(
    'access' => array(
        '1' => 'Público',
        '2' => 'Restrito',
    ),
);

$params['ckeditor']['kcfinder'] = array(
    'disabled' => false,
    '_check4htaccess' => false,
    'uploadURL' => 'http://' . $_SERVER["HTTP_HOST"] . '/files/',
    'uploadDir' => dirname(dirname(dirname(__FILE__))) . '/public/files/',
    'theme' => 'default'
);

/**
 * Return values of the configuration.
 */
return array(
    'configuration' => array(
        'contact' => array(
            'to' => 'contato@simtecnologia.com',
            'from' => 'contato@simtecnologia.com',
        ),
    ),
    'params' => $params,
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'simtecno_site',
                    'password' => 'WHpen5xJhow2',
                    'dbname' => 'simtecno_site',
                    'driverOptions' => array(
                        1002 => "SET NAMES 'UTF8'"
                    )
                )
            )
        )
    ),
    'mail' => array(
        'name' => '',
        'host' => 'smtp.googlemail.com',
        'port' => 25,
        /*
        'connection_class' => 'login',
        'connection_config' => array(
            'username' => 'ouvidoria@eletrosul.gov.br',
            'password' => '',
            'ssl' => 'tls',
        )
        */
    ),
    'service_manager' => array(
        'factories' => array()
    ),
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'eletrosul',
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