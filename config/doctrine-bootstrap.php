<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver;

$paths = array("src/");
$isDevMode = true;

$classLoader = new \Doctrine\Common\ClassLoader('Entities','src/');
$classLoader->register();

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'vertrigo',
    'dbname'   => 'prince2',
);

$driver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(new Doctrine\Common\Annotations\AnnotationReader(),array('src/Entities'));
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$config->setMetadataDriverImpl($driver);

$entityManager = EntityManager::create($dbParams, $config);
