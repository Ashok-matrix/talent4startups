<?php
$I = new FunctionalTester($scenario);
$I->am('a guest');
$I->wantTo('sign up for a Talent4Startups account');

$I->amOnPage('/');
$I->click('Sign Up');
$I->click('#startup');
$I->click('#agree');
$I->click('Or sign up with email instead');
$I->sendAjaxPostRequest('/register',array('user_type'=>'S')); // send user type= startup to register route
$I->amOnPage('/register');
$I->fillField('#username', 'JohnDoe');
$I->fillField('#email', 'john@example.com');
$I->fillField('#password', 'demo');
$I->fillField('#password_confirmation', 'demo');
$I->click('#submit-registration'); // Since we have a "Sign Up" link on the top navigation bar and the submit button also has the text "Sign Up" we need to target the input by an ID instead.

$I->amOnPage('/profile');
$I->assertTrue(Auth::check());
$I->see('Welcome to Talent4Startups');
$I->seeRecord('users', [
	'username' => 'JohnDoe',
	'email' => 'john@example.com'
]);
$I->fillField('First Name:', 'Jane');
$I->fillField('Last Name:', 'Doe');
$I->selectOption('skills[]','1');
$I->click('#submit-profile');

$I->amOnPage('/projects/create');  //create project page if user is startup
$I->seeRecord('profiles', [
	'first_name' => 'Jane',
	'last_name' => 'Doe'
]);
?>
