<?php

namespace Gestion\PreinscriptionBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('sexe')
            ->add('age')
            ->add('adresse')
            ->add('lieuNaissance')
            ->add('ville')
            ->add('numCinPass')
            ->add('tel')
            ->add('email')
            ->add('diplome')
            ->add('etablissement')
            ->add('anneeObtention')
            ->add('message')
            ->add('niveau')
            ->add('formation')
            ->add('nationalite')
            ->add('diplome')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion\PreinscritBndle\Entity\Etudiant'
        ));
    }

    public function getName()
    {
        return 'etudiant';
    }

}
