<?php

require_once "vendor/autoload.php";
require_once "config/doctrine-bootstrap.php";

$app = new Silex\Application();

$app['debug'] = true;
$app['entityManager'] = $entityManager;
$app['db'] = $entityManager->getConnection();

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'logs/development.log',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => 'templates/',
    )
);

$app->get('/', 'Controllers\\PageController::indexAction')->bind('home');
$app->get('/login', 'Controllers\\PageController::loginAction')->bind('login');
$app->get('/admin/', 'Controllers\\PageController::adminAction')->bind('admin');
$app->get('/admin/uploadDocument', 'Controllers\\PageController::uploadDocumentAction')->bind('uploadDocument');
$app->get('/admin/uploadClip', 'Controllers\\PageController::uploadClipAction')->bind('uploadClip');

$app->post('/admin/checkLogin', 'Controllers\\PageController::checkLogin')->bind('checkLogin');

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'form' => array(
            'login_path' => $app['url_generator']->generate('login'),
            'check_path' => $app['url_generator']->generate('checkLogin'),
            'default_target_path' => $app['url_generator']->generate('admin'),
        ),
        'logout' => array(
            'logout_path' => '/admin/logout',
        ),
        'remember_me' => array(
            'key' => 'sjk3lfeskelfj3klsf',
            'always_remember_me' => true,
        ),
        'anonymous' => true,
        'users' => $app->share(function() use ($app) {
                return new Security\UserProvider($app['db']);
            })
    ),
);

$app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN'),
);

$app->boot();



$app->run();