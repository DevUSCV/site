<?php

namespace App;

class Config {
    const DB_PARAMS = array(
        'driver'   => 'pdo_mysql',
        'user'     => 'root',
        'password' => 'admin',
        'dbname'   => 'api',
        'charset' => 'utf8'
    );
}