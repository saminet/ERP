<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DroitAcces
 *
 * @ORM\Table(name="droit_acces")
 * @ORM\Entity(repositoryClass="Admin\AdminBundle\Repository\DroitAccesRepository")
 */
class DroitAcces
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
     * @ORM\Column(name="nomDroit", type="string", length=255, unique=true)
     */
    private $nomDroit;


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
     * Set nomDroit
     *
     * @param string $nomDroit
     *
     * @return DroitAcces
     */
    public function setNomDroit($nomDroit)
    {
        $this->nomDroit = $nomDroit;

        return $this;
    }

    /**
     * Get nomDroit
     *
     * @return string
     */
    public function getNomDroit()
    {
        return $this->nomDroit;
    }
}
