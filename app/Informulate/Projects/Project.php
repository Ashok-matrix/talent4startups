<?php namespace Informulate\Projects;

use DB;
use Informulate\Projects\Events\ProjectCreated;
use Informulate\Users\User;
use Informulate\Ratings\Rating;
use Laracasts\Commander\Events\EventGenerator;
use Eloquent;

class Project extends Eloquent {

	use EventGenerator;

	/**
	 * Fillable fields for a new project
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'name', 'description', 'url', 'goal' , 'stage_id' , 'video'];

	/**
	 * Create a new project
	 *
	 * @param $attributes
	 * @return static
	 */
	public static function create(array $attributes)
	{
		$project = new static($attributes);

		$project->raise(new ProjectCreated($project));

		return $project;
	}

	/**
	 * The project's owner
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo('Informulate\Users\User', 'user_id');
	}

	/**
	 * The project members
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function members()
	{
		return $this->belongsToMany('Informulate\Users\User');
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function hasMember(User $user = null)
	{
		if ($user) {
			return !is_null(
				DB::table('project_user')
					->where('project_id', $this->id)
					->where('user_id', $user->id)
					->first()
			);
		}

		return false;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function hasPendingInvitationFrom(User $user = null)
	{
		if ($user) {
			return !is_null(
				DB::table('project_user')
					->where('project_id', $this->id)
					->where('user_id', $user->id)
					->where('pending', true)
					->first()
			);
		}

		return false;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags()
	{
		return $this->belongsToMany('Informulate\Tags\Tag');
	}

	/**
	 * The project's rating
	 * @param $owner_id
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function ratings($owner_id)
	{
		return $this->hasMany('Informulate\Ratings\Rating')->where('receiver_id','=',$owner_id);
	}

	/**
	 * The contributor rating to project
	 * @param $receiver_id
	 * @param $project_id
	 * @return object
	 */
	public function projectContributorRating($contributor_id,$project_id)
	{
		return Rating::where('project_id','=',$project_id)->where('provider_id','=',$contributor_id)->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function describes()
	{
		return $this->belongsToMany('Informulate\Describes\Describe');
	}
}
