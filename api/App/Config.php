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
    
    const SITE_NAME = "US Carmaux Voile";
    const DOMAIN = "uscvoile.fr";
    const GRECAPTCHA_SECRET_KEY = "6LeuxD0UAAAAAN3SXUjRwWzaMGi9vpovC20wXbIc";
}