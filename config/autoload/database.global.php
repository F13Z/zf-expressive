<?php

define('DBHOST','localhost');
define('DBNAME','zfexpressive');
define('DBUSER','root');
define('DBPASS','');

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn'    => 'mysql:dbname=' . DBNAME . ';host=' . DBHOST,
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],
        'username' => DBUSER,
        'password' => DBPASS,
    ],
];