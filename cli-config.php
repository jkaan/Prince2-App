<?php
// cli-config.php
require_once "config/doctrine-bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);