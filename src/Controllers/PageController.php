<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/9/14
 * Time: 1:39 PM
 */

namespace Controllers;

use Entities\Document;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class PageController {

    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('index.html.twig');
    }

    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    public function checkLogin(Request $request, Application $app)
    {
        // This is handled by Silex itself, so this doesn't need any body
    }

    public function adminAction(Request $request, Application $app)
    {
        return $app['twig']->render('admin.html.twig');
    }

    public function uploadDocumentAction(Request $request, Application $app)
    {
        return $app['twig']->render('uploadDocument.html.twig');
    }

    public function uploadClipAction(Request $request, Application $app)
    {
        return $app['twig']->render('uploadClip.html.twig');
    }
} 