<?php

namespace Gestion\UEBundle\Controller;

use Gestion\UEBundle\Entity\UE;
use Gestion\UEBundle\Entity\Tag;
use Gestion\MatiereBundle\Entity\Matiere;
use Gestion\NiveauBundle\Entity\Niveau;
use Gestion\UEBundle\Form\UEType;
use Gestion\UEBundle\Form\StringToTagsTransformer;
use Gestion\UEBundle\Form\TagsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionUEBundle:Default:index.html.twig');
    }

    public function listAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $ue = $em->getRepository('GestionUEBundle:UE')->findAll();

        return $this->container->get('templating')->renderResponse('GestionUEBundle:Default:listeUE.html.twig',array(
                'unites' => $ue)
        );
    }

    public function AjouterUEAction()
    {   $filieres=null;
        $niveaux= $this->getDoctrine()->getEntityManager()->getRepository('GestionNiveauBundle:Niveau')->findAll();
        $matiere= $this->getDoctrine()->getEntityManager()->getRepository('GestionMatiereBundle:Matiere')->findAll();
        return $this->render('GestionUEBundle:Default:ajouter.html.twig', array('niveau'=>$niveaux, 'matiere'=>$matiere,
            'filiere'=>$filieres
        ));

    }

    public function validerUEAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $unites= $em->getRepository('GestionUEBundle:UE')->findAll();
        //on crée un nouvelle unité
        $unite = new UE();
        $nomUnite=$request->get('nomUnite');
        $niveau=$request->get('NameNiveau');
        $coef='';
        $credit='';
        $matiere= array();

        $matiere=$request->get('matieres');

        if(!is_null($matiere)){
            foreach($matiere as $matiere) {
                $matiere=$request->get('matieres');
                $credit=$request->get('Credit');
                $coef=$request->get('Coef');
               }
        }

        var_dump($nomUnite,$niveau,$matiere,$coef,$credit);die('hello !!');

        $em = $this->getDoctrine()->getManager();

        $unite->setIntitule($nomUnite);
        $unite->addMatiere($matiere);
        $unite->setCoeffUnite($coef);
        $unite->setCreditUnite($credit);
        //$unite->setIdNiveau($niveau);
        $em->persist($unite);
        $em->flush();
        //on rend la vue
        return $this->render('GestionUEBundle:Default:listeUE.html.twig',array('unite' => $unites));
    }

    public function modifierUEAction($id, Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $ue= $em->getRepository('GestionUEBundle:UE')->find($id);
        if (null === $ue) {
            throw new NotFoundHttpException("L'unité d'id ".$id." n'existe pas.");
            //on génère le html du formulaire crée
        }
        //on recupere le formulaire
        $form = $this->createForm(UEType::class, $ue);
        $formView = $form->createView();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre unité d'enseignement
            $em->flush();

            return $this->redirectToRoute('Liste_UE');
        }

        return $this->render('GestionUEBundle:Default:modifierUE.html.twig', array(
            'unite' => $ue,
            'form'   => $formView,
        ));
    }

    public function supprimerUEAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $ue= $this->getDoctrine()->getRepository('GestionUEBundle:UE')->find($id);
        if (!$ue)
        {
            throw new NotFoundHttpException("Aucune unité trouvé");
        }
        $em->remove($ue);
        $em->flush();
        return new RedirectResponse($this->container->get('router')->generate('Liste_UE'));
    }

    public function ajaxGetFilieresAction(Request $request) {
        // Get the Niveau ID
        $id = $request->query->get('niveau_id');
        $result = array();
        // Return a list of filiere, based on the selected niveau
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('GestionFiliereBundle:Filiere');
        $filieres = $repo->findBy(array('niveau' => $id), array('intitule' => 'asc'));
        foreach ($filieres as $filiere) {
            $result[$filiere->getIntitule()] = $filiere->getId();
        }
        return new JsonResponse($result);
    }
}
