'use strict';

angular.module('myApp.view1', ['ngRoute'])

        .config(['$routeProvider', function ($routeProvider) {
                $routeProvider.when('/view1', {
                    templateUrl: 'view1/view1.html',
                    controller: 'View1Ctrl'
                });
            }])
       
.controller('View1Ctrl', ['$scope', '$http', function ($scope, $http) {
                //$scope.allNews = 
               $http.get("view1/news.json")
                .success(function (response) {$scope.allNews = response;});               
                $scope.orderProp = "-id";
            }]);
        
     
       
        
 