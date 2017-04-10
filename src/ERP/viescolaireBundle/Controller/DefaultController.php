<?php

namespace ERP\viescolaireBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ERPviescolaireBundle:Default:indexviescolaire.html.twig');
    }

    public function ajoutabsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:viescolaire.html.twig');
    }
    public function listeabsenseignantsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:listeabsenseignants.html.twig');
    }
    public function listeabsensetudiantsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:listeabsensetudiants.html.twig');
    }
    public function suiviabsensetudiantsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:suiviabsensetudiants.html.twig');
    }
    public function ajoutevaluationAction()
    {
        return $this->render('ERPviescolaireBundle:Default:ajoutevaluation.html.twig');
    }
    public function listeevaluationAction()
    {
        return $this->render('ERPviescolaireBundle:Default:listeevaluation.html.twig');
    }
    public function cahierdeschargesAction()
    {
        return $this->render('ERPviescolaireBundle:Default:cahierdescharges.html.twig');
    }
    public function listsetudiantsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:listsetudiants.html.twig');
    }
    public function relvedesnotesAction()
    {
        return $this->render('ERPviescolaireBundle:Default:relvedesnotes.html.twig');
    }
    public function TrombinoscopeetudiantsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:Trombinoscopeetudiants.html.twig');
    }
    public function TrombinoscopeadminAction()
    {
        return $this->render('ERPviescolaireBundle:Default:Trombinoscopeadmin.html.twig');
    }
    public function ressourcesemploitempsAction()
    {
        return $this->render('ERPviescolaireBundle:Default:ressourcesemploitemps.html.twig');
    }
    public function ressourceplanningAction()
    {
        return $this->render('ERPviescolaireBundle:Default:ressourceplanning.html.twig');
    }
    public function ressourceplanningclassesAction()
    {
        return $this->render('ERPviescolaireBundle:Default:ressourceplanningclasses.html.twig');
    }
}