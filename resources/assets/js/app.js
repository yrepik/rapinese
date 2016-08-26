var appModule = angular.module('app', ['ui.bootstrap']);

appModule.directive('ngInitial', function($parse) {
    return {
        restrict: 'A',
        compile: function($element, $attrs) {
            var initialValue = $attrs.value || $element.val();
            return {
                pre: function($scope, $element, $attrs) {
                    $parse($attrs.ngModel).assign($scope, initialValue);
                }
            };
        }
    };
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

appModule.directive('prompt', ['$confirm', '$window', function($confirm, $window) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.on('click', function($event) {
                $event.preventDefault();
                $confirm({title: attrs.promptTitle, ok: attrs.promptOk, cancel: attrs.promptCancel}, {template: '<div class="modal-header"><h3 class="modal-title">{{ data.title }}</h3></div>' +
                    '<div class="modal-body">' + attrs.promptText + '</div>' +
                    '<div class="modal-footer">' +
                    '<button class="btn btn-danger" ng-click="ok()">{{ data.ok }}</button>' +
                    '<button class="btn btn-default" ng-click="cancel()">{{ data.cancel }}</button>' +
                    '</div>'
                }).then(function() {
                    $window.location.href = attrs.promptConfirmUrl;
                });
            });
        }
    };
}]);
