<?php

namespace Admin\AdminBundle\Controller;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Admin\AdminBundle\Entity\Acces;
use Admin\AdminBundle\Entity\LiaisonDroit;
use Admin\AdminBundle\Entity\DroitAcces;
use Admin\AdminBundle\Entity\Profil;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminAdminBundle:Default:index.html.twig');
    }

    public function gestionProfilAction()
    {
    	//Affichage de nom de l'utilisateur
    	$user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $modulee= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();
        $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();

        return $this->render('AdminAdminBundle:Default:profil.html.twig', array(
            'user' => $user,'module'=>$module
        ));

    }
   //fonction de sauvegarde de formulaire de creation de profil
    public function AddProfilAction(Request $request)
    {
    	//insertion des attribut dans la table  profil 
        $nomProfil=$request->get('nomProfil');
        $posteProfil=$request->get('poste');
        //sauvegarde dans la base des donnée,table profil
    	$profil = new Profil();
    	$profil->setNomProfil($nomProfil);
    	$profil->setPosteProfil($posteProfil);

    //sauvegarde des idprofil dans chaque ligne de boucle dans acces
        $em = $this->getDoctrine()->getManager();

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($profil);

    // actually executes the queries (i.e. the INSERT query)
         $em->flush();

    //fin bloc profilllll

    	//determiner l'objet module selectionné à partir de nom saisie dans le formulaire
        $nomModuleVar= array();
    	$nomModuleVar=$request->get('nomModule');

    	foreach($nomModuleVar as $nomModuleVarr){ 

        $repository1=$this->getDoctrine()->getRepository('AdminAdminBundle:Module');
        $SelectedModule=$repository1->createQueryBuilder('e')->where('e.nomModule = :nomModuleVarr')->setParameter('nomModuleVarr', $nomModuleVarr)->getQuery()->getResult();
      
        //recherche de l'objet module selon id
        $module= $this->getDoctrine()->getRepository('AdminAdminBundle:Module')->find($SelectedModule[0]->getId());
    	 
         //determiner l'id de profil enregistrer apres saisie de la formulaire en haut
         $repository2=$this->getDoctrine()->getRepository('AdminAdminBundle:Profil');
         $ProfilEnCours=$repository2->createQueryBuilder('e')->where('e.nomProfil = :nomProfilVarr')->setParameter('nomProfilVarr', $nomProfil)->getQuery()->getResult();
      
        //recherche de l'objet module selon id
       $profill= $this->getDoctrine()->getRepository('AdminAdminBundle:Profil')->find($ProfilEnCours[0]->getId());

    //sauvegarde dans la base des donnée,table Acces
    //sauvegarde idModule dans la table acess
    //sauvegarde idProfil dans la table acess
    	$acces = new Acces();
    	$acces->setModule($module);
    	$acces->setProfil($profill); 
        $em = $this->getDoctrine()->getManager(); 
    // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($acces);
    // actually executes the queries (i.e. the INSERT query)
         $em->flush();
    //traitement de droit d'acces qui a ete inserer en haut
        $id=$acces->getId();
    //recuperer les droit selectionner pour chaque module
        $nomdroitVar= array();
        //setParameter('nomModuleVarrr', $nomModuleVarr);
        $nomdroitVar=$request->get($nomModuleVarr);
       
        foreach($nomdroitVar as $nomdroiteVarr){

            $repository2=$this->getDoctrine()->getRepository('AdminAdminBundle:DroitAcces');
            $droitEnCours=$repository2->createQueryBuilder('e')->where('e.nomDroit = :nomDroitVarr')->setParameter('nomDroitVarr', $nomdroiteVarr)->getQuery()->getResult();
      
        //recherche de l'objet module selon id
            if (empty($droitEnCours)) {
                echo "viveeeeeeeee";
            }
               
           
       $droit= $this->getDoctrine()->getRepository('AdminAdminBundle:DroitAcces')->find($droitEnCours[0]->getId());

        $liaison = new LiaisonDroit();
        $liaison->setAcces($acces);
        $liaison->setDroitAcces($droit); 
        $em = $this->getDoctrine()->getManager(); 
    // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($liaison);
    // actually executes the queries (i.e. the INSERT query)
         $em->flush();
} 
}

	   $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();
        $Listeacces= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Acces')->findAll();
        $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();

         $acces  = $this->get('knp_paginator')->paginate(
        $Listeacces, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        8/*limit per page*/
    );
        

        return $this->render('AdminAdminBundle:Default:CrudProfil.html.twig', array(
            'user' => $user,'module'=>$module,'acces'=>$acces,'liaisons'=>$liaison
        ));

    }
  
    public function CrudProfilAction(Request $request)
    {

    $Listeacces= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Acces')->findAll();
    $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();
    $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();
//pagination
    //$request=$this->getRequest();
        $acces  = $this->get('knp_paginator')->paginate(
        $Listeacces, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        8/*limit per page*/
    );

//fin pagination
      $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

      return $this->render('AdminAdminBundle:Default:CrudProfil.html.twig', array(
            'user' => $user,'module'=>$module,'liaisons'=>$liaison,'acces' => $acces
        ));

}

    public function modifierProfilAction($id)
    {
         $user = $this->getUser();
        $droit= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:DroitAcces')->findAll();
        $acces= $this->getDoctrine()->getRepository('AdminAdminBundle:Acces')->find($id);
        $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();

         return $this->render('AdminAdminBundle:Default:modifierProfil.html.twig', array(
            'acces' => $acces,'droit' => $droit,'liaisons'=>$liaison,'user' => $user
        ));

    }


    public function DeleteProfilAction(Request $request,$id)
{

    //determiner l'objet acces selon l'id passe en parametre
       $repository3=$this->getDoctrine()->getRepository('AdminAdminBundle:Acces');
        $SelectedAcces=$repository3->createQueryBuilder('e')->where('e.id = :idAcces')->setParameter('idAcces', $id)->getQuery()->getResult();
      
        //recherche de l'objet liaisonDroit selon id

       $accesObjet= $this->getDoctrine()->getRepository('AdminAdminBundle:Acces')->find($SelectedAcces[0]->getId());

//determiner l'objet liaison selon objet acces selected
     $repository1=$this->getDoctrine()->getRepository('AdminAdminBundle:LiaisonDroit');
        $SelectedLiaison=$repository1->createQueryBuilder('e')->where('e.acces = :accesObjet')->setParameter('accesObjet', $accesObjet)->getQuery()->getResult();
      
        //recherche de l'objet liaisonDroit selon id

       $Liaison= $this->getDoctrine()->getRepository('AdminAdminBundle:LiaisonDroit')->find($SelectedLiaison[0]->getId());

    $something = $this->getDoctrine()
        ->getRepository('AdminAdminBundle:Acces')
        ->find($id);

    $em = $this->getDoctrine()->getManager();
    $em->remove($Liaison);
    $em->remove($something);
    $em->flush();

    // Suggestion: add a message in the flashbag

    // Redirect to the table page
     $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();
        $Listeacces= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Acces')->findAll();
        $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();

 $acces  = $this->get('knp_paginator')->paginate(
        $Listeacces, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        8/*limit per page*/
    );
 return $this->render('AdminAdminBundle:Default:CrudProfil.html.twig', array(
            'user' => $user,'module'=>$module,'acces'=>$acces,'liaisons'=>$liaison
        ));

}

  public function validerModificationAction(Request $request)
    {   
        $profileID=$request->get('idProfil');
        $NomProfil=$request->get('nomProfil');
        $PosteProfil=$request->get('posteProfil');

    $em = $this->getDoctrine()->getManager();
    $profil = $em->getRepository('AdminAdminBundle:Profil')->find($profileID);
    $profil->setNomProfil($NomProfil);
    $profil->setPosteProfil($PosteProfil); 
    $em->flush();


        
        $idAcces=$request->get('idAcces');
        $nomDroitAccesVar= array();
        $nomDroitAccesVar=$request->get('nomDroit');
       if(empty($nomDroitAccesVar)){
        $Listeacces= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Acces')->findAll();
      $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();
      $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();
       $acces  = $this->get('knp_paginator')->paginate(
        $Listeacces, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        8/*limit per page*/
    );
      $user = $this->getUser();
      return $this->render('AdminAdminBundle:Default:CrudProfil.html.twig', array(
        'acces' => $acces,'user' => $user,'module'=>$module,'liaisons'=>$liaison
        ));
       }
       else  {
       
       foreach($nomDroitAccesVar as $nomDroitAccesVarr){

        $repository1=$this->getDoctrine()->getRepository('AdminAdminBundle:DroitAcces');
        $SelectedDroit=$repository1->createQueryBuilder('e')->where('e.nomDroit = :nomAccesVarr')->setParameter('nomAccesVarr', $nomDroitAccesVarr)->getQuery()->getResult();
      
        //recherche de l'objet module selon id
       $droitValue= $this->getDoctrine()->getRepository('AdminAdminBundle:DroitAcces')->find($SelectedDroit[0]->getId());
       
       $repository2=$this->getDoctrine()->getRepository('AdminAdminBundle:Acces');
        $SelectedAcces=$repository2->createQueryBuilder('e')->where('e.id = :idAcces')->setParameter('idAcces', $idAcces)->getQuery()->getResult();
      
        //recherche de l'objet module selon id
       $AccesValue= $this->getDoctrine()->getRepository('AdminAdminBundle:Acces')->find($SelectedAcces[0]->getId());


        $liaison = new LiaisonDroit();
        $liaison->setDroitAcces($droitValue);
        $liaison->setAcces($AccesValue); 
        $em = $this->getDoctrine()->getManager(); 
    // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($liaison);
    // actually executes the queries (i.e. the INSERT query)
         $em->flush();
}
$Listeacces= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Acces')->findAll();
      $module= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();
      $liaison= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:LiaisonDroit')->findAll();

       $acces  = $this->get('knp_paginator')->paginate(
        $Listeacces, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        8/*limit per page*/
    );

      $user = $this->getUser();
      return $this->render('AdminAdminBundle:Default:CrudProfil.html.twig', array(
        'acces' => $acces,'user' => $user,'module'=>$module,'liaisons'=>$liaison
        ));
}

    }



      public function agendaAction()
    {
        return $this->render('AdminAdminBundle:Default:agenda.html.twig');
    }

     public function infoSondageAction()
    {
        return $this->render('AdminAdminBundle:Default:infoSondage.html.twig');
    }

     public function gererMatiereAction()
    {
        return $this->render('AdminAdminBundle:Default:gererMatiere.html.twig');
    }

     public function rechercheAvanceAction()
    {
        return $this->render('AdminAdminBundle:Default:rechercheAvance.html.twig');
    }

      public function gererClasseAction()
    {
        return $this->render('AdminAdminBundle:Default:gererClasse.html.twig');
    }

      public function listeMatiereAction()
    {
        return $this->render('AdminAdminBundle:Default:listeMatiere.html.twig');
    }

     public function gererSalleAction()
    {
        return $this->render('AdminAdminBundle:Default:gererSalle.html.twig');
    }

  

 public function ajoutabsAction()
    {
        return $this->render('AdminAdminBundle:Default:viescolaire.html.twig');
    }

 
  public function listeSalleAction()
    {
        return $this->render('AdminAdminBundle:Default:listeSalle.html.twig');
    }

  public function planingSalleAction()
    {
        return $this->render('AdminAdminBundle:Default:planingSalle.html.twig');
    }

    public function listePersonnelAction()
    {
        return $this->render('AdminAdminBundle:Default:listePersonnel.html.twig');
    }
    public function listeabsenseignantsAction()
    {
        return $this->render('AdminAdminBundle:Default:listeabsenseignants.html.twig');
    }
    public function planingProfAction()
    {
        return $this->render('AdminAdminBundle:Default:planingProf.html.twig');
    }
    public function suiviabsensetudiantsAction()
    {
        return $this->render('AdminAdminBundle:Default:suiviabsensetudiants.html.twig');
    }
    public function ajoutevaluationAction()
    {
        return $this->render('AdminAdminBundle:Default:ajoutevaluation.html.twig');
    }
    public function listeevaluationAction()
    {
        return $this->render('AdminAdminBundle:Default:listeevaluation.html.twig');
    }
    public function cahierdestextAction()
    {
        return $this->render('AdminAdminBundle:Default:cahierdestext.html.twig');
    }
    public function listsetudiantsAction()
    {
        return $this->render('AdminAdminBundle:Default:listsetudiants.html.twig');
    }
    public function relvedesnotesAction()
    {
        return $this->render('AdminAdminBundle:Default:relvedesnotes.html.twig');
    }
     public function EDTProfesseurAction()
    {
        return $this->render('AdminAdminBundle:Default:EDTProfesseur.html.twig');
    }
    public function TrombinoscopeetudiantsAction()
    {
        return $this->render('AdminAdminBundle:Default:Trombinoscopeetudiants.html.twig');
    }
    public function TrombinoscopeadminAction()
    {
        return $this->render('AdminAdminBundle:Default:Trombinoscopeadmin.html.twig');
    }
    public function ressourcesemploitempsAction()
    {
        return $this->render('AdminAdminBundle:Default:ressourcesemploitemps.html.twig');
    }
    public function ressourceplanningAction()
    {
        return $this->render('AdminAdminBundle:Default:ressourceplanning.html.twig');
    }
    public function ressourceplanningclassesAction()
    {
        return $this->render('AdminAdminBundle:Default:ressourceplanningclasses.html.twig');
    }


  
}
