var productsModule = angular.module('products', ['app']);

productsModule.controller('ProductSearchFormController', function($scope) {
	$scope.brand;
	$scope.category;	
	$scope.brandOrCategoryNotSelected = function() {
		return $scope.brand == '' || $scope.category == '';
	};
});

productsModule.controller('ProductSearchResultsController', function($scope, $uibModal, $http) {
	$scope.items = [];
	$scope.cart = [];
	$scope.addingToCart = false;
	$scope.addingToCartIndex = null;

	$scope.init = function($json, $cart) {
		$scope.items = $json.data;
		$scope.cart = $cart;	
	};

	$scope.openModal = function($event, $index) {
		$event.preventDefault();
		var modalInstance = $uibModal.open({
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
		var modalInstance = $uibModal.open({
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

	$scope.addToCart = function($event, $index, url, cartUrl) {
		$event.preventDefault();
		$scope.addingToCart = true;
		$scope.addingToCartIndex = $index;
		$http.get(url)
			.success(function(data, status, headers, config) {
				$http.get(cartUrl)
					.success(function(data, status, headers, config) {
						$scope.cart = data;
						$scope.addingToCart = false;
						$scope.addingToCartIndex = null;
		  				$scope.openCartModal($index);
			  	}).error(function(data, status, headers, config) {
			  	}).finally(function(data, status, headers, config) {
			  	});
	  	}).error(function(data, status, headers, config) {
	  	}).finally(function(data, status, headers, config) {
	  	});		
	};

	$scope.openCartModal = function($index) {
		var modalInstance = $uibModal.open({
			templateUrl: 'cart-modal',
			controller: 'CartModalController',
			size: 'lg',
			windowClass: 'right',
			resolve: {
				cart: function() {
					return $scope.cart;
				}			
			}
		});
	};

});

productsModule.controller('CartModalController', function($scope, $uibModalInstance, cart) {
	$scope.cart = cart;
	$scope.close = function() {
		$uibModalInstance.dismiss('cancel');	 
	};
});

productsModule.controller('QueryModalController', function($scope, $http, $uibModalInstance, item) {
	$scope.item = item;
	$scope.sending = false;

	$scope.name = null;
	$scope.email = null;
	$scope.tel = null;
	$scope.comments = null;

	$scope.result = null;
	$scope.msg = null;
	$scope.errors = [];

	$scope.close = function() {
		$uibModalInstance.dismiss('cancel');	 
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
  			$scope.errors = data.errors;
	  	}).error(function(data, status, headers, config) {
	  	}).finally(function(data, status, headers, config) {
	  		$scope.sending = false;
	  	});	
	};
});

productsModule.controller('ProductModalController', function($scope, $uibModal, $uibModalInstance, item, itemIndex, items) {
	$scope.item = item;
	$scope.imgIndex = 0;
	$scope.productIndex = itemIndex;
	//$scope.items = items;

	$scope.close = function() {
		$uibModalInstance.dismiss('cancel');    
	};

	$scope.showImage = function($index) {
		$scope.imgIndex = $index;
	};

	$scope.openQueryModal = function($event, $item) {
		$event.preventDefault();
		var modalInstance = $uibModal.open({
			templateUrl: 'product-query-modal',
			controller: 'QueryModalController',
			size: 'lg',
			resolve: {
				item: function() {
					return $item;
				}			
			}
		});
	};		

    /*$scope.nextProduct = function() {
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
    };*/	
});