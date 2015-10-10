var componentsModule = angular.module('components', []);
componentsModule.directive('selectAllCheckbox', function() {
    return {
        replace: true,
        restrict: 'E',
        scope: {
            checkboxes: '=',
            //allselected: '=allSelected',
            //allclear: '=allClear'
        },
        template: '<input type="checkbox" ng-model="master" ng-change="masterChange()" />',
        controller: function($scope, $element) {

            $scope.masterChange = function() {
                if ($scope.master) {
                    angular.forEach($scope.checkboxes, function(cb, index) {
                        cb.isSelected = true;
                    });
                } else {
                    angular.forEach($scope.checkboxes, function(cb, index) {
                        cb.isSelected = false;
                    });
                }
            };

            $scope.$watch('checkboxes', function() {
                var allSet = true,
                    allClear = true;
                angular.forEach($scope.checkboxes, function(cb, index) {
                    if (cb.isSelected) {
                        allClear = false;
                    } else {
                        allSet = false;
                    }
                });

                if ($scope.allselected !== undefined) {
                    $scope.allselected = allSet;
                }
                if ($scope.allclear !== undefined) {
                    $scope.allclear = allClear;
                }

                $element.prop('indeterminate', false);
                if (allSet) {
                    $scope.master = true;
                } else if (allClear) {
                    $scope.master = false;
                } else {
                    $scope.master = false;
                    $element.prop('indeterminate', true);
                }

            }, true);
        }
    };
});


var appModule = angular.module('app', ['components', 'ui.bootstrap']);

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
}).service('ArrayParamsFixerService', function() {
    this.fix = function(params) {
        var fixedParams = {};
        angular.forEach(params, function(value, key) {
            if (value instanceof Array) {
                fixedParams[key + '[]'] = value;
            } else {
                fixedParams[key] = value;
            }
        });
        return fixedParams;            
    };
}).directive('autoClose', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            window.setTimeout(function() { 
                element.alert('close'); 
            }, 8000);
        }
    }; 
}).directive('stopPropagation', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            element.on('click', function(event) {
                event.stopPropagation();
            });
        }
    };
})/*.directive('onFinishRender', function($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function() {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
})*/;