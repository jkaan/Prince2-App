<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/9/14
 * Time: 1:39 PM
 */

namespace Controllers;

use Entities\Clip;
use Entities\Document;
use Entities\Subject;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PageController
{
    public function indexAction(Request $request, Application $app)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];
        $subjectRepository = $entityManager->getRepository('Entities\Subject');

        $schoolYearOneSubjects = $subjectRepository->findBy(array(
            'schoolYear' => 1,
        ));
        $schoolYearTwoSubjects = $subjectRepository->findBy(array(
            'schoolYear' => 2,
        ));
        $schoolYearThreeSubjects = $subjectRepository->findBy(array(
            'schoolYear' => 3,
        ));
        $schoolYearFourSubjects = $subjectRepository->findBy(array(
            'schoolYear' => 4,
        ));

        return $app['twig']->render('index.html.twig', array(
            'schoolYearOneSubjects' => $schoolYearOneSubjects,
            'schoolYearTwoSubjects' => $schoolYearTwoSubjects,
            'schoolYearThreeSubjects' => $schoolYearThreeSubjects,
            'schoolYearFourSubjects' => $schoolYearFourSubjects,
        ));
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
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];

        $documentRepository = $entityManager->getRepository('Entities\Document');
        $clipRepository = $entityManager->getRepository('Entities\Clip');

        $documents = $documentRepository->findAll();
        $clips = $clipRepository->findAll();

        return $app['twig']->render('admin.html.twig', array(
            'documents' => $documents,
            'clips' => $clips,
        ));
    }

    public function searchAction(Request $request, Application $app)
    {
        $search = $request->get('search');
        $result = $app['db']->fetchAll('SELECT id, title, schoolYear FROM subjects WHERE title LIKE \'%'.$search.'%\' ');
        return $app['twig']->render('search.html.twig', array(
            'SearchResult' => $result
        ));
    }
    public function onderwerpAction(Request $request, Application $app, $leerjaarId, $subjectId)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];
        /** @var \Entities\Subject $subject */
        $subject = $entityManager->find('Entities\Subject', $subjectId);
        $documents = $subject->getDocuments();
        $clips = $subject->getClips();

        $color = 'red';
        //Check wich ID is set for the right color at each schoolyear
        switch ($leerjaarId) {
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
            'LeerjaarID' => $leerjaarId,
            'subject' => $subject,
            'documents' => $documents,
            'clips' => $clips,
        ));
    }

    public function leerjaarAction(Request $request, Application $app, $id)
    {
        $result = $app['db']->fetchAll('SELECT id, title FROM subjects WHERE schoolYear = ' . $id);
        return $app['twig']->render('onderwerpen.html.twig', array(
            'LeerjaarID' => $id,
            'Subjects' => $result
        ));
    }

    public function uploadDocumentAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {

            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = $app['entityManager'];

            $documentName = $request->get('documentName');
            $categorie = $request->get('categorie');
            $leerjaar = $request->get('leerjaren');
            $document = $request->files->get('document');

            // Create database document
            $databaseDocument = new Document();
            $databaseDocument->setName($documentName);
            $databaseDocument->setDocument($document);
            $databaseDocument->setSchoolYear($leerjaar);

            $databaseDocument->upload();

            $subjectRepository = $entityManager->getRepository('Entities\Subject');

            $subject = $subjectRepository->findOneBy(array(
                'title' => $categorie,
            ));

            if (!$subject || $subject->getSchoolYear() != $leerjaar) {
                $subject = new Subject();
                $subject->setTitle($categorie);
                $subject->setMessage("Categorie: " . $categorie);
                $subject->setSchoolYear($leerjaar);
            }

            $subject->addDocument($databaseDocument);

            $databaseDocument->setSubject($subject);

            $entityManager->persist($databaseDocument);
            $entityManager->persist($subject);

            $entityManager->flush();

            return $app->redirect('/');
        }

        return $app['twig']->render('uploadDocument.html.twig');
    }

    public function uploadClipAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {

            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = $app['entityManager'];

            $clipName = $request->get('clipName');
            $categorie = $request->get('categorie');
            $leerjaar = $request->get('leerjaren');
            $clip = $request->files->get('clip');

            // Create clip
            $databaseClip = new Clip();
            $databaseClip->setName($clipName);
            $databaseClip->setClip($clip);
            $databaseClip->setSchoolYear($leerjaar);

            $subjectRepository = $entityManager->getRepository('Entities\Subject');

            $subject = $subjectRepository->findOneBy(array(
                'title' => $categorie,
            ));

            if (!$subject || $subject->getSchoolYear() != $leerjaar) {
                $subject = new Subject();
                $subject->setTitle($categorie);
                $subject->setMessage("Categorie: " . $categorie);
                $subject->setSchoolYear($leerjaar);
            }

            $subject->addClip($databaseClip);

            $databaseClip->setSubject($subject);

            $databaseClip->upload();

            $entityManager->persist($databaseClip);
            $entityManager->persist($subject);

            $entityManager->flush();

            return $app->redirect('/');
        }

        return $app['twig']->render('uploadClip.html.twig');
    }

    public function downloadDocumentAction(Request $request, Application $app, $fileId)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];

        $document = $entityManager->getRepository('Entities\Document')->find($fileId);

        if (!$document) {
            $app->abort(404, 'Dit document bestaat niet');
        }

        return $app->sendFile('uploads/documents/' . $document->getPath(), 200, array('Content-type' => $document->getMimeType()), 'attachment');
    }

    public function downloadClipAction(Request $request, Application $app, $fileId)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];

        $clip = $entityManager->getRepository('Entities\Clip')->find($fileId);

        if (!$clip) {
            $app->abort(404, 'Deze clip bestaat niet');
        }

        return $app->sendFile('uploads/clips/' . $clip->getPath(), 200, array('Content-type' => $clip->getMimeType()), 'attachment');
    }

    public function deleteDocumentAction(Request $request, Application $app, $fileId)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];

        $document = $entityManager->getRepository('Entities\Document')->find($fileId);

        if (!$document) {
            $app->abort(404, 'Dit document bestaat niet');
        }

        $entityManager->remove($document);

        $entityManager->flush();

        return $app->redirect('/admin');
    }

    public function deleteClipAction(Request $request, Application $app, $fileId)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app['entityManager'];

        $clip = $entityManager->getRepository('Entities\Clip')->find($fileId);

        if (!$clip) {
            $app->abort(404, 'Deze clip bestaat niet');
        }

        $entityManager->remove($clip);

        $entityManager->flush();

        return $app->redirect('/admin');
    }
} 