@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="col-md-3">
			<img class="img-circle img-responsive img-rounded" data-src="holder.js/150x150" alt="...">
		</div>
		<div class="col-md-9">
			<h1>Hi, I’m {{ $user->profile->first_name }} {{ $user->profile->last_name }} located in {{ $user->profile->location }}.</h1>
			<input id="user-rating" rate-user="{{$user->id}}" value="{{(is_object($user->ratings) && sizeof($user->ratings)>0)?round($user->ratings->sum('rating')/$user->ratings->count('rating'),1):0 }}" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm"> 
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h2>My Interests</h2>
			@if(is_object($user->profile->skills))
			@foreach($user->profile->skills as $skill)
				<a href="#"><span class="badge">{{ $skill->name }}</span></a>
			@endforeach
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h2>Projects I’m involved in</h2>
			@if(count($contributions) > 0)
				@foreach($contributions as $project)
				<div class="col-sm-3">
					<div class="clearfix">
						<h4><a href="{{ route('projects.show', $project->url) }}">{{ $project->name }}</a> <small>By: {{ $project->owner->profile->first_name }} {{ $project->owner->profile->last_name }}</small></h4>
						<p>{{ Str::limit( $project->description, 50 ) }}</p>
					</div>
					<div class="clearfix">
						<p><a href="" class="btn btn-primary btn-xs pull-right" role="button">Learn More</a></p>
					</div>
				</div>
				@endforeach
			@else
				<div class="alert alert-info">
					I'm not currently involved in any project.
				</div>
			@endif
		</div>
	</div>
	<script src="{{{ asset('js/star-rating.js') }}}" type="text/javascript"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#user-rating').rating('refresh', {disabled: true, showClear: false, showCaption: true});
	});
	</script>
@stop