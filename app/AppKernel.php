<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new ERP\EnseignantBundle\ERPEnseignantBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new ERP\ParentBundle\ERPParentBundle(),
            new ERP\EtudiantBundle\ERPEtudiantBundle(),
            new ERP\vuescolaireBundle\ERPvuescolaireBundle(),
            new ERP\viescolaireBundle\ERPviescolaireBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new User\UserBundle\UserUserBundle(),
            new Admin\AdminBundle\AdminAdminBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Gestion\PreinscriptionBundle\GestionPreinscriptionBundle(),
            new Gestion\SalleBundle\GestionSalleBundle(),
            new Gestion\MatiereBundle\GestionMatiereBundle(),
            new Gestion\FiliereBundle\GestionFiliereBundle(),
            new Gestion\NiveauBundle\GestionNiveauBundle(),
            new Gestion\EnseignantBundle\GestionEnseignantBundle(),
            new Gestion\UEBundle\GestionUEBundle(),
            new Gestion\AbsenceBundle\GestionAbsenceBundle(),
            new Gestion\EventBundle\GestionEventBundle(),
            new Gestion\NoteBundle\GestionNoteBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
