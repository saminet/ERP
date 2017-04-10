<?php

namespace Gestion\MatiereBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gestion\MatiereBundle\Entity\Matiere;
class DefaultController extends Controller
{
    public function indexAction()
    {
        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:CrudMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere ));

    }

    public function AddMatiereAction(Request $request)
    {
        $nomMatiere=$request->get('nomMatiere');
        $coefficient=$request->get('coefficient');
        $credit=$request->get('credit');
        //sauvegarde dans la base des donnée,table profil
        $matiere = new Matiere();
        $matiere->setNomMatiere($nomMatiere);
        $matiere->setCoefficient($coefficient);
        $matiere->setCredit($credit);

        //sauvegarde des idprofil dans chaque ligne de boucle dans acces
        $em = $this->getDoctrine()->getManager();
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($matiere);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:CrudMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere ));

    }


    public function modifierMatiereAction($id)
    {
        $matiere= $this->getDoctrine()->getRepository('GestionMatiereBundle:Matiere')->find($id);
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:modifierMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere ));

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
        return $this->render('GestionMatiereBundle:Default:CrudMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matiere ));

    }

    public function ValiderModificationAction(Request $request)
    {
        $matiereID=$request->get('idMatiere');
        $NomMatiere=$request->get('nomMatiere');
        $Coefficient=$request->get('coefficient');
        $Credit=$request->get('credit');

        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('GestionMatiereBundle:Matiere')->find($matiereID);
        $matiere->setNomMatiere($NomMatiere);
        $matiere->setCoefficient($Coefficient);
        $matiere->setCredit($Credit);
        $em->flush();



        $matieree= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        $user = $this->getUser();
        return $this->render('GestionMatiereBundle:Default:CrudMatiere.html.twig', array(
            'user' => $user,'matieres'=>$matieree ));

    }
}
