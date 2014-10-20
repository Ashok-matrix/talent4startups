<?php

use Illuminate\Support\Facades\Redirect;
use Informulate\Forms\ProjectForm;
use Informulate\Projects\CreateNewProjectCommand;
use Informulate\Core\CommandBus;
use Informulate\Projects\Project;
use Informulate\Projects\ProjectRepository;
use Informulate\Users\User;
use Informulate\Users\Profile;
use Informulate\Tags\Tag;
use Informulate\Stages\Stage;

class ProjectController extends BaseController {

	use CommandBus;

	/**
	 * @var ProjectForm
	 */
	private $projectForm;

	/**
	 * Constructor
	 *
	 * @param ProjectForm $projectForm
	 */
	function __construct(ProjectForm $projectForm)
	{
		$this->projectForm = $projectForm;
		$this->beforeFilter('auth', ['except' => ['index', 'show']]);
	}

	/**
	 * Index that shows all projects.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = Project::paginate(16);
		return View::make('project.index')
			->with('projects', $projects);
	}

	/**
	 * Show the form for creating a new project if your is startup.
	 *
	 * @return Response
	 */
	public function create()
	{
		$profileInfo = Profile::where('user_id','=',Auth::id())->first();
		if($profileInfo['user_type']=='T'){
                //redirect to home if user is talent
			return Redirect::intended('')->with('error','Talents do not have permission to 				create project');
		}
		$tags   = Tag::lists('name','id');
		$stages = Stage::lists('name','id');
		return View::make('project.create')->with('tags',$tags)->with('projectTags','')
				->with('stages',$stages);
	}

	/**
	 * Save the user.error
	 */
	public function store()
	{
		$this->projectForm->validate(Input::all());
		extract(Input::only('name', 'description','tags'));		
		$project = $this->execute(
			new CreateNewProjectCommand(Auth::user(), $name, $description)
		);		
		Tag::newProjectTags($project,$tags); //assign tags to projects
		Flash::message('New Project Created');
		return Redirect::route('projects.show', ['url' => $project->url]);
	}

	/**
	 * Display a project
	 *
	 * @param $project
	 * @return \Illuminate\View\View
	 */
	public function show($project)
	{
		$project = Project::where('url', '=', $project)->firstOrFail();
		$requests = $project->members()->where('pending', true)->get();
		$members = $project->members()->where('approved', true)->get();

		return View::make('project.show')->with('project', $project)->with('requests', $requests)->with('members', $members);
	}

	public function approveMember($project, $userId)
	{
		if ($project->owner == Auth::user()) {
			$user = User::find($userId);
			if (false == $project->hasMember($user)) {
				//
			}
		}
	} 

	 /*
	 * load view for edit project with tags
	 * @param string $project (url)
	 */
	public function edit($project){
		$tags = Tag::lists('name','id');
		$project = Project::where('url', '=', $project)->firstOrFail();
		$stages = Stage::lists('name','id');
		$projectTags = Tag::listProjectTags($project);
		return View::make('project.edit')->with('project',$project)
				->with('projectTags',$projectTags)->with('tags',$tags)
				->with('stages',$stages);
	}


	 /*
	 * Update project in storage
	 * @param string url	
	 */
	public function update($projectUrl){
	    $this->projectForm->validate(Input::all());
	    $project 	   	  = Project::where('url', '=', $projectUrl)->firstOrFail();
            $project->name 	  = Input::get('name');
            $project->description = Input::get('description');
            $project->save();
	    $tags = Input::get('tags');
            Tag::updateProjectTags($project,$tags);	
	    // redirect
            Flash::message('Project updated successfullly!');
	    return  Redirect::action('ProjectController@show',$projectUrl);
                
	}


	/**
	 * Destroy a record.
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		// TODO: Implement proper project deactivation (We don't want to delete it we just want to deactivate it)
	}
}
