<?php

namespace Gestion\NoteBundle\Controller;

use Gestion\NoteBundle\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestion\NoteBundle\Form\NoteType;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionNoteBundle:Default:index.html.twig');
    }

    public function listeNoteAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $note = $em->getRepository('GestionNoteBundle:Note')->findAll();

        return $this->container->get('templating')->renderResponse('GestionNoteBundle:Default:listeNote.html.twig', array(
                'notes' => $note)
        );

    }


     public function ajouterNoteAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        //on crée un nouveau note
        $note = new Note();
        //on recupere le formulaire
        $form = $this->createForm(NoteType::class,$note);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($note);
            $em->flush();
            return $this->redirect($this->generateUrl('gestion_note'));
        }
        //on rend la vue
        return $this->render('GestionNoteBundle:Default:ajouterNote.html.twig',array(
            'form'   => $formView));
    }

    public function ajaxGetEtudiantAction(Request $request) {
        // Get the classe ID
        $id = $request->query->get('classe_id');
        $result = array();
        // Return a list of students, based on the selected class
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('GestionPreinscriptionBundle:Etudiant');
        $etudiant = $repo->findBy(array('classe' => $id), array('nom' => 'asc'));
        foreach ($etudiant as $etud) {
            $result[$etud->getNom()] = $etud->getId();
        }
        return new JsonResponse($result);
    }
}
