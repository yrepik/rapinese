{!! Form::open(['action' => ['ProductsController@getSearchRedirect'], 'role' => 'form', 'method' => 'get', 'class' => 'form-inline hidden-print mb20', 'ng-controller' => 'ProductSearchFormController']) !!}
	<div class="form-group">
		{!! Form::select(
			'brand_alias', 
			['' => trans('labels.products.search.brand')] + Brand::orderBy('order')->lists('name', 'alias')->all(),
			$selected_brand, 
			[                    
				'id' => 'brand',
				'class' => 'form-control',
				'ng-model' => 'brand',
				'ng-initial'
			]) 
		!!}
	</div>
	<div class="form-group">
		{!! Form::select(
			'category_alias', 
			['' => trans('labels.products.search.category')] + ProductCategory::orderBy('name_es')->where('status', 1)->lists('name_es', 'alias_es')->all(),
			$selected_category, 
			[                    
				'id' => 'category',
				'class' => 'form-control',
				'ng-model' => 'category',
				'ng-initial'
			]) 
		!!}
	</div>
	<div class="form-group" 		
		uib-tooltip="@lang('tooltips.products.select_brand_and_category')" 
		tooltip-placement="bottom"
		tooltip-enable="brandOrCategoryNotSelected()">
		<button 
			type="submit" 
			class="btn btn-default" 
			ng-disabled="brandOrCategoryNotSelected()">
			<span class="glyphicon glyphicon-search"></span> @lang('buttons.products.search')
		</button>
	</div>
{!! Form::close() !!}