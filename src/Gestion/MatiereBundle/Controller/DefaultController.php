<?php

namespace Gestion\MatiereBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gestion\MatiereBundle\Entity\Matiere;
use Symfony\Component\HttpFoundation\RedirectResponse;
class DefaultController extends Controller
{
    public function indexAction()
    {
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:CrudMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere, 'classe'=>$classes ));

    }

    public function listMatiereAction()
    {
        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:listMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere ));
    }

    public function ajoutMatiereAction(Request $request)
    {
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:ajoutMatiere.html.twig', array(
            'user' => $user, 'classe'=>$classes ));
    }

    public function validerAjoutMatiereAction(Request $request)
    {
        $nomMatiere=$request->get('nomMatiere');
        $coefficient=$request->get('coefficient');
        $credit=$request->get('credit');
        $classe=$request->get('classe');
        //sauvegarde dans la base des donnée,table profil
        $matiere = new Matiere();
        $matiere->setNomMatiere($nomMatiere);
        $matiere->setCoefficient($coefficient);
        $matiere->setCredit($credit);
        $matiere->setClasse($classe);

        //sauvegarde des idprofil dans chaque ligne de boucle dans acces
        $em = $this->getDoctrine()->getManager();
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($matiere);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listMatiere'));
    }

    public function modifierMatiereAction($id)
    {
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $matiere= $this->getDoctrine()->getRepository('GestionMatiereBundle:Matiere')->find($id);
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:modifierMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere, 'classe'=>$classes ));

    }

    public function ValiderModificationAction(Request $request)
    {
        $matiereID=$request->get('idMatiere');
        $NomMatiere=$request->get('nomMatiere');
        $Coefficient=$request->get('coefficient');
        $Credit=$request->get('credit');
        $classe=$request->get('classe');

        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('GestionMatiereBundle:Matiere')->find($matiereID);
        $matiere->setNomMatiere($NomMatiere);
        $matiere->setCoefficient($Coefficient);
        $matiere->setCredit($Credit);
        $matiere->setClasse($classe);
        $em->flush();

        $matieree= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listMatiere'));
    }

    public function deleteMatiereAction($id)
    {
        $something = $this->getDoctrine()
            ->getRepository('GestionMatiereBundle:Matiere')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($something);
        $em->flush();

        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return new RedirectResponse($this->container->get('router')->generate('listMatiere'));

    }

}
