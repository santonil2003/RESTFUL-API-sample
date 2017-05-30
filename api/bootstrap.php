<?php

/**
 * PDO Data base connection
 */
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);

/**
 * auto load necessary components on instantiation
 */
spl_autoload_register(function ($className) {

    // path to scan for classes
    $classFilePath = COMPONENTS_PATH . DIRECTORY_SEPARATOR . $className . '.php';
    $modelPath = MODELS_PATH . DIRECTORY_SEPARATOR . $className . '.php';

    if (file_exists($modelPath)) {
        include ($modelPath);
    } else if (file_exists($classFilePath)) {
        include ($classFilePath);
    } else {
        exit("$className not found!");
    }
});
