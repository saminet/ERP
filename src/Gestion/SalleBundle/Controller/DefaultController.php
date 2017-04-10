<?php

namespace Gestion\SalleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestion\SalleBundle\Entity\Salle;
use Gestion\SalleBundle\Form\SalleType;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionSalleBundle:Default:index.html.twig');
    }


    public function listSallesAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $salle = $em->getRepository('GestionSalleBundle:Salle')->findAll();

        return $this->container->get('templating')->renderResponse('GestionSalleBundle:Default:listeSalles.html.twig',array(
                'salle' => $salle)
        );
    }

    public function ajouterSalleAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        //on crée un nouveau etudiant
        $salle = new Salle();
        //on recupere le formulaire
        $form = $this->createForm(SalleType::class,$salle);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $em->persist($salle);
                $em->flush();
                return $this->redirect($this->generateUrl('list_Salles'));
            }
        }
        //on rend la vue
        return $this->render('GestionSalleBundle:Default:ajouterSalle.html.twig',array(
            'form' => $formView) );
    }

    public function supprimerSalleAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $salle= $this->getDoctrine()->getRepository('GestionSalleBundle:Salle')->find($id);
        if (!$salle)
        {
            throw new NotFoundHttpException("Aucune salle trouvé");
        }
        $em->remove($salle);
        $em->flush();
        return new RedirectResponse($this->container->get('router')->generate('list_Salles'));
    }

    public function modifierSalleAction($id, Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $salle= $em->getRepository('GestionSalleBundle:Salle')->find($id);
        if (null === $salle) {
            throw new NotFoundHttpException("La sale d'id ".$id." n'existe pas.");
        }
        //on recupere le formulaire
        $form = $this->createForm(SalleType::class, $salle);
        //on génère le html du formulaire crée
        $formView = $form->createView();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();

            return $this->redirectToRoute('list_Salles', array('id' => $salle->getId()));
        }

        return $this->render('GestionSalleBundle:Default:modifierSalle.html.twig', array(
            'salle' => $salle,
            'form'   => $formView,
        ));
    }

}
