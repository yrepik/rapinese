{!! Form::open(['route' => 'products-search-redirect', 'role' => 'form', 'method' => 'post', 'class' => 'row hidden-print mb20', 'ng-controller' => 'ProductSearchFormController', 'ng-cloak']) !!}
	<div class="col-md-3 col-sm-4">
		<div class="form-group">
			{!! Form::select(
				'brand_alias',
				['' => trans('labels.select_brand')] + $brands,
				$selected_brand,
				[
					'id' => 'brand',
					'class' => 'form-control',
					'ng-model' => 'brand',
					'ng-initial'
				])
			!!}
		</div>
	</div>
	<div class="col-md-4 col-sm-5">
		<div class="form-group">
			{!! Form::select(
				'category_alias',
				['' => trans('labels.select_category')] + $categories,
				$selected_category,
				[
					'id' => 'category',
					'class' => 'form-control',
					'ng-model' => 'category',
					'ng-initial'
				])
			!!}
		</div>
	</div>
	<div class="col-md-2 col-sm-3">
		<div class="form-group"
			uib-tooltip="@lang('tooltips.products.select_brand_and_category')"
			tooltip-placement="bottom"
			tooltip-enable="brandOrCategoryNotSelected()">
			<button
				type="submit"
				class="btn btn-default btn-block"
				ng-disabled="brandOrCategoryNotSelected()">
				<span class="glyphicon glyphicon-search"></span> @lang('buttons.search')
			</button>
		</div>
	</div>
{!! Form::close() !!}
