<script type="text/ng-template" id="product-modal">
	<div class="modal-header">
		<button ng-click="close()" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3>%%item.code%% - %%item.name_es%%</h3>                   
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-8">
				<div class="text-center">
					<img class="img-responsive" ng-src="/images/products/%%item.images[imgIndex].filename%%" alt="%%item.descripcion_es%%" title="%%item.descripcion_es%%" />
				</div>
			</div>
			<div class="col-md-4">
				<ul class="list-inline">
					<li ng-repeat="image in item.images">
						<img class="img-responsive cursor-pointer thumb" ng-class="{'active': imgIndex == $index}" ng-src="/images/products/%%image.filename%%" alt="%%item.descripcion_es%%" title="%%item.descripcion_es%%" ng-click="showImage($index)" style="width: 100px;" />
					</li>
				</ul>
			</div>
		</div>		
	</div>
</script>