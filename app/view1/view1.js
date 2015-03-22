'use strict';

angular.module('myApp.view1', ['ngRoute'])

        .config(['$routeProvider', function ($routeProvider) {
                $routeProvider.when('/view1', {
                    templateUrl: 'view1/view1.html',
                    controller: 'View1Ctrl'
                });
            }])

        .controller('View1Ctrl', ['$scope',
            function ($scope) {

                $scope.allNews = [
                    {'name': 'Nexus S',
                        'snippet': 'Fast just got faster with Nexus S.',
                        'age': 1},
                    {'name': 'Motorola XOOM™ with Wi-Fi',
                        'snippet': 'The Next, Next Generation tablet.',
                        'age': 2},
                    {'name': 'MOTOROLA XOOM™',
                        'snippet': 'The Next, Next Generation tablet.',
                        'age': 3}
                ];
                $scope.orderProp = "date";
            }]);
