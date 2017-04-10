<?php

namespace ERP\vuescolaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ERPvuescolaireBundle:Default:index.html.twig');
    }
}
