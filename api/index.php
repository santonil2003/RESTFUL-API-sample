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

$route->register('/coffees/order/(.+)', 'GET', function ($order) {
    $coffeeObj = new Coffees();
    // fetch all coffees
    $coffees = $coffeeObj->coffeesWithAverageRating($order);
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


$route->register('/review/(\d+)', 'GET', function ($reviewId) {
    $coffeeReviewObj = new CoffeeReviews();
    // fetch coffee by id
    $review = $coffeeReviewObj->fetch($reviewId);

    if ($review) {
        Response::sendJSON($review);
    }

    Response::sendJSON(array('error' => 'failed to fetch review.'), 500);
});

$route->register('/review/(\d+)/update', 'PUT', function ($reviewId) {
    if ($reviewId) {


        $data = array();

        // read put data
        parse_str(file_get_contents("php://input"), $data);

        $coffeeReviewObj = new CoffeeReviews();
        $result = $coffeeReviewObj->update($data, $reviewId);

        if ($result) {
            Response::sendJSON(array('message' => 'review updated'));
        }
    }

    Response::sendJSON(array('error' => 'failed to update reveiw'), 500);
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
