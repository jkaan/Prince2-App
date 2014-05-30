<?php
$I = new WebGuy($scenario);

$I->wantTo('Ensure study year pages work');
$I->amOnPage('/leerjaar/1');

$I->see('LEERJAAR 1');

$I->amOnPage('/leerjaar/2');

$I->see('LEERJAAR 2');

$I->amOnPage('/leerjaar/3');

$I->see('LEERJAAR 3');

$I->amOnPage('/leerjaar/4');

$I->see('LEERJAAR 4');
