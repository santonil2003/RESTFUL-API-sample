<?php

/**
 * Bootstrap the api
 */
require_once 'config.php';
require_once 'bootstrap.php';

//Utility::r($_SERVER);

$route = new Router();

$route->register('/', 'GET', function () {
    $coffeeObj = new Coffees();

    // fetch all coffees
    $coffees = $coffeeObj->getAttributes();

    Utility::r($coffees);

});

$route->register('/coffees', 'GET', function () {

    $coffeeObj = new Coffees();

    // fetch all coffees
    $coffees = $coffeeObj->fetchAll();

    // array to json
    $json = Request::jsonResponse($coffees);

    exit($json);

});

$route->register('/coffee/(\d+)', 'GET', function ($coffeeId) {

    $coffeeObj = new Coffees();

    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);

    // array to json
    $json = Request::jsonResponse($coffee);

    exit($json);
});

$route->register('/coffee/(\d+)/reviews', 'GET', function ($coffeeId) {

    $coffeeObj       = new Coffees();
    $coffeeReviewObj = new CoffeeReviews();

    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);

    // average rating
    $coffee['average_rating'] = $coffeeReviewObj->getAverageRatingByCoffee($coffeeId);

    // fetch  review by coffee id
    $coffee['reviews'] = $coffeeReviewObj->fetchByCoffee($coffeeId);

    // array to json
    $json = Request::jsonResponse($coffee);

    exit($json);
});

$route->register('/coffee/create', 'POST', function () {
    $data = $_POST;
    Utility::r($data);
});

http: //localhost/api/coffee/add

// route based on request uri
$route->route();
