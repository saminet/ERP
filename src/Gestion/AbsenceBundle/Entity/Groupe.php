<?php

namespace Gestion\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\Entity(repositoryClass="Gestion\AbsenceBundle\Repository\GroupeRepository")
 */
class Groupe
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
     * @ORM\Column(name="Intitule", type="string", length=255, unique=true)
     */
    private $intitule;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\AbsenceBundle\Entity\Classe")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $classe;

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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Groupe
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set classe
     *
     * @param \Gestion\AbsenceBundle\Entity\Classe $classe
     *
     * @return Groupe
     */
    public function setClasse(\Gestion\AbsenceBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \Gestion\AbsenceBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }
}
