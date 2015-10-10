<div affix style="margin-bottom: 20px;">
	<div id="cuco">
		{!! Form::open(['action' => ['ProductsController@postSearchRedirect'], 'role' => 'form', 'class' => 'form-inline', 'style' => 'margin-bottom: 0;']) !!}
			<div class="form-group">
				{!! Form::select(
					'brand_id', 
					['' => 'Seleccione una marca'] + Brand::orderBy('order')->lists('name', 'alias')->all(),
					$selected_brand, 
					[                    
						'id' => 'brand',
						'class' => 'form-control',
						'ng-modelo' => 'brand'
					]) 
				!!}
			</div>
			<div class="form-group">
				{!! Form::select(
					'category_id', 
					['' => 'Seleccione un rubro'] + ProductCategory::orderBy('name_es')->where('status', 1)->lists('name_es', 'alias_es')->all(),
					$selected_category, 
					[                    
						'id' => 'category',
						'class' => 'form-control',
						'ng-modelo' => 'category'
					]) 
				!!}
			</div>
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Buscar</button>
		{!! Form::close() !!}	
	</div>
</div>