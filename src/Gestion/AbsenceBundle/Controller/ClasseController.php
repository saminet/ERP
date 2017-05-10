<?php

namespace Gestion\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gestion\AbsenceBundle\Entity\Classe;
use Symfony\Component\HttpFoundation\RedirectResponse;
class ClasseController extends Controller
{
    public function indexAction()
    {
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Classe:listClasses.html.twig', array(
            'user' => $user,'classes'=>$classes));

    }

    public function listClasseAction()
    {
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Classe:listClasses.html.twig', array(
            'user' => $user,'classes'=>$classes));
    }

    public function AjoutClasseAction(Request $request)
    {
        $niveau= $this->getDoctrine()->getEntityManager()->getRepository('GestionNiveauBundle:Niveau')->findAll();
        $filiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionFiliereBundle:Filiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Classe:ajoutClasse.html.twig', array(
            'user' => $user, 'niveau'=>$niveau, 'filiere'=>$filiere ));
    }

    public function validerAjoutClasseAction(Request $request)
    {
        $niveau=$request->get('niveau');
        $filiere=$request->get('filiere');
        $classe = new Classe();
        $classe->setIntitule($niveau.' '.$filiere);

        //sauvegarde des idprofil dans chaque ligne de boucle dans acces
        $em = $this->getDoctrine()->getManager();
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($classe);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listClasse', array(
            'user' => $user)));
    }

    public function ModifierClasseAction($id)
    {
        $niveau= $this->getDoctrine()->getEntityManager()->getRepository('GestionNiveauBundle:Niveau')->findAll();
        $filiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionFiliereBundle:Filiere')->findAll();
        $classe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Classe')->find($id);
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Classe:ajoutClasse.html.twig', array(
            'user' => $user, 'niveau'=>$niveau, 'filiere'=>$filiere, 'classe'=>$classe ));

    }

    public function validerModifClasseAction($id, Request $request)
    {
        $niveau=$request->get('niveau');
        $filiere=$request->get('filiere');
        $classe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Classe')->find($id);
        $classe->setIntitule($niveau.' '.$filiere);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listClasse', array(
            'user' => $user)));
    }

    public function deleteClasseAction($id)
    {
        $something = $this->getDoctrine()
            ->getRepository('GestionAbsenceBundle:Classe')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($something);
        $em->flush();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listClasse', array(
            'user' => $user)));

    }

}
