'use strict';

angular.module('myApp.view2', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/view2', {
    templateUrl: 'view2/view2.html',
    controller: 'View2Ctrl'
  });
}])

.controller('View2Ctrl', ['$scope', '$http', function ($scope, $http) {
        		// create a blank object to hold our form information
			// $scope will allow this to pass between controller and view
			
                        $scope.formData = {};
                       
                        
			// process the form
			$scope.processForm = function() {
                                
				$http({
			        method  : 'POST',
			        url     : 'Controller3.php',
			        data    :  $.param($scope.formData), 
                                 headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
			    })
			        .success(function(data) {
			            console.log(data);
			            	
			            if (!data.success) {
			            	// if not successful, bind errors to error variables
			                $scope.errorTitle = data.errors.title;
			                $scope.errorDetails = data.errors.details;
                                        $scope.message = data.message;
			            } else {
			            	// if successful, bind success message to message
			                $scope.message = data.message;
                                        $scope.errorTitle = '';
			                $scope.errorDetails = '';
                                        $scope.formData = {};
			            }			            
			        });

			};
}]);