
/**
 * set base url
 * @todo modify base url as per as project domain
 * @type String
 */
var baseUrl = "http://localhost/project/api";



var app = angular.module('myApp', []);

app.controller('coffeeMenuCtrl', function ($scope, $http) {
    $http.get(baseUrl + "").then(function (response) {
        $scope.coffees = response.data;
    });
});

