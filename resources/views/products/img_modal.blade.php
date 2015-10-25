<script type="text/ng-template" id="product-modal">
	<div class="modal-header">
		<button ng-click="close()" type="button" class="close">x</button>
		<h3>%%item.name_es%%</h3>                   
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-8">
				<div class="text-center">
					<img class="img-responsive" ng-src="/images/products/lg/%%item.images[imgIndex].filename%%" alt="%%item.name_es%%" title="%%item.name_es%%" />
				</div>
			</div>
			<div class="col-md-4">
				<ul class="list-inline">
					<li ng-repeat="image in item.images">
						<img class="img-responsive cursor-pointer thumb" ng-class="{'active': imgIndex == $index}" ng-src="/images/products/sm/%%image.filename%%" alt="%%item.name_es%%" title="%%item.name_es%%" ng-click="showImage($index)" style="max-width: 100px;" />
					</li>
				</ul>
				<div class="product-price mt20">
					{{ config('app.currency') }} <big>%%item.price_ars%%</big>
				</div>
				<div class="text-center mt20">
					<button class="btn btn-success btn-block" ng-click="openQueryModal($event, item)">
						@lang('buttons.products.ask')
					</button>
				</div>				
			</div>
		</div>		
	</div>
</script>