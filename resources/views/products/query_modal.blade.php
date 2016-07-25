<script type="text/ng-template" id="product-query-modal">
	<div class="modal-header">
		<button ng-click="close()" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3>@lang('headers.products.ask')<br />%%item.name_es%%</h3>
	</div>
	<div class="modal-body">
		<div ng-show="sending"></div>
		<div ng-show="result != null && errors.length == 0 && !sending" class="alert" ng-class="{'alert-success': result == true, 'alert-danger': result == false}">
			%%msg%%
		</div>
		<div ng-show="errors.length > 0 && !sending" class="alert alert-danger alert-dismissible" role="alert">
			<!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
			<h5>@lang('headers.verify_errors')</h5>
			<ul>
				<li ng-repeat="error in errors">%%error%%</li>
			</ul>
		</div>
		<div ng-show="result != true">
			{!! Form::open(['role' => 'form', 'class' => '', 'ng-submit' => 'sendForm($event)', 'novalidate']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('name', trans('labels.name')) !!}
							{!! Form::text('name', null, ['class' => 'form-control', 'ng-model' => 'name', 'ng-disabled' => 'sending']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('email', trans('labels.email')) !!}
							{!! Form::email('email', null, ['class' => 'form-control', 'ng-model' => 'email', 'ng-disabled' => 'sending']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('tel', trans('labels.tel')) !!}
							{!! Form::text('tel', null, ['class' => 'form-control', 'ng-model' => 'tel', 'ng-disabled' => 'sending']) !!}
						</div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('comments', trans('labels.comments')) !!}
							{!! Form::textarea('comments', null, ['class' => 'form-control', 'ng-model' => 'comments', 'ng-disabled' => 'sending']) !!}
						</div>
					</div>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-large btn-info" ng-disabled="sending">
						@lang('buttons.send_query')
					</button>
					<i ng-show="sending" class="fa fa-spinner fa-pulse fa-4"></i>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</script>