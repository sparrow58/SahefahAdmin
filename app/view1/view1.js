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
//               $http.get("Controller.php", {action: 'get_users'})
//                .success(function (response) {$scope.allNews = response;});                
                $http({
                    method: "get",
                    url: "Controller.php",
                    params: {
                        action: "get_users"
                    }
                }).success(function (response) {
                    $scope.allNews = response;
                     console.log(response);
                });
                $scope.orderProp = "-date";
            }]);




 