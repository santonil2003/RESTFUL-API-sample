<?php

/**
 * Bootstrap the api
 */
require_once 'config.php';
require_once 'bootstrap.php';


//Utility::r($_SERVER);

$route = new Router();

$route->register('/', 'GET', function () {
    echo 'HOME';
});

$route->register('/coffees', 'GET', function () {
    $Coffees = new CoffeeReviews();

    //$data = ['reviewer_name'=>'testing','review'=>'nice rating','rating'=>rand(1,5),'coffee_id'=>1];
    //$rows = $Coffees->create($data);


    $data = ['reviewer_name'=>'testing','review'=>'nice rating','rating'=>rand(1,5),'coffee_id'=>1];
    $rows = $Coffees->update($data,2);


    Utility::r($rows);
});

$route->register('/coffee/(\d+)', 'GET', function () {
    echo 'Coffee 1';
});

$route->register('/coffee/(\d+)/test/(\d+)', 'GET', function ($a,$b) {

    echo "Coffee $a, $b";
});


/**
* Route based on call
**/

$route->route();
