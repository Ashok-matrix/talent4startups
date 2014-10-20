{{ Form::open(['route' => isset( $project ) ? array('projects.update',$project['url']): 'projects.store','method'=>isset( $project ) ? 'PUT': 'POST']) }}

	<div class="form-group">
		{{ Form::label('name', 'The project is titled:') }}
		{{ Form::text('name', isset( $project ) ? $project->name : null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::label('goal', 'The goals of this project are...:') }}
		{{ Form::text('goal', isset( $goal ) ? $project->goal : null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('stage_id', 'Stage my project is :') }}
		{{ Form::select('stage_id', $stages,null ); }}

	</div>
	<div class="form-group">
		{{ Form::label('description', 'Description:') }}
		{{ Form::textarea('description', isset( $project ) ? $project->description : null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::label('image', 'Image:') }}
		{{ Form::file('image', null, ['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		{{ Form::label('tags', 'Tags:') }}
		
		{{ Form::select('tags[]', $tags, $projectTags, array('multiple')); }}
	</div>
	<div class="form-group">
		{{ Form::label('video', 'link to project video:') }}
		{{ Form::text('video', isset( $video ) ? $project->video : null, ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::submit( isset( $project ) ? 'Update Project' : 'Save Project', ['id' => 'submit-project','class' => 'btn btn-primary']) }}
	</div>

{{ Form::close() }}
