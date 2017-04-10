<?php

namespace Gestion\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gestion\AbsenceBundle\Entity\AbsenceRetard;
class consulterAbsenceRetardController extends Controller
{

	 public function ConsulterAbsenceRetardAction()
    {   $groupes=null;
        $matieres=null;
        $Etudiants=null;
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
      return $this->render('GestionAbsenceBundle:Default:consulterAbsenceRetard.html.twig', array(
        'user' => $user,'classes'=>$classes,'groupes'=>$groupes,'dates'=>$matieres,'etudiants'=>$Etudiants
        ));
       
    }


     public function Save_QueryConsultationAction(Request $request)
    { 

    	$selectedClass=$request->get('NameClass');
    	$selectedGroupe=$request->get('NameGroupe');
    	$selectedMatiere=$request->get('NameMatiere');
        

    	$repository1=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Classe');
        $SelectedClasse=$repository1->createQueryBuilder('e')->where('e.intitule = :nomclassVarr')->setParameter('nomclassVarr', $selectedClass)->getQuery()->getResult();
      
        //recherche de l'objet classe selon id
        $classe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Classe')->find($SelectedClasse[0]->getId());

        //determiner les objets groupes selon classe
        $repository2=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe');
        $SelectedGroupes=$repository2->createQueryBuilder('e')->where('e.classe = :classe')->setParameter('classe', $classe)->getQuery()->getResult();
//*************************
        
//*************************
  
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $Etudiants=null;
        $selectedMatieree=null;

    	$user = $this->getUser();
      return $this->render('GestionAbsenceBundle:Default:consulterAbsenceRetard.html.twig', array(
        'user' => $user,'classes'=>$classes,'groupes'=>$SelectedGroupes,'dates'=>$selectedMatieree,'etudiants'=>$Etudiants
        ));
        
    }


    public function Save_QueryGroupeConsuAction(Request $request)
    {   
    	$selectedGroupe=$request->get('NameGroupe');

       //determiner les objets groupe selon groupe selected
        $repository3=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe');
        $SelectedGroupee=$repository3->createQueryBuilder('e')->where('e.intitule = :nomgroupeVarr')->setParameter('nomgroupeVarr', $selectedGroupe)->getQuery()->getResult();
      
        //recherche de l'objet groupe selon id
       
        echo $selectedGroupe;
        $groupe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe')->find($SelectedGroupee[0]->getId());
        
        //determiner les matieres selon groupe
         $repository4=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Date');
        $selectedMatieree=$repository4->createQueryBuilder('e')->where('e.groupe = :groupe')->setParameter('groupe', $groupe)->getQuery()->getResult();

        //liste etudiants
        $repository5=$this->getDoctrine()->getRepository('GestionAbsenceBundle:AnneScolaire');
        $Etudiants=$repository5->createQueryBuilder('e')->where('e.groupe = :groupe')->setParameter('groupe', $groupe)->getQuery()->getResult();


 $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
 $listeApp= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:AbsenceRetard')->findAll();

 $SelectedGroupes=$this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Groupe')->findAll();
    
    	$user = $this->getUser();
       return $this->render('GestionAbsenceBundle:Default:consulterAbsenceRetard.html.twig', array(
        'user' => $user,'classes'=>$classes,'groupes'=>$SelectedGroupes,'dates'=>$selectedMatieree,'listeApps'=>$listeApp,'etudiants'=>$Etudiants,'groupeCourant'=>$groupe
        ));
    }

     public function SaveAbsenceMatiereConsuAction(Request $request)
    {   
    	$selectedMatiere=$request->get('NameMatiere');

       //determiner les objets groupe selon groupe selected
        $repository3=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Matiere');
        $SelectedMatieree=$repository3->createQueryBuilder('e')->where('e.intitule = :nommatVarr')->setParameter('nommatVarr', $selectedMatiere)->getQuery()->getResult();
      
        //recherche de l'objet groupe selon id
       
        $matiere= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Matiere')->find($SelectedMatieree[0]->getId());
        
        //determiner les matieres selon groupe


 		$classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
 		$listeApp= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:AbsenceRetard')->findAll();
 		$SelectedGroupes=$this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Groupe')->findAll();
        $Etudiants=$this->getDoctrine()->getEntityManager()->getRepository('GestionPreinscriptionBundle:Etudiant')->findAll();
    
    	$user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Default:consulterAbsenceRetard.html.twig', array(
        'user' => $user,'classes'=>$classes,'groupes'=>$SelectedGroupes,'dates'=>$SelectedMatieree, 'etudiants'=>$Etudiants,'listeApps'=>$listeApp
        ));
      
       
    }

}
