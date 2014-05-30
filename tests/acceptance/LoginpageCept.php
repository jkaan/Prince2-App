<?php
$I = new WebGuy($scenario);

$I->wantTo('Ensure the login system works');
$I->amOnPage('/login');
$I->see('Login');

$I->submitForm('#loginForm', array(
    '_username' => 'admin',
    '_password' => 'admin',
));

$I->see('Beheer');
