{!! Form::open(['action' => ['ProductsController@getSearchRedirect'], 'role' => 'form', 'method' => 'get', 'class' => 'form-inline mb20', 'ng-controller' => 'ProductSearchFormController']) !!}
	<div class="form-group">
		{!! Form::select(
			'brand_alias', 
			['' => Lang::get('Seleccione una marca')] + Brand::orderBy('order')->lists('name', 'alias')->all(),
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
			['' => Lang::get('Seleccione un rubro')] + ProductCategory::orderBy('name_es')->where('status', 1)->lists('name_es', 'alias_es')->all(),
			$selected_category, 
			[                    
				'id' => 'category',
				'class' => 'form-control',
				'ng-model' => 'category',
				'ng-initial'
			]) 
		!!}
	</div>
	<button type="submit" class="btn btn-default" ng-disabled="brand == '' || category == ''"><span class="glyphicon glyphicon-search"></span> @lang('Buscar')</button>
{!! Form::close() !!}