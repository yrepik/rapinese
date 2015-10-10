<script type="text/ng-template" id="product-query-modal">
	<div class="modal-header">
		<button ng-click="close()" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3>Consulta por producto %%item.name_es%%</h3>
	</div>
	<div class="modal-body">
		<div ng-show="sending"></div>
		<div ng-show="result != null && !sending" class="alert" ng-class="{'alert-success': result == true, 'alert-danger': result == false}">
			%%msg%%
		</div>
		<div ng-show="errors.length > 0 && !sending" class="alert alert-danger">
			<h3>Verifique los siguientes errores:</h3>
			<ul ng-repeat="error in errors">
				<li></li>
			</ul>
		</div>
		<div ng-show="result != true">
			{!! Form::open(['role' => 'form', 'class' => '', 'ng-submit' => 'sendForm($event)']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('name', 'Nombre y Apellido') !!}
							{!! Form::text('name', null, ['class' => 'form-control', 'ng-model' => 'name', 'ng-disabled' => 'sending']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('email', 'E-mail') !!}
							{!! Form::email('email', null, ['class' => 'form-control', 'ng-model' => 'email', 'ng-disabled' => 'sending']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('tel', 'Teléfono') !!}
							{!! Form::text('tel', null, ['class' => 'form-control', 'ng-model' => 'tel', 'ng-disabled' => 'sending']) !!}
						</div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('comments', 'Comentarios') !!}
							{!! Form::textarea('comments', null, ['class' => 'form-control', 'ng-model' => 'comments', 'ng-disabled' => 'sending']) !!}
						</div>
					</div>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-large btn-info" ng-disabled="sending">
						Send
					</button>
					<i ng-show="sending" class="fa fa-spinner fa-pulse fa-4"></i>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</script>