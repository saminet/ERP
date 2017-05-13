<?php

namespace Gestion\NoteBundle\Controller;

use Gestion\NoteBundle\Entity\Note;
use Gestion\NoteBundle\Form\NoteType;
use Gestion\PreinscriptionBundle\Entity\Etudiant;
use Gestion\AbsenceBundle\Entity\Classe;
use Gestion\AbsenceBundle\Entity\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $MAAT=null;
        $matierssse= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $classe= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();

        $em = $this->container->get('doctrine')->getEntityManager();
        //on crée un nouveau etudiant
        $note = new Note();
        //on recupere le formulaire
        $form = $this->createForm(NoteType::class,$note);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $donnee = $form->getData();
            $note->setEtat('En attente');
            $em->persist($note);
            $em->flush();
            return $this->redirect($this->generateUrl('list_note'));
        }
        //on rend la vue
        return $this->render('GestionNoteBundle:Default:ajouterNote.html.twig',array('form' => $formView, 'classe'=>$classe, 'groupe'=>$groupe, 'etudiant'=>$etudiant));
    }

    public function verifierNoteAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $notes = $em->getRepository('GestionNoteBundle:Note')->find($id);
        $notes->setEtat('Validé');
        $em->persist($notes);
        $em->flush();
        //on rend la vue
        return new RedirectResponse($this->container->get('router')->generate('list_note'));
    }

    public function modifierNoteAction($id, Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $groupe=null;
        $etudiant=null;
        $classe= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();

        $notes= $this->getDoctrine()->getRepository('GestionNoteBundle:Note')->find($id);
        if (null === $notes) {
            throw new NotFoundHttpException("Pas de note d'id ".$id.".");
        }
        //on recupere le formulaire
        $form = $this->createForm(NoteType::class,$notes);
        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $donnee = $form->getData();
            $notes->setEtat('En attente');
            $em->persist($notes);
            $em->flush();
            return $this->redirect($this->generateUrl('list_note'));
        }
        //on rend la vue
        return $this->render('GestionNoteBundle:Default:modifierNote.html.twig',array('form' => $formView, 'classe'=>$classe, 'groupe'=>$groupe, 'etudiant'=>$etudiant, 'notes'=>$notes));
    }

    public function validerModifNoteAction($id, Request $request)
    {
        //récupération des données
        $cc=$request->get('cc');
        $ds=$request->get('ds');
        $exam=$request->get('exam');

        //var_dump($etudiant,$matiere,$cc,$ds,$exam);die('hello !!');

        //$em = $this->getDoctrine()->getManager();
        $em = $this->container->get('doctrine')->getEntityManager();
        $notes = $em->getRepository('GestionNoteBundle:Note')->find($id);
        //$notes= $this->getDoctrine()->getRepository('GestionNoteBundle:Note')->find($id);
        //$notes->setMatiere($matiere);
        //$notes->setEtudiant($etudiant);
        $notes->setCc($cc);
        $notes->setDs($ds);
        $notes->setExamen($exam);
        $em->persist($notes);
        $em->flush();
        //on rend la vue
        return new RedirectResponse($this->container->get('router')->generate('list_note'));
    }

    public function deleteNoteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $note = $em->getRepository('GestionNoteBundle:Note')->find($id);
        $em->remove($note);
        $em->flush();
        //on rend la vue
        return new RedirectResponse($this->container->get('router')->generate('list_note'));
    }

    public function searchNoteAction(Request $request)
    {
        $selectedIdEtudiant=$request->get('idEtud');
        $Nom=$request->get('nom');
        $Prenom=$request->get('prenom');
        $NomPrenom=$request->get('nom').' '.$request->get('prenom');
        $Semestre=$request->get('semestre');

        //var_dump($selectedIdEtudiant, $Semestre);die('Hello');
        $repository1=$this->getDoctrine()->getRepository('GestionNoteBundle:Note');
        $SelectedEtud=$repository1->createQueryBuilder('e')->where('e.etudiant = :idEtudiant')->setParameter('idEtudiant', $selectedIdEtudiant)->getQuery()->getResult();
        $user = $this->getUser();
        return $this->render('GestionNoteBundle:Default:resultSearch.html.twig', array(
            'user' => $user,'EtudiantID'=>$SelectedEtud,'idEtud'=>$selectedIdEtudiant, 'nomPrenom'=>$NomPrenom, 'semestre'=>$Semestre));
    }

    public function imprimerReleveAction(Request $request)
    {
        $selectedIdEtudiant=$request->get('idEtud');
        $NomPrenom=$request->get('nomPrenom');
        $Semestre=$request->get('semestre');

        //var_dump($selectedIdEtudiant, $Semestre, $NomPrenom);die('Hello');
        $repository1=$this->getDoctrine()->getRepository('GestionNoteBundle:Note');
        $SelectedEtud=$repository1->createQueryBuilder('e')->where('e.etudiant = :idEtudiant')->setParameter('idEtudiant', $selectedIdEtudiant)->getQuery()->getResult();
        $user = $this->getUser();
        return $this->render('GestionNoteBundle:Default:imprimerReleve.html.twig', array(
            'user' => $user,'EtudiantID'=>$SelectedEtud,'idEtud'=>$selectedIdEtudiant, 'nomPrenom'=>$NomPrenom, 'semestre'=>$Semestre));
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
        $idGroupe = $request->query->get('groupe_id');
        $result = array();
        // Return a list of groups, based on the selected class
        $repo1 = $this->getDoctrine()->getEntityManager()->getRepository('GestionPreinscriptionBundle:Etudiant');
        $etudiant = $repo1->findBy(array('groupe' => $idGroupe), array('nom' => 'asc'));
        foreach ($etudiant as $etud) {
            $result[$etud->getNom().' '.$etud->getPrenom()] = $etud->getId();
        }
        return new JsonResponse($result);
    }
}
