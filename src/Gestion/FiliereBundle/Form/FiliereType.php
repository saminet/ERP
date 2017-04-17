<?php

namespace Gestion\FiliereBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class FiliereType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule',TextType::class, array('attr' => array('class'=>'form-control')))
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
            ->add('submit',SubmitType::class, array('attr' => array('class'=>'btn btn-success')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\FiliereBundle\Entity\Filiere'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_filierebundle_filiere';
    }


}
