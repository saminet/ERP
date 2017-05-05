<?php

namespace Gestion\PreinscriptionBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array('attr' => array('placeholder'=>'Nom de l\'étudiant','class'=>'form-control')))
            ->add('prenom',TextType::class, array('attr' => array('placeholder'=>'Prénom de l\'étudiant','class'=>'form-control')))
            ->add('dateNaissance',DateType::class, array(
             // render as a single text box
             'widget' => 'single_text'))
            ->add('sexe',ChoiceType::class, array('placeholder'=>'Choisir le sexe','choices' => array('Féminin'=>'Féminin','Masculin'=>'Masculin'),
                'expanded' => true,
                'multiple' => false))
            ->add('adresse',TextareaType::class, array('attr' => array('placeholder'=>'Adresse de l\'étudiant','class'=>'form-control')))
            ->add('lieuNaissance',TextType::class, array('attr' => array('placeholder'=>'Lieu de Naissance de l\'étudiant','class'=>'form-control')))
            ->add('nationalite',TextType::class, array('attr' => array('placeholder'=>'Nationalité de l\'étudiant','class'=>'form-control')))
            ->add('ville',TextType::class, array('attr' => array('placeholder'=>'Ville de l\'étudiant','class'=>'form-control')))
            ->add('numCinPass',IntegerType::class, array('attr' => array('placeholder'=>'Numéro CIN/Passeport','class'=>'form-control')))
            ->add('tel',IntegerType::class, array('attr' => array('placeholder'=>'Téléphone de l\'étudiant','class'=>'form-control')))
            ->add('email',EmailType::class, array('attr' => array('placeholder'=>'Email de l\'étudiant','class'=>'form-control')))
            ->add('diplome',ChoiceType::class, array('placeholder'=>'Diplome de l\'étudiant','choices' => array('Bac'=>'Bac','Bac + 1'=>'Bac + 1','Bac + 2'=>'Bac + 2','Bac + 3'=>'Bac + 3','Bac + 4/5'=>'Bac + 4/5'),'attr' => array('class'=>'form-control')))
            ->add('etablissement',TextType::class, array('attr' => array('placeholder'=>'Etablissement de l\'étudiant','class'=>'form-control')))
            ->add('anneeObtention',DateType::class, array(
                'years' => range(1950, date('Y'))))

            ->add('niveau', EntityType::class, array(
                'required' => true,
                'class' => 'GestionNiveauBundle:Niveau',
                'placeholder' => '-- Choisir le Niveau --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nomNiveau', 'ASC');
                },
                'choice_label' => 'nomNiveau',
                'attr' => array(
                    'class'     => 'form-control',
                ),
            ))

            ->add('filiere', EntityType::class, array(
                'required' => true,
                'class' => 'GestionFiliereBundle:Filiere',
                'placeholder' => '-- Filière Souhaitée --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.intitule', 'ASC');
                },
                'choice_label' => 'intitule',
                'attr' => array(
                    'class'     => 'form-control',
                ),
            ))
            ->add('login',TextType::class, array('attr' => array('placeholder'=>'choisir un nom d\'utilisateur','class'=>'form-control')))
            ->add('password',PasswordType::class, array('attr' => array('placeholder'=>'Choisir un mot de Passe','class'=>'form-control')))
            ->add('submit',SubmitType::class, array('attr' => array('class'=>'btn btn-success')))
        ;
    }

    public function getName()
    {
        return 'etudiant';
    }

}
