<?php

namespace Gestion\NoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class NoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classe', EntityType::class, array(
                'required' => true,
                'class' => 'GestionAbsenceBundle:Classe',
                'placeholder' => 'Nom de la Classe',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.intitule', 'ASC');
                },
                'choice_label' => 'intitule',
                'attr' => array(
                    'class'     => 'form-control',
                ),
            ))

            ->add('etudiant', EntityType::class, array(
                'required' => true,
                'class' => 'GestionPreinscriptionBundle:Etudiant',
                'placeholder' => '-- Choisir l\'étudiant --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'attr' => array(
                    'class'     => 'form-control',
                ),
            ))

            ->add('matiere',TextType::class, array('attr' => array('placeholder'=>'Nom de la matière','class'=>'form-control')))
            ->add('note',integerType::class, array('attr' => array('placeholder'=>'Note','class'=>'form-control')))
            ->add('type',TextType::class, array('attr' => array('placeholder'=>'Type du devoir','class'=>'form-control')))
            ->add('session',TextType::class, array('attr' => array('placeholder'=>'Nom de l\'étudiant','class'=>'form-control')))
            ->add('submit',SubmitType::class, array('attr' => array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\NoteBundle\Entity\Note'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_notebundle_note';
    }


}
