var cartModule = angular.module('cart', ['app', 'angular-confirm']);

cartModule.controller('CartController', function($scope, $confirm, $window) {

    $scope.confirm = function($event) {
        $event.preventDefault();
        var target = angular.element($event.target);        
        var href = target.attr('href');

        if (angular.isUndefined(href)) {
            target = target.closest('a');
        }

        href = target.attr('href');

        $confirm({title: 'Confirmar', ok: 'Confirmar', cancel: 'Cancelar'}, {template: '<div class="modal-header"><h3 class="modal-title">%%data.title%%</h3></div>' +
            '<div class="modal-body">' + target.data('text') + '</div>' +
            '<div class="modal-footer">' +
            '<button class="btn btn-danger" ng-click="ok()">%%data.ok%%</button>' +
            '<button class="btn btn-default" ng-click="cancel()">%%data.cancel%%</button>' +
            '</div>'
        }).then(function() {
            $window.location.href = href;
        });
    }

});