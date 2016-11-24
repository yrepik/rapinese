var cartModule = angular.module('cart', ['app', 'angular-confirm']);

cartModule.controller('CartController', function($scope, $http, $filter) {

    $scope.total = null;
    $scope.content = null;
    $scope.shipment = 'oca';
    $scope.shippingDisabled = false;
    $scope.shippingOptions = [];
    //$scope.shippingCost = null;
    $scope.zipCode = '';
    $scope.calculatingShippingCost = false;
    $scope.shippingCostCalcFailed = false;

    $scope.init = function(content, count, total) {
        $scope.total = total;
        $scope.content = content;
        if (count > 3) {
            $scope.shipment = 'pickup';
            $scope.shippingDisabled = true;
        }
    };

    $scope.calculateShippingCostDisabled = function() {
        return $scope.zipCode.length < 4 || $scope.calculatingShippingCost;
    };

    $scope.getShippingOptions = function() {
        var element = angular.element('#calc-shipping-cost');
        $scope.calculatingShippingCost = true;
        $http.post(element.data('request-path'), {zipCode: $scope.zipCode}).success(function(data, status, headers, config) {
            $scope.shippingCostCalcFailed = false;
            $scope.shippingOptions = data.response.options;
        }).error(function(data, status, headers, config) {
            $scope.shippingOptions = [];
            $scope.shippingCostCalcFailed = true;
        }).finally(function(data, status, headers, config) {
            $scope.calculatingShippingCost = false;
        });
    };

    $scope.sarasa = function($event) {
        if ($event.keyCode == 13 && !$scope.calculateShippingCostDisabled()) {
            $event.preventDefault();
            $scope.getShippingOptions();
        }
    };

});
