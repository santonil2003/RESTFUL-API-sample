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
    $coffees = $coffeeObj->fetchAll();

    // array to json
    $json = Request::jsonResponse($coffees);

    exit($json);

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
   // $json = Request::jsonResponse($coffee);

    $xml = Request::xmlResponse($coffee, 'cofffee');

    exit($xml);

    //exit($json);
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
  

    exit();
});

$route->register('/coffee/create', 'POST', function () {
    $coffeeObj = new Coffees();
    $coffeeId  = $coffeeObj->create($_POST);

    if (is_numeric($coffeeId)) {
        $coffee = $coffeeObj->fetch($coffeeId);
        $json   = Request::jsonResponse($coffee);
        exit($json);
    }

    $errorJson = Request::jsonResponse(array('error' => 'failed to create coffee.'), 500);
    exit($errorJson);

});

$route->register('/coffee/(\d+)/review/create', 'POST', function ($coffeeId) {

    $coffeeObj       = new Coffees();
    $coffeeReviewObj = new CoffeeReviews();

    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);

    if (empty($coffee)) {
        // coffee not found
        $errorJson = Request::jsonResponse(array('error' => "Coffee:$coffeeId does not exist."), 500);
        exit($errorJson);
    }

    $review = $coffeeReviewObj->create($_POST);

    if (!empty($review)) {

        // average rating
        $coffee['average_rating'] = $coffeeReviewObj->getAverageRatingByCoffee($coffeeId);

        // fetch  review by coffee id
        $coffee['reviews'] = $coffeeReviewObj->fetchByCoffee($coffeeId);

        // array to json
        $json = Request::jsonResponse($coffee);

        exit($json);
    }

    $errorJson = Request::jsonResponse(array('error' => 'failed to create review for Coffee:$coffeeId.'), 500);
    exit($errorJson);

});



// route based on request uri
$route->route();
