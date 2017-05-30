
/**
 * set base url
 * @todo modify base url as per as project domain
 * @type String
 */
var baseUrl = "http://localhost/project/api";

// AJAX polling interval
var pollingInterval = 30000; // 30 sec

/**
 * global variable to store current coffee id for AJAX Polling
 * @type type
 */
var currentCoffeeId;

/**
 * AJAX Polling to load coffee details every 30 sec
 */
var ajaxPolling = setInterval(function () {
    if (currentCoffeeId) {
        loadDetail(currentCoffeeId);
    }
}, pollingInterval);


/**
 * delete review API call
 * @param {type} coffeeId
 * @param {type} reviewId
 * @returns {coffee}
 */
function deleteReview(coffeeId, reviewId) {

    if (!confirm("Are you sure ?")) {
        return;
    }
    // API call with request method DELETE to delete review
    postAjax(baseUrl + '/review/' + reviewId + '/delete', 'DELETE', 'reviewId=' + reviewId, function (res) {

        // load updated review list
        loadDetail(coffeeId);
    });
}

/**
 * update reveiw api call
 * @param {type} coffeeId
 * @param {type} reviewId
 * @returns {undefined}
 */
function updateReview(coffeeId, reviewId) {

    // pre-pare data json
    var data = {
        reviewer_name: document.getElementById('update-name-' + reviewId).value,
        review: document.getElementById('update-review-' + reviewId).value
    };

    // find the selected rating..
    var radios = document.getElementsByName('rating_' + reviewId);
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            data.rating = radios[i].value;
            break;
        }
    }

    // API call with request method PUT to update review
    postAjax(baseUrl + '/review/' + reviewId + '/update', 'PUT', data, function (res) {

        // load updated review list
        loadDetail(coffeeId);
    });
}


/**
 * save reveview
 * @param {type} coffeeId
 * @returns {undefined}
 */
function saveReview(coffeeId) {

    var radios = document.getElementsByName('rating');


    // review json
    var data = {
        reviewer_name: document.getElementById('name-' + coffeeId).value,
        review: document.getElementById('review-' + coffeeId).value,
        rating: 3, // will be updated by loop
        coffee_id: coffeeId
    };


    // select selected rating and update the json
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            data.rating = radios[i].value;
            break;
        }
    }


    // API call with request method POST to save new review
    postAjax(baseUrl + '/coffee/' + coffeeId + '/review/create', 'POST', data, function (res) {

        // load updated review list
        loadDetail(coffeeId);

        // reset form
        document.getElementById('name-' + coffeeId).value = "";
        document.getElementById('review-' + coffeeId).value = "";
    });


}




function sortMenu(order) {
    loadMenu(order);
}



/**
 * Load coffee menus
 * @returns {undefined}
 */
function loadMenu(order) {

    if (typeof order == 'undefined') {
        order = 'name';
    }

    getAjax(baseUrl + '/coffees/order/' + order, function (response) {
        var items = JSON.parse(response);
        var html = '';
        for (var i = 0; i < items.length; i++) {
            html += '<li><a onclick="loadContent(' + items[i].id + ')">' + items[i].name + '</a><span>' + items[i].rating + '</span></li>';
        }
        document.getElementById('coffee-menu').innerHTML = html;
    });
}

/**
 * load content and start ajax polling
 * @param {type} coffeeId
 * @returns {undefined}
 */
function loadContent(coffeeId) {
    // load reviews
    loadDetail(coffeeId);
    // load review form
    loadReviewForm(coffeeId);
}




/**
 * load coffee details with reviews
 * @param {type} coffeeId
 * @returns {undefined}
 */
