
/**
 * set base url
 * @todo modify base url as per as project domain
 * @type String
 */
var baseUrl = "http://localhost/project/api";

/**
 * http Ajax for request method GET
 * @param {type} url
 * @param {type} success
 * @returns {ActiveXObject|getAjax.xhr|XMLHttpRequest}
 */
function getAjax(url, success) {
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    xhr.open('GET', url);
    xhr.onreadystatechange = function () {
        if (xhr.readyState > 3 && xhr.status == 200)
            success(xhr.responseText);
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    return xhr;
}


/**
 * http Ajax for requst method POST, PUT, DELETE
 * @param {type} url
 * @param {type} requestMethod
 * @param {type} data
 * @param {type} success
 * @returns {ActiveXObject|XMLHttpRequest|postAjax.xhr}
 */
function postAjax(url, requestMethod, data, success) {
    var params = typeof data == 'string' ? data : Object.keys(data).map(
            function (k) {
                return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
            }
    ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open(requestMethod, url);
    xhr.onreadystatechange = function () {
        if (xhr.readyState > 3 && xhr.status == 200) {
            success(xhr.responseText);
        }
    };

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}


/**
 * Load coffee menus
 * @returns {undefined}
 */
function loadMenu() {
    getAjax(baseUrl + '/coffees', function (response) {

        var items = JSON.parse(response);

        var html = '';
        for (var i = 0; i < items.length; i++) {
            html += '<li><a onclick="loadDetail(' + items[i].id + ')">' + items[i].name + '</a></li>';
        }

        document.getElementById('coffee-menu').innerHTML = html;
    });
}

/**
 * delete review
 * @param {type} coffeeId
 * @param {type} reviewId
 * @returns {coffee}
 */
function deleteReview(coffeeId, reviewId) {
    postAjax(baseUrl + '/review/' + reviewId + '/delete', 'DELETE', 'reviewId=' + reviewId, function (data) {
        loadDetail(coffeeId);
    });
}

function saveReview(coffeeId) {


    var rating = 3; // set default 3
    var radios = document.getElementsByName('rating');


    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            rating = radios[i].value;
            break;
        }
    }


    var data = {
        reviewer_name: document.getElementById('name-' + coffeeId).value,
        review: document.getElementById('review-' + coffeeId).value,
        rating: rating,
        coffee_id: coffeeId,
    };


    postAjax(baseUrl + '/coffee/' + coffeeId + '/review/create', 'POST', data, function (res) {
        console.log(res);
        loadDetail(coffeeId);
    });


}


function loadDetail(coffeeId) {
    getAjax(baseUrl + '/coffee/' + coffeeId + '/reviews', function (response) {

        var item = JSON.parse(response);
        var html = '';

        html += '<ul>';

        html += '<li><b> Name : ' + item.name + '</b></li>';
        html += '<li><img src="' + baseUrl + '/images1/' + item.image_url + '" /></li>';
        html += '<li>Average Rating : ' + item.average_rating + '</li>';
        html += '<li>';
        html += '<ul class="reviews">'; // review ul start

        for (var i = 0; i < item.reviews.length; i++) {
            html += '<li>';
            html += '<b>' + item.reviews[i].reviewer_name + '</b>';
            html += '<p>' + item.reviews[i].review + '</p>';
            html += '<i> Rating : ' + item.reviews[i].rating + '</i>';
            html += '<a onclick="deleteReview(' + coffeeId + ',' + item.reviews[i].id + ')">Delete</a>';
            html += '</li>';
        }

        html += '</ul>'; // end of review ul
        html += '</li>';

        html += '</ul>';

        html += '<hr/>';

        html += getReviewForm(coffeeId);



        document.getElementById('coffee-reveiws').innerHTML = html;
    });
}


function getReviewForm(coffeeId) {
    var html = '';

    html += '<form action="' + baseUrl + '/coffee/' + coffeeId + '/review/create" method="post" id="review-form-' + coffeeId + '">';

    html += '<ul class="review-form">';
    html += '<li><b> Name : </b> <input type = "text" name = "reviewer_name" id="name-' + coffeeId + '"></li>';
    html += '<li><b> Review : </b> <textarea name = "review" id="review-' + coffeeId + '"></textarea></li>';

    html += '<li> <b> Rating : </b><br>'; // rating li
    html += '<input type="radio" name="rating" value="1"> 1<br>';
    html += '<input type="radio" name="rating" value="2"> 2<br>';
    html += '<input type="radio" name="rating" value="3"> 3<br>';
    html += '<input type="radio" name="rating" value="4"> 4<br>';
    html += '<input type="radio" name="rating" value="5"> 5<br>';
    html += '</li>'; // end of rating li

    html += '</ul>';
    html += '<input type = "button" name = "save" value="save" onclick="saveReview(' + coffeeId + ')">';

    html += '</form>';

    return html;
}


function initApp() {
    try {
        // load menu
        loadMenu();
    } catch (err) {
        console.log(err.message);
    }
}