<?php

namespace Gestion\AbsenceBundle\Form;

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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GroupeType extends AbstractType
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
                'placeholder' => '-- Choisir la Classe --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        // ->join('u.niveau','n')
                        ->orderBy('u.intitule', 'ASC');
                },
                'choice_label' => 'intitule',
                'attr' => array(
                    'class'     => 'form-control',
                    'property' => "libCategory", 'multiple' => false, 'expanded' => true
                ),
            ))

            ->add('intitule',TextType::class, array('attr' => array('placeholder'=>'Intitulé du Groupe','class'=>'form-control')))

            ->add('nombre',IntegerType::class, array('attr' => array('placeholder'=>'Nombre du Groupe','class'=>'form-control')))

            ->add('submit',SubmitType::class, array('attr' => array('label'=>'Sauvegarder','class'=>'btn btn-success')))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\AbsenceBundle\Entity\Groupe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_absencebundle_groupe';
    }


}
