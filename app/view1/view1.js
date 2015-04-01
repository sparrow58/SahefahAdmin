'use strict';

angular.module('myApp.view1', ['ngRoute'])

        .config(['$routeProvider', function ($routeProvider) {
                $routeProvider.when('/view1', {
                    templateUrl: 'view1/view1.html',
                    controller: 'View1Ctrl'
                });
            }])
        .controller('View1Ctrl', ['$scope', '$http', '$modal', '$log', function ($scope, $http, $modal, $log) {
                $scope.alerts = [
                    
                    {type: 'success', msg: 'تم حذف الخبر'}
                ];
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

                $scope.editItem = function (news) {
                    news.editing = true;
                }

                $scope.doneEditing = function (news) {
                    news.editing = false;
                    //dong some background ajax calling for persistence...

                };



                $scope.open = function (size, item) {
                    //$scope.ids = item.id;
                    var news_to_delete = $scope.allNews.posts[item];
                    $scope.allNews.posts.splice(item, 1);

                    $scope.ids = news_to_delete;
                    //console.log(ids);
                    var modalInstance = $modal.open({
                        templateUrl: 'templates/deleteModel.html',
                        controller: 'ModalInstanceCtrl',
                        size: size,
                        resolve: {
                            ids: function () {
                                return $scope.ids;
                            }

                        }

                    });



                    modalInstance.result.then(function (selectedItem) {
                        $scope.selected = selectedItem;
                    }, function () {
                        $log.info('Modal dismissed at: ' + new Date());
                    });
                };

            }])
        .controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'ids', '$http', '$route', function ($scope, $modalInstance, ids, $http, $route) {

                $scope.news = ids;
                $scope.selected = {
                    ids: $scope.ids
                };
                $scope.msg = 'done';

                $scope.ok = function () {
                    $modalInstance.close();


                    $http({
                        method: 'POST',
                        url: 'Controller4.php',
                        data: $.param({id: ids.id}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                            .success(function (data) {
                                console.log(data);

                               if (!data.success) {
                                    // if not successful, bind errors to error variables
                                    $scope.errorTitle = data.errors.title;
                                    $scope.errorDetails = data.errors.details;
                                    $scope.msg = data.msg;
                                } else {
                                    // if successful, bind success message to message
                                    $scope.msg = data.msg;
                                    $scope.errorTitle = '';
                                    $scope.errorDetails = '';
                                    $scope.formData = {};
                                }
                                $scope.formData = {};

                            });

                };


                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                    $route.reload();
                };
            }])



 