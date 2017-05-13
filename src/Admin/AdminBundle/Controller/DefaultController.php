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
use Admin\AdminBundle\Entity\Membre;
use Admin\AdminBundle\Entity\DroitAcces;
use Admin\AdminBundle\Entity\Profil;
use User\UserBundle\Entity\User;
use Admin\AdminBundle\Form\ProfilType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\DependencyInjection\ContainerAware;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminAdminBundle:Default:index.html.twig');
    }

    public function addMembreAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('Désolé, mais vous n\'etes pas autorisé à accéder à ce service.');
        }
        return $this->render('AdminAdminBundle:Default:membre.html.twig', array('user' => $user));
    }

    public function ajoutPersonnelAction()
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $profil = $em->getRepository('AdminAdminBundle:Profil')->findAll();
        $user = $this->getUser();
        // On vérifie que l'utilisateur dispose bien du rôle correspondant
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT','ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Désolé, mais vous n\'etes pas autorisé à accéder à ce service.');
            //$this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');

        }

        return $this->render('AdminAdminBundle:Default:ajoutpersonnel.html.twig', array('user' => $user, 'profil' => $profil));
    }

    public function validerMembreAction(Request $request)
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $Membre = $em->getRepository('AdminAdminBundle:Membre')->findAll();

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        //$Date_Nais=$request->get('date_naissance');
        $cin=$request->get('cin');
        $rib=$request->get('rib');
        $sexe=$request->get('sexe');
        $ville=$request->get('ville');
        $leuxNais=$request->get('leuxNais');
        $nat=$request->get('nat');
        $tel=$request->get('tel');
        $email=$request->get('mail');
        $adresse=$request->get('adresse');
        $username=$request->get('pseudo');
        $password=$request->get('password');
        //$roles=array();
        $roles=$request->get('profil');
        //var_dump($username);die('Hello');
        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        // Pour récupérer la liste de tous les utilisateurs
        
            $user = $userManager->createUser();
            $user->setUsername($username);
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 13]);
            $user->setPassword($hash);
            $user->setEmail($email);
            $user->setEnabled(true);
            $user->setRoles(array($roles));
            $userManager->updateUser($user);

            //var_dump($nom,$prenom,$cin,$rib,$sexe,$ville,$leuxNais,$nat,$tel,$email,$adresse,$username,$password,$roles);die('Hello');
            //sauvegarde dans la base des donnée,table membre
            $membre = new Membre();
            $membre->setNom($nom);
            $membre->setPrenom($prenom);
            //$membre->setDateNaissance($Date_Nais);
            $membre->setCin($cin);
            $membre->setRib($rib);
            $membre->setSexe($sexe);
            $membre->setVille($ville);
            $membre->setLieuxNaissance($leuxNais);
            $membre->setNationalite($nat);
            $membre->setTel($tel);
            $membre->setEmail($email);
            $membre->setAdresse($adresse);
            $membre->setLogin($username);
            $membre->setPassword($password);
            $membre->setRole($roles);

            //sauvegarde des idprofil dans chaque ligne de boucle dans acces
            $em = $this->getDoctrine()->getManager();
            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($membre);
            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

        return $this->redirect($this->generateUrl('liste_Membre', array('user' => $user)));
    }


    public function verifLoginAction(Request $request)
    {
        $pseudo = $request->query->get('pseudo');
        //var_dump($pseudo,$email);die('Hello');
        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        // Pour récupérer la liste de tous les utilisateurs
        $pseuudo =$userManager->findUserByUsername($pseudo);
        //var_dump($res);die('Hello');
        if(Count($pseuudo)>0) {
            echo "<br><span style=\"color:#D91E18;\">Le pseudo <span style=\"color:#0000C0;\">$pseudo</span> est déjà pris.</span>";
        }
        else
        {
            echo "<br><span style=\"color:#00d95a;\">Le pseudo <span style=\"color:#0000C0;\">$pseudo</span>  est disponible.</span>";
        }
        exit();
    }

    public function verifEmailAction(Request $request)
    {
        $email =  $request->query->get('mail');
        //var_dump($pseudo,$email);die('Hello');
        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        // Pour récupérer la liste de tous les utilisateurs
        $Mail =$userManager->findUserBy(array('email' => $email));
        //var_dump($res);die('Hello');

        if(Count($Mail)>0) {
            echo "<br><span style=\"color:#D91E18;\">L'email <span style=\"color:#0000C0;\">$email</span> est déjà pris. </span>";
        }
        else
        {
            echo "<br><span style=\"color:#00d95a;\">L'email <span style=\"color:#0000C0;\">$email</span> est disponible.</span></span>";
        }
        exit();
    }

    

    public function listMembreAction()
    {
        $membre= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Membre')->findAll();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->getUser();
        return $this->render('AdminAdminBundle:Default:listMembre.html.twig', array('user' => $user, 'membre' => $membre ));
    }

    public function infosMembreAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $membre= $em->getRepository('AdminAdminBundle:Membre')->find($id);
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->getUser();
        return $this->render('AdminAdminBundle:Default:infosMembre.html.twig', array('user' => $user, 'membre' => $membre ));
    }

    public function editMembreAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $profil = $em->getRepository('AdminAdminBundle:Profil')->findAll();
        $membre= $em->getRepository('AdminAdminBundle:Membre')->find($id);
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user = $this->getUser();
        return $this->render('AdminAdminBundle:Default:modifierMembre.html.twig', array('user' => $user, 'membre' => $membre, 'profil' => $profil));
    }

    public function validerEditMembreAction($id, Request $request)
    {

        $IDMembre=$request->get('idMembre');
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        //$Date_Nais=$request->get('date_naissance');
        $cin=$request->get('cin');
        $rib=$request->get('rib');
        $sexe=$request->get('sexe');
        $ville=$request->get('ville');
        $leuxNais=$request->get('leuxNais');
        $nat=$request->get('nat');
        $tel=$request->get('tel');
        $email=$request->get('Mail');
        $adresse=$request->get('adresse');
        $username=$request->get('login');
        $username_Old=$request->get('Old_login');
        $password=$request->get('password');
        //$roles=array();
        $roles=$request->get('role');
        //var_dump($nom,$prenom,$cin,$rib,$sexe,$ville,$leuxNais,$nat,$tel,$email,$adresse,$username,$password,$roles);die('Hello');

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //sauvegarde dans la base des donnée,table membre
        $em = $this->getDoctrine()->getManager();
        $membre = $em->getRepository('AdminAdminBundle:Membre')->find($IDMembre);
        $membre->setNom($nom);
        $membre->setPrenom($prenom);
        //$membre->setDateNaissance($Date_Nais);
        $membre->setCin($cin);
        $membre->setRib($rib);
        $membre->setSexe($sexe);
        $membre->setVille($ville);
        $membre->setLieuxNaissance($leuxNais);
        $membre->setNationalite($nat);
        $membre->setTel($tel);
        $membre->setEmail($email);
        $membre->setAdresse($adresse);
        $membre->setLogin($username);
        $membre->setPassword($password);
        $membre->setRole($roles);
        //var_dump($username_Old);die('Hello');


        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        $usr = $userManager->findUserByUsername($username_Old);
        $usr->setUsername($username);
        $hash = password_hash($password,PASSWORD_BCRYPT,['cost' => 13]) ;
        $usr->setPassword($hash);
        $usr->setEmail($email);
        $usr->setEnabled(true);
        $usr->setRoles(array($roles));
        $userManager->updateUser($usr);


        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($membre);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return $this->redirect($this->generateUrl('liste_Membre', array('user' => $user)));
    }

    public function deleteMembreAction(Request $request)
    {
        $IDMembre=$request->get('id');
        $username=$request->get('username');
        //var_dump($username);die('Hello');
        $em = $this->getDoctrine()->getManager();
        $membre = $em->getRepository('AdminAdminBundle:Membre')->find($IDMembre);

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        $usr = $userManager->findUserByUsername($username);
        $em->remove($usr);
        $em->remove($membre);
        $em->flush();
        return $this->redirect($this->generateUrl('liste_Membre', array('user' => $user)));
    }

    public function listeProfilAction()
    {
        $profil = $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Profil')->findAll();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        return $this->render('AdminAdminBundle:Default:listeProfil.html.twig', array('user' => $user, 'profil' => $profil ));
    }

    public function newProfilAction(Request $request)
    {
        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');
        // Pour récupérer la liste de tous les utilisateurs
        $users = $userManager->findUsers();
        return $this->render('AdminAdminBundle:Default:ajoutProfil.html.twig',array('users' => $users));
    }

    public function AddProfilsAction(Request $request)
    {
        $profils= $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Profil')->findAll();
        //insertion des attribut dans la table  profil
        $nomProfil=$request->get('nomProfil');
        $posteProfil=$request->get('poste');
        $roles=array();
        $roles=$request->get('nomRole');

        if(!is_null($roles)) {
            foreach ($roles as $role) {
                $role = $request->get('nomRole');
                //var_dump($role);
            }
            //die('Hello');
            //sauvegarde dans la base des donnée,table profil
            $profil = new Profil();
            $profil->setNomProfil($nomProfil);
            $profil->setPosteProfil($posteProfil);
            $profil->setRole(serialize($roles));

            //sauvegarde des idprofil dans chaque ligne de boucle dans acces
            $em = $this->getDoctrine()->getManager();
            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($profil);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
            return $this->redirect($this->generateUrl('listeProfil'));
        }
    }












































    public function gestionProfilAction()
    {
        //Affichage de nom de l'utilisateur
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $module = $this->getDoctrine()->getEntityManager()->getRepository('AdminAdminBundle:Module')->findAll();

        return $this->render('AdminAdminBundle:Default:profil.html.twig', array(
            'user' => $user, 'module' => $module
        ));
    }
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

        //fin bloc profilllllr



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
            $em = $this->getDoctrine()->getManager(); !
                // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($acces);
            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            //traitement de droit d'acces qui a ete inserer en haut
            $id=$acces->getId();
            //recuperer les droit selectionner pour chaque module
            $nomdroitVar= array();
            $nomdroitVar=$request->get($nomModuleVarr);
            if (!empty($nomdroitVar)) {
                echo $nomdroitVar[0];
            }
            foreach($nomdroitVar as $nomdroiteVarr){
                $repository2=$this->getDoctrine()->getRepository('AdminAdminBundle:DroitAcces');
                $droitEnCours=$repository2->createQueryBuilder('e')->where('e.nomDroit = :nomDroitVarr')->setParameter('nomDroitVarr', $nomdroiteVarr)->getQuery()->getResult();

                //recherche de l'objet module selon id
                if (empty($droitEnCours)) {
                    echo "Liste Vide";
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
