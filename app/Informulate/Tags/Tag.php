<?php namespace Informulate\Tags;

use Eloquent;
use Informulate\Projects\Project;
class Tag extends Eloquent {
	
	/**
	 * Fields that are mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['tag_id'];


	 /**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function projects()
	{
		return $this->belongsToMany('Informulate\Projects\Project');
	}


	/**
	 * Fetch all tags from storage
	 * @return tag-ids,name
	 */
	public function listTags(){
	   $tags = Tag::lists('name','id');
		return $tags;
	}

	/**
	 * Fetch project's tags from storage
	 * @param Object Project
	 * @return tag ids
	 */
	public function listProjectTags(Project $project){

		$tags = $project->tags;

		return $tags->lists('id');
	}	

	/**	
	* add project's tags
	* @param Object Project,array tags
	*/
	public function newProjectTags(Project $project,$tags){
		if(sizeof($tags)>0){
			// if user selected tags
			foreach($tags as $tagID){
			 $project->tags()->attach($project['id'], array('tag_id' => $tagID));
			}
		}
	}

	/**	
	* Update project's tags
	* @param Object Project,array tags
	*/
	public function updateProjectTags(Project $project,$tags){
		Project::find($project['id'])->tags()->detach();// remove all tags of project
		$this->newProjectTags($project,$tags); //add new tags
	}

	

}
