{{ Form::open(['route' => 'edit_profile','files'=>'true','name'=>'profile-form','id'=>'profile-form']) }}

	<div class="form-group">
		{{ Form::label('first_name', 'First Name:') }}
		{{ Form::text('first_name', isset($profileInfo)? $profileInfo['first_name']:null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::label('last_name', 'Last Name:') }}
		{{ Form::text('last_name', isset($profileInfo)? $profileInfo['last_name']:null, ['class' => 'form-control']) }}
	</div>	
	<div class="form-group">
		{{ Form::label('location', 'Your Location:') }}
		{{ Form::text('location',isset($profileInfo)? $profileInfo['location']:null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
	     {{ Form::label('agerange', 'Age Range:') }}
		{{ Form::select('agerange', [
				   '0-18' => 'Under 18',
				   '19-30' => '19 to 30',
				   '30-above' => 'Over 30'],
				   isset($profileInfo)? $profileInfo['agerange']:null
				) }}
	</div>
	<div class="form-group">
		{{ Form::label('describe', 'I\'m best describes as a:') }}
		 {{ Form::select('describe', $describes,$profileInfo['describe']); }}
	</div>
	<div class="form-group">
		{{ Form::label('skills', 'I\'m skilled in :') }}
		{{ Form::select('skills[]', $skills,$profileSkills,array('multiple')); }}

	</div>
	<div class="form-group">
		{{ Form::label('workexperience', 'Work Experience:') }}
		{{ Form::text('workexperience',isset($profileInfo)?$profileInfo['workexperience']:null, ['class' => 
		'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('about', 'Summary about who you are :') }}
		{{ Form::textarea('about',isset($profileInfo)?$profileInfo['about']:null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('image', 'Profile Image :') }}
		{{ Form::file('image', ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('facebook', 'Facebook:') }}
		{{ Form::text('facebook',isset($profileInfo)?$profileInfo['facebook']:null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('linkedins', 'Linkedin:') }}
		{{ Form::text('linkedins', isset($profileInfo)?$profileInfo['linkedins']:null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('twitter', 'Twitter:') }}
		{{ Form::text('twitter',isset($profileInfo)?$profileInfo['twitter']:null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('meetup', 'Meetup:') }}
		{{ Form::text('meetup',isset($profileInfo)?$profileInfo['meetup']:null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::submit('Continue', ['id' => 'submit-profile','class' => 'btn btn-primary']) }}
	</div>
{{ Form::close() }}
