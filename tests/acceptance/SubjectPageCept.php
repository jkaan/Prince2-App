<?php
$I = new WebGuy($scenario);
$I->wantTo('Ensure the subject page work');
$I->amOnPage('/leerjaar/1/onderwerp/3');

$I->see('PLAATJES');
$I->see('Categorie: Plaatjes');
$I->see('Test Plaatje 3');
$I->see('Test Plaatje 4');