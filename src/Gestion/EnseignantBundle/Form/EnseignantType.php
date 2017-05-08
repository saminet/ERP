<?php

namespace Gestion\EnseignantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;


class EnseignantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Nom de l\'enseignant')))
            ->add('prenom',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Prenom de l\'enseignant')))
            ->add('sexe',ChoiceType::class, array('placeholder'=>'Choisir le sexe','choices' => array('Masculin'=>'Masculin','Féminin'=>'Féminin'),
                'expanded' => true,
                'multiple' => false))
            ->add('adresse',TextareaType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Adresse de l\'enseignant')))
            ->add('email',emailType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Email de l\'enseignant')))
            ->add('dateNaissance',DateType::class, array(
                'years' => range(1950, date('Y'))))
            ->add('ville',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Ville de l\'enseignant')))
            ->add('lieuxNaissance',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Lieux de Naissance d\'enseignant')))
            ->add('nationalite',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Nationalité de l\'enseignant')))
            ->add('tel',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Téléphone')))
            ->add('cin',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Numéro CIN/Passeport')))
            ->add('rib',TextType::class, array('attr' => array('class'=>'form-control','placeholder'=>'Numéro de RIB')))
            ->add('login',TextType::class, array('label' => 'Nom d\'utilisateur', 'attr' => array('class'=>'form-control','placeholder'=>'Nom d\'utilisateur')))
            ->add('password',PasswordType::class, array('label' => 'Mot de Passe', 'attr' => array('class'=>'form-control','placeholder'=>'Mot de Passe')))
            ->add('submit',SubmitType::class, array('attr' => array('class'=>'btn btn-success')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\EnseignantBundle\Entity\Enseignant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_enseignantbundle_enseignant';
    }


}
