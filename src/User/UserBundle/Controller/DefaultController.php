<?php

namespace User\UserBundle\Controller;

use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
class DefaultController extends Controller
{
    /**
     *
     *@Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
             $user = $this->getUser();
        
        	 return $this->render('AdminAdminBundle:Default:admin.html.twig', array(
            'user' => $user
        ));
        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $user = $this->getUser();
        	 return $this->render('UserUserBundle:Default:client.html.twig', array(
            'user' => $user
        ));
        }

    }

    public function roleAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('UserUserBundle:Default:roles.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Displays a form to edit an existing Users.
     *
     */
    public function editAction(Request $request,$id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $user= $em->getRepository('UserUserBundle:User')->find($id);
        $user->handleRequest($request);
        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
        //on recupere le formulaire
        $form = $this->createForm(UserType::class, $user);
        $formView = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('UserUserBundle:Default:edit.html.twig', array(
            'id' => $id,
            'form' => $formView,

        ));
    }

}
