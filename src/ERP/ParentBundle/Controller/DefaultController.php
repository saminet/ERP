<?php

namespace ERP\ParentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ERPParentBundle:Default:indexParent.html.twig');
    }

    public function ConsNoteParentAction()
    {
        return $this->render('ERPParentBundle:Default:ConsNoteParant.html.twig');
    }

    public function releveNoteParentAction()
    {
        return $this->render('ERPParentBundle:Default:releveNoteParent.html.twig');
    }

    public function ConsEvaluationParentAction()
    {
        return $this->render('ERPParentBundle:Default:consEvalParent.html.twig');
    }

    public function PvClasseParentAction()
    {
        return $this->render('ERPParentBundle:Default:PvClasseParent.html.twig');
    }

    public function InfoSondageParentAction()
    {
        return $this->render('ERPParentBundle:Default:infoSondageParent.html.twig');
    }

    public function CirculationParentAction()
    {
        return $this->render('ERPParentBundle:Default:CirculationDirectParent.html.twig');
    }

    public function ListeEleveParentAction()
    {
        return $this->render('ERPParentBundle:Default:listeEleveParent.html.twig');
    }

    public function EDTParentAction()
    {
        return $this->render('ERPParentBundle:Default:EDPParent.html.twig');
    }

    public function AbsRetardParentAction()
    {
        return $this->render('ERPParentBundle:Default:AbsRetardParent.html.twig');
    }

    public function FicheStageParentAction()
    {
        return $this->render('ERPParentBundle:Default:ficheStageParent.html.twig');
    }

    public function OffrestageParentAction()
    {
        return $this->render('ERPParentBundle:Default:offreStageParent.html.twig');
    }

    public function ListEnseignantParentAction()
    {
        return $this->render('ERPParentBundle:Default:ListEnseignantParent.html.twig');
    }


}
