{{ Form::open(['route' => 'login_path']) }}

	<div class="form-group">
		{{ Form::label('email', 'Email:') }}
		{{ Form::text('email', null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password:') }}
		{{ Form::password('password', ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::submit('Login', ['id' => 'submit-login','class' => 'btn btn-primary']) }}
	</div>

{{ Form::close() }}
