@extends('layouts.default')

@section('content')

	<div class="row">
		<div class="col-md-8">
			<h1>{{ $project->name }}</h1>
			<input id="project-rating" rate-user="{{$project->owner->id}}" value="{{(is_array($project->ratings($project->owner->id)->lists('rating')) && sizeof($project->ratings($project->owner->id)->lists('rating'))>0)?$project->ratings($project->owner->id)->sum('rating')/$project->ratings($project->owner->id)->count('rating'):0 }}" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
			<img data-src="holder.js/800x300" alt="...">

			<p>{{ $project->description }}</p>

			@if($project->hasMember($currentUser))
				@if($project->hasPendingInvitationFrom($currentUser))
					Your request is still been considered, would you like to <a href="{{ route('project_membership_request_cancel', ['url' => $project->url]) }}">cancel this request?</a>
				@endif
			@endif

			@if($project->owner != $currentUser and false === $project->hasPendingInvitationFrom($currentUser) and false == $project->hasMember($currentUser))
				<a class="btn btn-primary" href="{{ route('project_membership_request', ['url' => $project->url]) }}">Join this project</a>
			@endif

			<div>
				@foreach($project->tags as $tag)
					<span class="badge">{{ $tag->name }}</span> &nbsp;
				@endforeach
			</div>
			@if(is_object($currentUser) && in_array($currentUser->id,$members->lists('id')))
			<div>
				Give your rating
				<input id="contributor-rating" rate-user="{{$project->owner->id}}" value="{{(is_object($project->projectContributorRating($currentUser->id,$project->id)) && sizeof($project->projectContributorRating($currentUser->id,$project->id))>0)?$project->projectContributorRating($currentUser->id,$project->id)->rating:0 }}" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
			</div>
			@endif
		</div>
		<div class="col-md-4">

			@if($project->owner == $currentUser)
				<a class="btn btn-primary btn-xs pull-right" href="{{ route('projects.edit', $project->url) }}">Edit Project</a>
				<h2>Member requests</h2>

				@foreach($requests as $user)
					<div><img class="img-circle" data-src="holder.js/64x64/auto"> {{ $user->profile->first_name }} {{ $user->profile->last_name }} <a class="btn btn-primary btn-xs" href="{{ route('project_membership_update', ['projectUrl' => $project->url, 'userId' => $user->id, 'action' => 'approve']) }}">Approve</a> <a class="btn btn-primary btn-xs" href="{{ route('project_membership_update', ['projectUrl' => $project->url, 'userId' => $user->id, 'action' => 'reject']) }}">Reject</a></div>
				@endforeach

			@endif

			<h2>Project Contributors</h2>
			@foreach($members as $user)
							<div><img class="img-circle" data-src="holder.js/64x64/auto"> {{ $user->profile->first_name }} {{ $user->profile->last_name }}</div>
							<input rate-user="{{$user->id}}" value="{{(is_object($user->userProjectRating($user->id,$project->id)) && sizeof($user->userProjectRating($user->id,$project->id))>0)?$user->userProjectRating($user->id,$project->id)->rating:0 }}" type="number" class="rating owner-rating" min=0 max=5 step=0.5 data-size="sm"> 
			@endforeach

		</div>
	</div>


	<script src="{{{ asset('js/star-rating.js') }}}" type="text/javascript"></script>

	<script type="text/javascript">
	jQuery(document).ready(function () {
		if ( $( "#contributor-rating" ).length >0 ) {
			var disable = "<?php echo is_object($currentUser)? in_array($currentUser->id,$members->lists('id'))?false:true:true; ?>";
			$('#contributor-rating').rating('refresh', {disabled: disable, showClear: false, showCaption: true});
			$('#contributor-rating').on('rating.change', function() {
            var projectId = "{{$project->id}}";
		    var provider = "{{is_object($currentUser)?$currentUser->id:null}}";
		    var receiver = $(this).attr('rate-user');
		    var rate = $(this).val();
		    saveRating(projectId,provider,receiver,rate);
        })
	}

	$('#project-rating').rating('refresh', {disabled: true, showClear: false, showCaption: true});

	var disable = "<?php echo $project->owner == $currentUser?false:true; ?>";
		$('.owner-rating').rating('refresh', {disabled: disable, showClear: false, showCaption: true});
		$('.owner-rating').on('rating.change', function() {
        var projectId = "{{$project->id}}";
		var provider = "{{is_object($currentUser)?$currentUser->id:null}}";
		var receiver = $(this).attr('rate-user');
		var rate = $(this).val();
		// store rating record in database by AJAX
		saveRating(projectId,provider,receiver,rate);
        })
	});

		/*
		* store rating record in database
		* @param projectId int, provider int, receiver int, rate string
		*/
		var saveRating = function(projectId,provider,receiver,rate){
		var request = $.ajax({
		url: "{{ route('save_rating') }}",
		type: "POST",
		data: { receiverId : receiver,providerId: provider,projectId:projectId,rate:rate },
		dataType: "html"
		});

		request.done(function( msg ) {
			$( "#log" ).html( msg );
		});

		request.fail(function( jqXHR, textStatus ) {
			alert( "Request failed: " + textStatus );
		});
		}
	</script>
@stop