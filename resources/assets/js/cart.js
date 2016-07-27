var cartModule = angular.module('cart', ['app', 'angular-confirm']);

cartModule.controller('CartController', function($scope, $confirm, $window, $http, $filter) {

    $scope.subtotal = null;
    $scope.tax = null;
    $scope.total = null;
    $scope.content = null;
    $scope.shipment = 'oca';
    $scope.shippingDisabled = false;
    $scope.shippingOptions = [];
    $scope.zipCode = '';
    $scope.calculatingShippingCost = false;
    $scope.shippingCostCalcFailed = false;

    $scope.init = function(content, count, subtotal, tax, total) {
        $scope.subtotal = $filter('number')(subtotal, 2);
        $scope.tax = $filter('number')(tax, 2);
        $scope.total = $filter('number')(total, 2);
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

    $scope.confirm = function($event) {
        $event.preventDefault();
        var target = angular.element($event.target);        
        var href = target.attr('href');

        if (angular.isUndefined(href)) {
            target = target.closest('a');
            href = target.attr('href');
        }        

        $confirm({title: target.data('title'), ok: target.data('ok'), cancel: target.data('cancel')}, {template: '<div class="modal-header"><h3 class="modal-title">%%data.title%%</h3></div>' +
            '<div class="modal-body">' + target.data('text') + '</div>' +
            '<div class="modal-footer">' +
            '<button class="btn btn-danger" ng-click="ok()">%%data.ok%%</button>' +
            '<button class="btn btn-default" ng-click="cancel()">%%data.cancel%%</button>' +
            '</div>'
        }).then(function() {
            $window.location.href = href;
        });
    };

    

});