function loadDetail(coffeeId) {

    // update currentCoffeeId
    currentCoffeeId = coffeeId;


    // API call with request method GET to load coffee details
    getAjax(baseUrl + '/coffee/' + coffeeId + '/reviews', function (response) {

        var item = JSON.parse(response);
        var html = '';

        html += '<ul class="coffee-details">';

        html += '<li class="coffee-name"><b> Name : ' + item.name + '</b></li>';
        html += '<li class="coffee-img"><img src="' + baseUrl + '/images/' + item.image_url + '" /></li>';
        html += '<li class="coffee-avg-rating">Average Rating : ' + item.average_rating + '</li>';
        html += '<li>';

        // review ul
        html += '<ul class="reviews">';

        for (var i = 0; i < item.reviews.length; i++) {
            html += '<li id="review-' + item.reviews[i].id + '" class="review">';
            html += '<p class="reviewer-name"> By : ' + item.reviews[i].reviewer_name + '</p>';
            html += '<p class="review-content">' + item.reviews[i].review + '</p>';
            html += '<p class="rating"> Rating : <span>' + item.reviews[i].rating + '</span></p>';
            html += '<div class="action">';
            html += '<a class="update" onclick="loadUpdateReviewForm(' + coffeeId + ',' + item.reviews[i].id + ')">Update</a>';
            html += '<a class = "delete" onclick="deleteReview(' + coffeeId + ',' + item.reviews[i].id + ')">Delete</a>';
            html += '</div>';
            html += '</li>';
        }

        html += '</ul>';
        // end of review ul

        html += '</li>';

        html += '</ul>';

        html += '<hr/>';

        // render reviews
        document.getElementById('coffee-reveiws').innerHTML = html;

    });
}

function loadReviewForm(coffeeId) {
    // render review form
    document.getElementById('coffee-reveiw-form').innerHTML = getReviewForm(coffeeId);
}



/**
 * load update review form
 * @param {type} coffeeId
 * @param {type} reviewId
 * @returns {undefined}
 */
function loadUpdateReviewForm(coffeeId, reviewId) {

    var html = '';

    html += '<ul class="review-form">';
    html += '<li><label> Name </label> <input type = "text" id = "update-name-' + reviewId + '"></li>';
    html += '<li><label> Review </label> <textarea id = "update-review-' + reviewId + '" ></textarea></li>';

    // rating li start
    html += '<li><label> Rating : </label>';
    html += '<input type="radio" name="rating_' + reviewId + '" value="1"> 1 ';
    html += '<input type="radio" name="rating_' + reviewId + '" value="2"> 2 ';
    html += '<input type="radio" name="rating_' + reviewId + '" value="3"> 3 ';
    html += '<input type="radio" name="rating_' + reviewId + '" value="4"> 4 ';
    html += '<input type="radio" name="rating_' + reviewId + '" value="5"> 5 ';
    html += '</li>';
    // end of rating li

    html += '<li><input type = "button" name = "save" value="save" onclick="updateReview(' + coffeeId + ',' + reviewId + ')"></li>';
    html += '</ul>';

    // render review update form
    document.getElementById('review-' + reviewId).innerHTML = html;


    // load data in update form from API
    getAjax(baseUrl + '/review/' + reviewId, function (response) {

        var item = JSON.parse(response);

        document.getElementById('update-name-' + reviewId).value = item.reviewer_name;
        document.getElementById('update-review-' + reviewId).innerHTML = item.review;


        var radios = document.getElementsByName('rating_' + reviewId);

        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].value == item.rating) {
                radios[i].checked = true;
                break;
            }
        }


    });
}

/**
 * get review form
 * @param {type} coffeeId
 * @returns {String}
 */
function getReviewForm(coffeeId) {
    var html = '';

    html += '<ul class="review-form">';
    html += '<li><label>Name</label><input type = "text" id="name-' + coffeeId + '"></li>';
    html += '<li><label>Review</label><textarea id="review-' + coffeeId + '"></textarea></li>';

    // rating li
    html += '<li class="radio-li"> <label> Rating</label>';
    html += '<input type="radio" name="rating" value="1"> 1 ';
    html += '<input type="radio" name="rating" value="2"> 2 ';
    html += '<input type="radio" name="rating" value="3"> 3 ';
    html += '<input type="radio" name="rating" value="4"> 4 ';
    html += '<input type="radio" name="rating" value="5"> 5 ';
    html += '</li>';
    // end of rating li


    html += '</ul>';
    html += '<input type = "button" name = "save" value="save" onclick="saveReview(' + coffeeId + ')">';

    return html;
}










/**
 * load the content
 * @returns {undefined}
 */
function initApp() {
    try {
        loadMenu();
    } catch (err) {
        console.log(err.message);
    }
}