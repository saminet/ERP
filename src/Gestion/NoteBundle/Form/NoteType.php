<?php

namespace Gestion\NoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

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
                    'property' => "libCategory", 'multiple' => false, 'expanded' => true
                ),
            ))

            ->add('matiere', EntityType::class, array(
                'required' => true,
                'class' => 'GestionMatiereBundle:Matiere',
                'placeholder' => '-- Choisir la matière --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nomMatiere', 'ASC');
                },
                'choice_label' => 'nomMatiere',
                'attr' => array(
                    'class'     => 'form-control',
                    'property' => "libCategory", 'multiple' => false, 'expanded' => true
                ),
            ))

            ->add('cc',TextType::class, array('attr' => array('placeholder'=>'Controle Continue','class'=>'form-control')))
            ->add('ds',TextType::class, array('attr' => array('placeholder'=>'Devoir Surveillé','class'=>'form-control')))
            ->add('examen',TextType::class, array('attr' => array('placeholder'=>'Note Examen','class'=>'form-control')))
            ->add('semestre',ChoiceType::class, array('placeholder'=>'Choisir le semestre','choices' => array('Semestre 1'=>'Semestre 1','Semestre 2'=>'Semestre 2'),
                'expanded' => true,
                'multiple' => false))
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
