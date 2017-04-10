<?php

namespace ERP\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ERPEtudiantBundle:Default:indexEtudiant.html.twig');
    }

     public function coursEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:coursEtudiant.html.twig');
    }

     public function BulletinEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:BulletinEtudiant.html.twig');
    }

     public function releveEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:releveEtudiant.html.twig');
    }

     public function EvaluationEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:EvaluationEtudiant.html.twig');
    }

     public function PvEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:PvEtudiant.html.twig');
    }

     public function InfoSondageEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:InfoSondageEtudiant.html.twig');
    }

     public function EDTEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:EDTEtudiant.html.twig');
    }

     public function ListAbsenceEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:ListAbsenceEtudiant.html.twig');
    }

     public function FicheStageEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:FicheStageEtudiant.html.twig');
    }

     public function OffreStageEtudiantAction()
    {
        return $this->render('ERPEtudiantBundle:Default:OffreStageEtudiant.html.twig');
    }


}
