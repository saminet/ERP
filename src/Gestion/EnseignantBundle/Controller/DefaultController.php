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

    public function modifierEnseignantAction($id, Request $request)
    {
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
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Les données de l\'enseignant'.$enseignant->getId().' sont bien modifiées.');

            return $this->redirectToRoute('Liste_enseignant', array('id' => $enseignant->getId()));
        }

        return $this->render('GestionEnseignantBundle:Default:modifierEnseignant.html.twig', array(
            'enseignant' => $enseignant,
            'form'   => $formView,
        ));
    }

}
