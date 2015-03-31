'use strict';

// Declare app level module which depends on views, and components
angular.module('myApp', [
    'ngRoute',
    'myApp.view1',
    'myApp.view2',
    'myApp.version'
]).
        controller('GreetingController', ['$scope', function ($scope) {
                $scope.test = 'test!';
                $scope.tab = 1;
                $scope.selectTab= function(setTab){
                    $scope.tab = setTab;
                };
                $scope.isSelected = function(checkTab){
                    return $scope.tab === checkTab;
                }
               
            }])
                .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.otherwise({redirectTo: '/view1'});
    }]);
