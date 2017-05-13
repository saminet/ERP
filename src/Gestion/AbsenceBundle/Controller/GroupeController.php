<?php

namespace Gestion\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gestion\AbsenceBundle\Entity\Classe;
use Gestion\AbsenceBundle\Entity\Groupe;
use Gestion\AbsenceBundle\Form\GroupeType;
use Symfony\Component\HttpFoundation\RedirectResponse;
class GroupeController extends Controller
{
    public function indexAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $groupe = $em->getRepository('GestionAbsenceBundle:Groupe')->findAll();
        return $this->container->get('templating')->renderResponse('GestionAbsenceBundle:Groupe:listGroupe.html.twig',array(
                'groupe' => $groupe)
        );
    }

    public function listGroupeAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $groupe = $em->getRepository('GestionAbsenceBundle:Groupe')->findAll();
        return $this->container->get('templating')->renderResponse('GestionAbsenceBundle:Groupe:listGroupe.html.twig',array(
                'groupe' => $groupe)
        );
    }

    public function AjoutGroupeAction(Request $request)
    {
        $classe= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $em = $this->container->get('doctrine')->getEntityManager();
        //on crée un nouveau etudiant
        $groupe = new Groupe();
        //on recupere le formulaire
        $form = $this->createForm(GroupeType::class,$groupe);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($groupe);
            $em->flush();
            return $this->redirect($this->generateUrl('listGroupe'));
        }
        //on rend la vue
        return $this->render('GestionAbsenceBundle:Groupe:ajoutGroupe.html.twig',array(
            'form'   => $formView, 'classe'   => $classe));
    }

    public function ModifierGroupeAction($id, Request $request)
    {
        $classe= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $em = $this->container->get('doctrine')->getEntityManager();
        $groupe= $em->getRepository('GestionAbsenceBundle:Groupe')->find($id);
        if (null === $groupe) {
            throw new NotFoundHttpException("Le groupe d'id ".$id." n'existe pas.");
        }
        //on recupere le formulaire
        $form = $this->createForm(GroupeType::class, $groupe);
        //on génère le html du formulaire crée
        $formView = $form->createView();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                // Inutile de persister ici, Doctrine connait déjà notre annonce
                $em->flush();
            return $this->redirect($this->generateUrl('listGroupe'));
            }
        //on rend la vue
        return $this->render('GestionAbsenceBundle:Groupe:modifierGroupe.html.twig',array(
            'form'   => $formView, 'groupe'   => $groupe, 'classe'   => $classe));
        }

    public function deleteGroupeAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $groupe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe')->find($id);
        if (!$groupe)
        {
            throw new NotFoundHttpException("Groupe non trouvé");
        }

        $em->remove($groupe);
        $em->flush();
        return new RedirectResponse($this->get('router')->generate('listGroupe'));
    }

}
