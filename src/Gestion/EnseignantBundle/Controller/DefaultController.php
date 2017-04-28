<?php

namespace Gestion\EnseignantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestion\EnseignantBundle\Form\EnseignantType;
use Gestion\EnseignantBundle\Entity\Enseignant;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionEnseignantBundle:Default:index.html.twig');
    }

    public function listEnseignantAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $enseignants = $em->getRepository('GestionEnseignantBundle:Enseignant')->findAll();

        return $this->container->get('templating')->renderResponse('GestionEnseignantBundle:Default:listeEns.html.twig',array(
                'enseignant' => $enseignants)
        );
    }

    public function infosEnseignantAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $enseignants= $em->getRepository('GestionEnseignantBundle:Enseignant')->find($id);
        return $this->container->get('templating')->renderResponse('GestionEnseignantBundle:Default:infosEnseignant.html.twig',
            array(
                'enseignant' => $enseignants
            ));
    }

    public function ajouterEnseignantAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        //on crée un nouveau etudiant
        $enseignant = new Enseignant();
        //on recupere le formulaire
        $form = $this->createForm(EnseignantType::class,$enseignant);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $donnee = $form->getData();
                $username = $donnee->getLogin();
                $password = $donnee->getPassword();
                $email = $donnee->getEmail();
                $roles = 'ROLE_ENSEIGNANT';
                //var_dump($roles);die('Hello');
                //créer un compte pour l'enseignant
                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->createUser();
                $user->setUsername($username);
                $hash = password_hash($password,PASSWORD_BCRYPT,['cost' => 13]) ;
                $user->setPassword($hash);
                $user->setEmail($email);
                $user->setEnabled(true);
                $user->setRoles(array($roles));
                $userManager->updateUser($user);

                $em->persist($enseignant);
                $em->flush();
                return $this->redirect($this->generateUrl('Liste_enseignant'));
            }
        }
        //on rend la vue
        return $this->render('GestionEnseignantBundle:Default:ajouterEnseignant.html.twig',array(
            'form' => $formView) );
    }

    public function modifierEnseignantAction($id, Request $request)
    {
        $Old_user=$request->get('username');
        $Old_usr=$request->get('idEns');

        $em = $this->container->get('doctrine')->getEntityManager();
        $enseignant= $em->getRepository('GestionEnseignantBundle:Enseignant')->find($id);
        if (null === $enseignant) {
            throw new NotFoundHttpException("L'enseignant d'id ".$id." n'existe pas.");
        }
        //on recupere le formulaire
        $form = $this->createForm(EnseignantType::class, $enseignant);
        //on génère le html du formulaire crée
        $formView = $form->createView();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $donnee = $form->getData();
            $username = $donnee->getLogin();
            $password = $donnee->getPassword();
            $email = $donnee->getEmail();
            //var_dump($username,$Old_usr,$roles,$password,$email,$roles);die('Hello');
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($Old_usr);
            $user->setUsername($username);
            $hash = password_hash($password,PASSWORD_BCRYPT,['cost' => 13]) ;
            $user->setPassword($hash);
            $user->setEmail($email);
            $user->setEnabled(true);
            $userManager->updateUser($user);

            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Les données de l\'enseignant'.$enseignant->getId().' sont bien modifiées.');

            return $this->redirectToRoute('Liste_enseignant', array('id' => $enseignant->getId()));
        }

        return $this->render('GestionEnseignantBundle:Default:modifierEnseignant.html.twig', array(
            'enseignant' => $enseignant,
            'form'   => $formView, 'oldUser' => $Old_user
        ));
    }

    public function supprimerEnseignantAction(Request $request, $id)
    {
        $username=$request->get('username');
        //var_dump($username);die('Hello');
        $em = $this->container->get('doctrine')->getEntityManager();
        $etudiant= $this->getDoctrine()->getRepository('GestionEnseignantBundle:Enseignant')->find($id);
        if (!$etudiant)
        {
            throw new NotFoundHttpException("Enseignant non trouvé");
        }

        //ajout des paramètres username et password dans la table 'fos_user'
        $userManager = $this->get('fos_user.user_manager');
        $usr = $userManager->findUserByUsername($username);
        $em->remove($usr);

        $em->remove($etudiant);
        $em->flush();
        return new RedirectResponse($this->container->get('router')->generate('Liste_enseignant'));
    }


}
