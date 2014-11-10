<?php namespace Informulate\Ratings;

use Eloquent;

class Rating extends Eloquent  {

	/**
	 * Fields that are mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['project_id', 'provider_id', 'receiver_id', 'rating'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ratings';

	/**
	 * User Ratings
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
	{
		return $this->belongsTo('Informulate\Users\User');
	}

	/**
	 *Project ratings
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function projects()
	{
		return $this->belongsTo('Informulate\Projects\Project');
	}

}
