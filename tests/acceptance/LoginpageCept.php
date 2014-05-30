<?php
$I = new WebGuy($scenario);

$I->wantTo('Ensure the login system works');
$I->amOnPage('/login');
$I->see('Login');
$I->fillField('username', 'admin');
$I->fillField('password', 'admin');
$I->click('Login');
$I->see('Uploaden documenten');
