<?php

namespace Gestion\PreinscriptionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParentsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class, array('attr' => array('placeholder'=>'Nom du Parent','class'=>'form-control')))
            ->add('prenom',TextType::class, array('attr' => array('placeholder'=>'Prénom du Parent','class'=>'form-control')))
            ->add('dateNaissance',DateType::class, array(
                // render as a single text box
                'widget' => 'single_text'))
            ->add('sexe',ChoiceType::class, array('placeholder'=>'Choisir le sexe','choices' => array('Masculin'=>'Masculin','Féminin'=>'Féminin'),
                'expanded' => true,
                'multiple' => false))
            ->add('adresse',TextareaType::class, array('attr' => array('placeholder'=>'Adresse du Parent','class'=>'form-control')))
            ->add('lieuNaissance',TextType::class, array('attr' => array('placeholder'=>'Lieu de Naissance du Parent','class'=>'form-control')))
            ->add('nationalite',TextType::class, array('attr' => array('placeholder'=>'Nationalité du Parent','class'=>'form-control')))
            ->add('ville',TextType::class, array('attr' => array('placeholder'=>'Ville du Parent','class'=>'form-control')))
            ->add('numCinPass',IntegerType::class, array('attr' => array('placeholder'=>'Numéro CIN/Passeport','class'=>'form-control')))
            ->add('tel',TextType::class, array('attr' => array('placeholder'=>'Téléphone du Parent','class'=>'form-control')))
            ->add('email',EmailType::class, array('attr' => array('placeholder'=>'Email du Parent', 'min' => 8,
                'max' => 50, 'class'=>'form-control')))
            ->add('login',TextType::class, array('attr' => array('placeholder'=>'choisir un nom d\'utilisateur','class'=>'form-control')))
            ->add('password',PasswordType::class, array('attr' => array('placeholder'=>'Choisir un mot de Passe','class'=>'form-control')))
            ->add('submit',SubmitType::class, array('attr' => array('class'=>'btn btn-success')))
        ;
              }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\PreinscriptionBundle\Entity\Parents'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_preinscriptionbundle_parents';
    }


}
