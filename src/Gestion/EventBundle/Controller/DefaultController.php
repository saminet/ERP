<?php

namespace Gestion\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $calendar = $em->getRepository('GestionEventBundle:Event')->findAll();

        return $this->container->get('templating')->renderResponse('GestionEventBundle:Default:index.html.twig',array(
                'calendar' => $calendar)
        );
    }
}
