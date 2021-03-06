<?php

use Illuminate\Support\Facades\Redirect;
use Informulate\Forms\RegistrationForm;
use Informulate\Registration\RegisterUserCommand;
use Informulate\Users\Profile;
use Informulate\Core\CommandBus;

class RegistrationController extends BaseController {

	use CommandBus;

	/**
	 * @var RegistrationForm
	 */
	private $registrationForm;

	/**
	 * Constructor
	 *
	 * @param RegistrationForm $registrationForm
	 */
	function __construct(RegistrationForm $registrationForm)
	{
		$this->registrationForm = $registrationForm;

		$this->beforeFilter('guest');
	}


	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{	
		
		if(!Session::has('userType'))
		{
			return redirect::to('/');
		}
		return View::make('registration.create');
	}

	/**
	 * Save the user.
	 */
	public function store()
	{
		$data = Input::all();

		if(!Session::has('userType')){

    		    Session::put('userType', $data['user_type']);
		}

		if(array_key_exists('submit-registration',$data))
		{
		//validate submitted form	
		$validator = $this->registrationForm->validate(Input::all());
	
		extract(Input::only('username', 'email', 'password'));

		$user = $this->execute(
			new RegisterUserCommand($username, $email, $password)
		);

		Auth::login($user);
		
		//create user profile and store user_type in profile table	
		
		$profile = new Profile(array('user_type'=>Session::get('userType')));		

		$profile = $user->profile()->save($profile);
		
		//destroy user type session
		
		Session::forget('userType');

		Flash::message('Welcome to Talent4Startups');

		return Redirect::to('profile');
		}
		
		return View::make('registration.create');
	}
}
