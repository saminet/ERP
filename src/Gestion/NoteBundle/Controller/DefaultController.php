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
        $groupe=null;
        $etudiant=null;
        $classe= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        //on rend la vue
        return $this->render('GestionNoteBundle:Default:ajouterNote.html.twig',array('classe'=>$classe, 'groupe'=>$groupe, 'etudiant'=>$etudiant, 'matiere'=>$matiere,));
    }

    public function validerNoteAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $note= $em->getRepository('GestionNoteBundle:Note')->findAll();
        //on crée un nouvelle unité
        $note = new Note();
        $classe=$request->get('NameClasse');
        $class ='';
        $groupe=$request->get('NameGroupe');
        $etudiant=$request->get('NameEtudiant');
        $matiere=$request->get('matiere');
        $note=$request->get('note');
        $type=$request->get('type');
        $session=$request->get('sesion');

        if (is_array($classe) || is_object($classe || $classe instanceof Traversable))
        {
            foreach ($classe as $clas) {
                $class = $clas.";";
            }
        }

        var_dump($classe,$class,$groupe,$etudiant,$matiere,$note,$type,$session);die('hello !!');

        $em = $this->getDoctrine()->getManager();

        $note->setClasse($classe);
        $note->setGroupe($groupe);
        $note->setEtudiant($etudiant);
        $note->addMatiere($matiere);
        $note->setNote($note);
        $note->setType($type);
        $note->setSession($session);
        $em->persist($note);
        $em->flush();
        //on rend la vue
        return $this->container->get('templating')->renderResponse('GestionNoteBundle:Default:listeNote.html.twig', array(
                'notes' => $note)
        );
    }

    public function ajaxGetGroupeAction(Request $request) {
        // Get the classe ID
        $id = $request->query->get('classe_id');
        $result = array();
        // Return a list of groups, based on the selected class
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Groupe');
        $groupe = $repo->findBy(array('classe' => $id), array('intitule' => 'asc'));
        foreach ($groupe as $group) {
            $result[$group->getIntitule()] = $group->getId();
        }
        return new JsonResponse($result);
    }

    public function ajaxGetEtudiantAction(Request $request) {
        // Get the Group ID
        $idClasse = $request->query->get('groupe_id');
        $result = array();
        // Return a list of groups, based on the selected class
        $repo1 = $this->getDoctrine()->getEntityManager()->getRepository('GestionPreinscriptionBundle:Etudiant');
        $etudiant = $repo1->findBy(array('groupe' => $idClasse), array('nom' => 'asc'));
        foreach ($etudiant as $etud) {
            $result[$etud->getNom()] = $etud->getId();
        }
        return new JsonResponse($result);
    }
}
