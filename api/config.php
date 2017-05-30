<?php

/**
 * Database configuration
 * adjust params based on enviornment
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'api');
define('DB_CHARSET', 'utf8');


/**
 * path configuration
 */
define('BASE_PATH', __DIR__);
define('COMPONENTS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'components');
define('MODELS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'models');
