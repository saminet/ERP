<?php

namespace Gestion\NiveauBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestion\NiveauBundle\Entity\Niveau;
use Gestion\NiveauBundle\Form\NiveauType;
use Gestion\FiliereBundle\Entity\Filiere;
use Gestion\FiliereBundle\Form\FiliereType;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionNiveauBundle:Default:index.html.twig');
    }

    public function listeNiveauxAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $niveau = $em->getRepository('GestionNiveauBundle:Niveau')->findAll();

        return $this->container->get('templating')->renderResponse('GestionNiveauBundle:Default:listeNiveaux.html.twig',array(
                'niveau' => $niveau)
        );
    }

    public function ajouterNiveauAction(Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $filiere= $em->getRepository('GestionFiliereBundle:Filiere')->findAll();
        //on crée un nouveau etudiant
        $niveau = new Niveau();
        //on recupere le formulaire
        $form = $this->createForm(NiveauType::class,$niveau);

        //on génère le html du formulaire crée
        $formView = $form->createView();
        // Refill the fields in case the form is not valid.
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $em->persist($niveau);
                $em->flush();
                return $this->redirect($this->generateUrl('Liste_Niveau'));
            }
        }
        //on rend la vue
        return $this->render('GestionNiveauBundle:Default:ajouterNiveau.html.twig',array('filiere' => $filiere,
            'form' => $formView) );
    }


    public function modifierNiveauAction($id, Request $request)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $niveau= $em->getRepository('GestionNiveauBundle:Niveau')->find($id);
        if (null === $niveau) {
            throw new NotFoundHttpException("Le niveau demandé d'id ".$id." n'existe pas.");
        }
        //on recupere le formulaire
        $form = $this->createForm(NiveauType::class, $niveau);
        //on génère le html du formulaire crée
        $formView = $form->createView();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre filière
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Les données du niveau'.$niveau->getId().' est bien modifiée.');

            return $this->redirectToRoute('Liste_Niveau');
        }

        return $this->render('GestionNiveauBundle:Default:modifierNiveau.html.twig', array(
            'niveau' => $niveau,
            'form'   => $formView,
        ));
    }


    public function supprimerNiveauAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $niveau= $this->getDoctrine()->getRepository('GestionNiveauBundle:Niveau')->find($id);
        if (!$niveau)
        {
            throw new NotFoundHttpException("Aucune niveau trouvé");
        }
        $em->remove($niveau);
        $em->flush();
        return new RedirectResponse($this->container->get('router')->generate('Liste_Niveau'));
    }


}
