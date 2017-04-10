<?php

namespace Gestion\NiveauBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class NiveauType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomNiveau',TextType::class, array('attr' => array('class'=>'form-control')))
            // ->add('nomFiliere',TextType::class, array('attr' => array('class'=>'form-control')))

            ->add('filiere', EntityType::class, array(
                'required' => true,
                'class' => 'GestionFiliereBundle:Filiere',
                'placeholder' => '-- choisir le filière --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.intitule', 'ASC');
                },
                'choice_label' => 'intitule',
                'attr' => array(
                    'class'     => 'form-control',
                ),
            ))

            // ->add('nomFiliere', 'entity', array('label' => 'nomFiliere','class' => 'GestionFiliereBundle:Filiere','expanded' => false,'multiple' => false))
            ->add('Enregistrer',SubmitType::class, array('attr' => array('class'=>'btn btn-success')));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\NiveauBundle\Entity\Niveau'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_niveaubundle_niveau';
    }


}
