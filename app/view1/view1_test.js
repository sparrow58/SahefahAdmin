'use strict';

describe('myApp.view1 module', function () {


    describe('view1 controller', function () {
        var scope, ctrl, $httpBackend;

        beforeEach(module('myApp.view1'));
        beforeEach(inject(function (_$httpBackend_, $rootScope, $controller) {
            $httpBackend = _$httpBackend_;
            $httpBackend.expectGET('view1/news.json').
                    respond([{title: 'خبر طري'}]);

            scope = $rootScope.$new();
            ctrl = $controller('View1Ctrl', {$scope: scope});
        }));
        
        
        it('should create news model with 1 news fetched from xhr', function () {
            expect(scope.allNews).toBeUndefined();
            $httpBackend.flush();

            expect(scope.allNews).toEqual([{title: 'خبر طري'}]);
        });
        
        
    });
});