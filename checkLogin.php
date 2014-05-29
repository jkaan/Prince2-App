<?php

require_once "doctrine-config/bootstrap.php";

$username = $_POST['username'];
$password = $_POST['password'];

$userRepository = $entityManager->getRepository('Entities\User');

$user = $userRepository->findBy(array('username' => $username));

if ($user) {
    echo "User found!";
} else {
    echo "No user found!";
}