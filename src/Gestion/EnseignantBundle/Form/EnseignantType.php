<?php

namespace Gestion\EnseignantBundle\Form;

use Symfony\Component\Form\AbstractType;
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
            ->add('nom',TextType::class, array('attr' => array('class'=>'form-control')))
            ->add('prenom',TextType::class, array('attr' => array('class'=>'form-control')))
            ->add('sexe',ChoiceType::class, array('choices' => array('Féminin'=>'Féminin','Masculin'=>'Masculin'),'attr' => array('class'=>'form-control')))
            ->add('adresse',TextareaType::class, array('attr' => array('class'=>'form-control')))
            ->add('email',emailType::class, array('attr' => array('class'=>'form-control')))
            ->add('age',IntegerType::class, array('attr' => array('class'=>'form-control')))
            ->add('dateNaissance',DateType::class, array('attr' => array('class'=>'form-control')))
            ->add('ville',TextType::class, array('attr' => array('class'=>'form-control')))
            ->add('lieuxNaissance',TextType::class, array('attr' => array('class'=>'form-control')))
            ->add('nationalite',TextType::class, array('attr' => array('class'=>'form-control')))
            ->add('login',TextType::class, array('label' => 'Nom d\'utilisateur', 'attr' => array('class'=>'form-control')))
            ->add('password',TextType::class, array('label' => 'Mot de Passe', 'attr' => array('class'=>'form-control')))
            ->add('tel',IntegerType::class, array('attr' => array('class'=>'form-control')))
            ->add('cin',IntegerType::class, array('attr' => array('class'=>'form-control')))
            ->add('rib',IntegerType::class, array('attr' => array('class'=>'form-control')))
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
