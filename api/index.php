<?php

/**
 * Bootstrap the api
 */
require_once 'config.php';
require_once 'bootstrap.php';

$route = new Router();

/**
 * register route and define handlers
 */
$route->register('/', 'GET', function () {
    $coffeeObj = new Coffees();
    // fetch all coffees
    $coffees = $coffeeObj->fetchAll();
    Response::sendJSON($coffees);
});

$route->register('/coffees', 'GET', function () {
    $coffeeObj = new Coffees();
    // fetch all coffees
    $coffees = $coffeeObj->fetchAll();
    Response::sendJSON($coffees);
});

$route->register('/coffee/(\d+)', 'GET', function ($coffeeId) {
    $coffeeObj = new Coffees();
    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);
    Response::sendJSON($coffee);
});

$route->register('/coffee/(\d+)/reviews', 'GET', function ($coffeeId) {
    $coffeeObj = new Coffees();
    $coffeeReviewObj = new CoffeeReviews();

    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);
    // average rating
    $coffee['average_rating'] = $coffeeReviewObj->getAverageRatingByCoffee($coffeeId);
    // fetch  review by coffee id
    $coffee['reviews'] = $coffeeReviewObj->fetchByCoffee($coffeeId);

    Response::sendJSON($coffee);
});

$route->register('/coffee/create', 'POST', function () {
    $coffeeObj = new Coffees();
    $coffeeId = $coffeeObj->create($_POST);

    if (is_numeric($coffeeId)) {
        $coffee = $coffeeObj->fetch($coffeeId);
        Response::sendJSON($coffee);
    }

    Response::sendJSON(array('error' => 'failed to create coffee.'), 500);
});

$route->register('/coffee/update', 'PUT', function () {
    $coffeeObj = new Coffees();
    $coffeeId = $coffeeObj->create($_POST);

    if (is_numeric($coffeeId)) {
        $coffee = $coffeeObj->fetch($coffeeId);
        Response::sendJSON($coffee);
    }

    Response::sendJSON(array('error' => 'failed to create coffee.'), 500);
});

$route->register('/review/(\d+)/delete', 'DELETE', function ($reviewId) {

    if ($reviewId) {
        $coffeeReviewObj = new CoffeeReviews();
        $result = $coffeeReviewObj->delete($reviewId);

        if ($result) {
            Response::sendJSON(array('message' => 'review deleted'));
        }
    }

    Response::sendJSON(array('error' => 'failed to delete reveiw'), 500);
});

$route->register('/coffee/(\d+)/review/create', 'POST', function ($coffeeId) {

    $coffeeObj = new Coffees();
    $coffeeReviewObj = new CoffeeReviews();

    // fetch coffee by id
    $coffee = $coffeeObj->fetch($coffeeId);

    if (empty($coffee)) {
        // coffee not found
        Response::sendJSON(array('error' => "Coffee:$coffeeId does not exist."), 500);
    }

    $review = $coffeeReviewObj->create($_POST);

    if (!empty($review)) {

        // average rating
        $coffee['average_rating'] = $coffeeReviewObj->getAverageRatingByCoffee($coffeeId);

        // fetch  review by coffee id
        $coffee['reviews'] = $coffeeReviewObj->fetchByCoffee($coffeeId);

        // array to json
        Response::sendJSON($coffee);
    }

    Response::sendJSON(array('error' => 'failed to create review for Coffee:$coffeeId.'), 500);
});



/**
 * get uri params and request method such as GET, POST, PUT, DELETE
 */
$uri = Utility::getValue($_REQUEST, 'uri');
$requestMethod = Utility::getValue($_SERVER, 'REQUEST_METHOD');

// route based on the uri and request method
$route->route($uri, $requestMethod);
