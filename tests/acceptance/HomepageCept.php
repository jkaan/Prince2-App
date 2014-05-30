<?php
$I = new WebGuy($scenario);

$I->wantTo('Ensure the index page works');
$I->amOnPage('/');
$I->see('LEERJAAR 1');
$I->see('LEERJAAR 2');
$I->see('LEERJAAR 3');
$I->see('LEERJAAR 4');
