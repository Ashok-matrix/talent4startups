<?php
$I = new FunctionalTester($scenario);
$I->amOnPage('/login');
$I->fillField('#email', 'test@gmail.com');
$I->fillField('#password', '12345');
$I->click('#submit-login');
$I->assertTrue(Auth::check());
$I->amOnPage('/projects');
$I->click('Learn More');
$I->assertTrue(Auth::check());
$projectEditUrl = $I->grabAttributeFrom('#edit-project','href');
$I->click('#edit-project');
$I->amOnPage($projectEditUrl);
$I->selectOption('tags[]',array('1','2'));
$I->click('#submit-project');
