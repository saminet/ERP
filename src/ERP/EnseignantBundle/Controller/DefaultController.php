<?php

namespace ERP\EnseignantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ERPEnseignantBundle:Default:indexEnseignant.html.twig');
    }


      public function cahierTextAction()
    {
        return $this->render('ERPEnseignantBundle:Default:cahierEnseignant.html.twig');
    }

       public function coursAction()
    {
        return $this->render('ERPEnseignantBundle:Default:coursEnseignant.html.twig');
    }


        public function saisieNoteAction()
    {
        return $this->render('ERPEnseignantBundle:Default:saisieNoteEnseignant.html.twig');
    }

        public function releveNoteAction()
    {
        return $this->render('ERPEnseignantBundle:Default:releveNoteEnseignant.html.twig');
    }

        public function evaluationAction()
    {
        return $this->render('ERPEnseignantBundle:Default:consulterEvalEnseignant.html.twig');
    }


        public function PvClasseAction()
    {
        return $this->render('ERPEnseignantBundle:Default:pvClasseEnseignant.html.twig');
    }

        public function infoSondageAction()
    {
        return $this->render('ERPEnseignantBundle:Default:InfoSondageEnseignant.html.twig');
    }

        public function SaisieEvaluationAction()
    {
        return $this->render('ERPEnseignantBundle:Default:saisieEvaluationEnseignant.html.twig');
    }

         public function listeEvalAction()
    {
        return $this->render('ERPEnseignantBundle:Default:ListeEvalEnseignant.html.twig');
    }

          public function circulationDirectionAction()
    {
        return $this->render('ERPEnseignantBundle:Default:consDirectionEnseignant.html.twig');
    }

          public function listeEleveAction()
    {
        return $this->render('ERPEnseignantBundle:Default:listeEleveEnseignant.html.twig');
    }

           public function listeEnseignantAction()
    {
        return $this->render('ERPEnseignantBundle:Default:listeEnseignant.html.twig');
    }

           public function EDTEnseignantAction()
    {
        return $this->render('ERPEnseignantBundle:Default:EDTEnseignant.html.twig');
    }

           public function PlaningSalleAction()
    {
        return $this->render('ERPEnseignantBundle:Default:planingSalleEnseignant.html.twig');
    }

          public function AbsRetardAction()
    {
        return $this->render('ERPEnseignantBundle:Default:absRetardEnseignant.html.twig');
    }

          public function FicheStageAction()
    {
        return $this->render('ERPEnseignantBundle:Default:FicheStage.html.twig');
    }

          public function ListeStagiaireAction()
    {
        return $this->render('ERPEnseignantBundle:Default:ListeStagiaire.html.twig');
    }
}
