<?php

namespace User\UserBundle\Controller;
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

}
