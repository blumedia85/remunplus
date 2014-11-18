<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Testing Connection name
    |--------------------------------------------------------------------------
    |
    */
    'default' => 'sqlite',

    'connections' => [

            'sqlite' => [
                    'driver'   => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => '',
            ],

            'mysql' => [
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => 'payrol_system',
                    'username'  => 'root',
                    'password'  => '',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
            ],

            'pgsql' => [
                    'driver'   => 'pgsql',
                    'host'     => 'localhost',
                    'database' => 'payrol_system',
                    'username' => 'root',
                    'password' => '',
                    'charset'  => 'utf8',
                    'prefix'   => '',
                    'schema'   => 'public',
            ],
    ],
];
