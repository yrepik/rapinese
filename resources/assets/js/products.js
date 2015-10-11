var productsModule = angular.module('products', ['app']);

productsModule.controller('ProductSearchResultsController', function($scope, $modal) {
	$scope.items = [];

	$scope.init = function($json) {
		$scope.items = $json.data;
	};
	
	$scope.openModal = function($event, $index) {
		$event.preventDefault();
		var modalInstance = $modal.open({
			templateUrl: 'product-modal',
			controller: 'ProductModalController',
			size: 'lg',
			resolve: {
				item: function() {
					return $scope.items[$index];
				},
				itemIndex: function() {
					return $index;
				},
				items: function() {
					return $scope.items;
				}			
			}
		});
	};	

	$scope.openQueryModal = function($event, $index) {
		$event.preventDefault();
		var modalInstance = $modal.open({
			templateUrl: 'product-query-modal',
			controller: 'QueryModalController',
			size: 'lg',
			resolve: {
				item: function() {
					return $scope.items[$index];
				}			
			}
		});
	};	
});

productsModule.controller('QueryModalController', function($scope, $http, $modalInstance, item) {
	$scope.item = item;
	$scope.sending = false;

	$scope.name = null;
	$scope.email = null;
	$scope.tel = null;
	$scope.comments = null;

	$scope.result = null;
	$scope.msg = null;

	$scope.close = function() {
		$modalInstance.dismiss('cancel');	 
	};

	$scope.sendForm = function($event) {
		$event.preventDefault();
		$scope.sending = true;
		$http.post('/products/send-query', {
			name: $scope.name, 
			email: $scope.email, 
			tel: $scope.tel, 
			comments: $scope.comments,
			itemCod: $scope.item.code, 
			itemDescrip: $scope.item.name_es
		}).success(function(data, status, headers, config) {
  			$scope.result = data.result;
  			$scope.msg = data.msg;
	  	}).error(function(data, status, headers, config) {
	  	}).finally(function(data, status, headers, config) {
	  		$scope.sending = false;
	  	});	
	};
});

productsModule.controller('ProductModalController', function($scope, $modalInstance, item, itemIndex, items) {
	$scope.item = item;
	$scope.imgIndex = 0;
	$scope.productIndex = itemIndex;
	$scope.items = item;

	$scope.close = function() {
		$modalInstance.dismiss('cancel');    
	};

	$scope.showImage = function($index) {
		$scope.imgIndex = $index;
	};

    $scope.nextProduct = function() {
		if ($scope.productIndex + 1 >= $scope.items.length) {
			$scope.productIndex = 0;
		} else {
			$scope.productIndex++;
		}
        $scope.item = $scope.items[$scope.productIndex];
        $scope.imgIndex = 0;
    };	

    $scope.prevProduct = function() { 
		if ($scope.productIndex == 0) {
			$scope.productIndex = $scope.items.length - 1;
		} else {
			$scope.productIndex--;
		}
        $scope.item = $scope.pedals[$scope.productIndex];
        $scope.imgIndex = 0;
    };	
});