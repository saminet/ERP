<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acces
 *
 * @ORM\Table(name="acces")
 * @ORM\Entity(repositoryClass="Admin\AdminBundle\Repository\AccesRepository")
 */
class Acces
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *@ORM\ManyToOne(targetEntity="Admin\AdminBundle\Entity\Profil")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
     private $profil;

    /**
     *@ORM\ManyToOne(targetEntity="Admin\AdminBundle\Entity\Module")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
     private $module;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set profil
     *
     * @param \Admin\AdminBundle\Entity\Profil $profil
     *
     * @return Acces
     */
    public function setProfil(\Admin\AdminBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \Admin\AdminBundle\Entity\Profil
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set module
     *
     * @param \Admin\AdminBundle\Entity\Module $module
     *
     * @return Acces
     */
    public function setModule(\Admin\AdminBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Admin\AdminBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
