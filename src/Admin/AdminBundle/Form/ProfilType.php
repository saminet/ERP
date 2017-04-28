<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
class ProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProfil',TextType::class, array('attr' => array('class'=>'form-control')))

            ->add('posteProfil',TextType::class, array('attr' => array('class'=>'form-control')))

            ->add('role', CheckboxType::class, array(

                'label'    => 'Agent de Saisie',

                'label'    => 'Validateur',

                'label'    => 'Enseignant',

                'label'    => 'Etudiant',

                'label'    => 'Parent',

                ))

            ->add('role', CheckboxType::class, array(

                'label'    => 'Agent de Saisie',

                'label'    => 'Validateur',

                'label'    => 'Enseignant',

                'label'    => 'Etudiant',

                'label'    => 'Parent',

            ))

            ->add('role', CheckboxType::class, array(

                'label'    => 'Agent de Saisie',
            ))

            ->add('role', CheckboxType::class, array(

                'label'    => 'Validateur',
            ))

            ->add('role', CheckboxType::class, array(

                'label'    => 'Enseignant',
            ))
            ->add('role', CheckboxType::class, array(

                'label'    => 'Etudiant',
            ))

            ->add('role', CheckboxType::class, array(
                'label'    => 'Parent',
            ))



            ->add('Enregistrer',SubmitType::class, array('attr' => array('class'=>'btn btn-success')));
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Entity\Profil'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_adminbundle_profil';
    }


}
