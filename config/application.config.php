<?php
return array(
    'modules' => array(
        //'ZendDeveloperTools',
        //'BjyProfiler',
        'DoctrineModule',
        'DoctrineORMModule',
        //'DoctrineDataFixtureModule',
        'SimBase',
        'SimUser',
        'SisTransportadora',
        'SisCep',
        'SimNavigation',
        'SimAcl',
        'Application',
        'SimAuth',
        'Site',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        )
    )
);

