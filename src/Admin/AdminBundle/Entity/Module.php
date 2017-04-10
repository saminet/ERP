<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="Admin\AdminBundle\Repository\ModuleRepository")
 */
class Module
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
     * @var string
     *
     * @ORM\Column(name="NomModule", type="string", length=255, unique=true)
     */
    private $nomModule;


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
     * Set nomModule
     *
     * @param string $nomModule
     *
     * @return Module
     */
    public function setNomModule($nomModule)
    {
        $this->nomModule = $nomModule;

        return $this;
    }

    /**
     * Get nomModule
     *
     * @return string
     */
    public function getNomModule()
    {
        return $this->nomModule;
    }
}
