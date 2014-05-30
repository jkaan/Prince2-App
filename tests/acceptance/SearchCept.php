<?php

$I = new WebGuy($scenario);

$I->wantTo("Ensure the search function works");
$I->amOnPage('/');

$I->submitForm('#searchform', array(
    'search' => 'pl',
));

$I->see('PLAATJES');