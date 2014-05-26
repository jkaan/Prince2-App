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
        $test = $app['db']->fetchAll('SELECT id, title FROM subjects LIMIT 0,4');
		return $app['twig']->render('index.html.twig', array('array' => $test));
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
    
	public function errorAction(Request $request, Application $app)
    {
        return $app['twig']->render('error.html.twig');
    }   
	
	public function searchAction(Request $request, Application $app)
    {
        $search = $app['request']->get('search');
		$result = $app['db']->fetchAll('SELECT id, title, schoolYear FROM subjects WHERE title LIKE \'%'.$search.'%\' ');
		return $app['twig']->render('search.html.twig', array(
			'SearchResult' => $result
		));
    } 	
	public function onderwerpAction(Request $request, Application $app, $id1, $id2)
    {
		$result = $app['db']->fetchAll('SELECT s.title, s.message, d.name, d.path
										FROM subjects as s
										Inner Join subject_document as sd On sd.subject_id = s.id
										Inner Join documents as d On d.id = sd.document_id
										WHERE s.id = '.$id2
										);	
		//Grab all attachments in one array
		$attachments = array();		
		for($i=0; $i<count($result); $i++){
			$attachments[$i]['AttName'] = $result[$i]['name'];
			$attachments[$i]['AttPath'] = $result[$i]['path'];
		}
		//Check wich ID is set for the right color at each schoolyear
        switch ($id1) {
		  case 1:
			$color = 'red';
			break;
		  case 2:
			$color = 'orange';
			break;
		  case 3:
			$color = 'green';
			break;
		  case 4:
			$color = 'blue';
			break;
		}
		return $app['twig']->render('onderwerp.html.twig', array(
		'LeerjaarColor' =>$color,
		'LeerjaarID' => $id1,
		'ResultArray' => $result[0],
		'Attachments' => $attachments
		));
    }
	
	public function leerjaarAction(Request $request, Application $app, $id)
    {
		$result = $app['db']->fetchAll('SELECT id, title FROM subjects WHERE schoolYear = '.$id);	
        return $app['twig']->render('onderwerpen.html.twig', array(
			'LeerjaarID' => $id,
			'Subjects' => $result
		));
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