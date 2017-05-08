<?php

namespace Gestion\AbsenceBundle\Controller;
use Gestion\AbsenceBundle\Entity\AbsenceRetard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {   $groupes=null;
        $matieres=null;
        $Etudiants=null;
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Default:index.html.twig', array(
            'user' => $user,'classes'=>$classes,'groupes'=>$groupes,'dates'=>$matieres,'etudiants'=>$Etudiants
        ));

    }

    public function saveAction(Request $request)
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
        return $this->render('GestionAbsenceBundle:Default:index.html.twig', array(
            'user' => $user,'classes'=>$classes,'groupes'=>$SelectedGroupes,'dates'=>$selectedMatieree,'etudiants'=>$Etudiants
        ));

    }


    public function Save_QueryGroupeAction(Request $request)
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
        $SelectedGroupes=$this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Groupe')->findAll();

        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Default:index.html.twig', array(
            'user' => $user,'classes'=>$classes,'groupes'=>$SelectedGroupes,'dates'=>$selectedMatieree,'etudiants'=>$Etudiants
        ));


    }


    public function SaveAbsenceFormAction(Request $request)
    {
        //recuperer la matiere selectionne à partir de formulaire
        $NameMatiere=$request->get('NameMatiere');
        //recuperer l'objet matiere
        $repository5=$this->getDoctrine()->getRepository('GestionMatiereBundle:Matiere');
        $selectedMatiere=$repository5->createQueryBuilder('e')->where('e.nomMatiere = :NomMat')->setParameter('NomMat', $NameMatiere)->getQuery()->getResult();
        //recherche de l'objet matiere selon id

        $ObjetMatiere= $this->getDoctrine()->getRepository('GestionMatiereBundle:Matiere')->find($selectedMatiere[0]->getId());

        //recuperer id groupe sur lequel on travail
        $idGroupe=2;
        //recuperer l'objet groupe selon l id
        $repository1=$this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe');
        $SelectedGroupee=$repository1->createQueryBuilder('e')->where('e.id = :idGroupe')->setParameter('idGroupe', $idGroupe)->getQuery()->getResult();
        //recherche de l'objet groupe selon id
        $groupe= $this->getDoctrine()->getRepository('GestionAbsenceBundle:Groupe')->find($SelectedGroupee[0]->getId());

        //recuperer les ligne dont les groupe sont $groupe
        $repository2=$this->getDoctrine()->getRepository('GestionAbsenceBundle:AnneScolaire');
        $SelectedAnneScolaire=$repository2->createQueryBuilder('e')->where('e.groupe = :groupeObject')->setParameter('groupeObject', $groupe)->getQuery()->getResult();
        //recherche de l'objet groupe selon id
        //$AnneScolaire= $this->getDoctrine()->getRepository('AbsenceGestionAbsenceBundle:AnneScolaire')->find($SelectedAnneScolaire[0]->getId());

        foreach($SelectedAnneScolaire as $AnneScolairee){
            $var=$AnneScolairee->getEtudiant()->getNom();
            $AbsenceVar= array();
            //setParameter('nomModuleVarrr', $nomModuleVarr);
            $AbsenceVar=$request->get($var);
            foreach($AbsenceVar as $AbsenceVarr){
                //ne5ou l value eli howa ll id mte3 l etudiant l absent w ntala3 menou l objet w na3melou insertion f base
                $repository2=$this->getDoctrine()->getRepository('GestionPreinscriptionBundle:Etudiant');
                $SelectedEtudiant=$repository2->createQueryBuilder('e')->where('e.id = :idEtudiant')->setParameter('idEtudiant', $AbsenceVarr)->getQuery()->getResult();
                //recherche de l'objet groupe selon id
                $ObjetEtudiant= $this->getDoctrine()->getRepository('GestionPreinscriptionBundle:Etudiant')->find($SelectedEtudiant[0]->getId());

                $absenceRetrd = new AbsenceRetard();
                $absenceRetrd->setEtudiant($ObjetEtudiant);
                $absenceRetrd->setMatiere($ObjetMatiere);


                //sauvegarde des idprofil dans chaque ligne de boucle dans acces
                $em = $this->getDoctrine()->getManager();

                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($absenceRetrd);

                // actually executes the queries (i.e. the INSERT query)
                $em->flush();
            }
        }

        $groupes=null;
        $matieres=null;
        $Etudiants=null;
        $classes= $this->getDoctrine()->getEntityManager()->getRepository('GestionAbsenceBundle:Classe')->findAll();
        $user = $this->getUser();
        return $this->render('GestionAbsenceBundle:Default:index.html.twig', array(
            'user' => $user,'classes'=>$classes,'groupes'=>$groupes,'dates'=>$matieres,'etudiants'=>$Etudiants
        ));

    }







}
