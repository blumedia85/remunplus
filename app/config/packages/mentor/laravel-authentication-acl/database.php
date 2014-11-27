<?php
$server = array();
$db_password = '';
$db_host = 'localhost';
$db_username = 'root';
$db_name = 'payrol_system';
if(isset($_SERVER['HTTP_HOST']))
    $server = explode(".",$_SERVER['HTTP_HOST']);
if(empty($server))
    $db_password = '';
elseif(isset($server[2]) && ($server[2]=='local'))
    $db_password = '';
elseif((isset($server[1])) && ($server[1]=='local'))
    $db_password = '';
else{
    $db_password = 'dev@Echelon85';
    $db_host = 'renumerm.db.9426656.hostedresource.com';
    $db_username = 'renumerm';
    $db_name = 'renumerm';

}
return [
    /*
    |--------------------------------------------------------------------------
    | Connection name
    |--------------------------------------------------------------------------
    |
    | Set the connection name to use, if you want to use your application default
    | connection leave the flag as 'default'. Otherwise write the connection
    | name: for example 'mysql'.
    |
    */
    'default' => 'default',

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => $db_host,
            'database'  => $db_name,
            'username'  => $db_username,
            'password'  => $db_password,
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

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'host'     => 'localhost',
            'database' => 'payrol_system',
            'username' => 'root',
            'password' => '',
            'prefix'   => '',
        ],

    ],
];
