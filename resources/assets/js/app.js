var appModule = angular.module('app', ['ui.bootstrap']);

appModule.config(function($interpolateProvider, $httpProvider) {
    $interpolateProvider.startSymbol('%%');
    $interpolateProvider.endSymbol('%%');
    $httpProvider.interceptors.push(['$q', function($q) {
        return function(promise) {
            return promise.then(function(successfulResponse) {
                return successfulResponse; 
            }, function(errorResponse) {
                if (errorResponse.status === 401) {                    
                    alert('auth!');
                    return errorResponse;
                } else if (1 < 0) {

                }
                return $q.reject(errorResponse);
            });
        };
    }]);
});

appModule.directive('wait', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            scope.$watch(attrs.waitWatch, function(val) {
                (val) ? element.addClass('cursor-wait') : element.removeClass('cursor-wait');
            });
        }
    };
});