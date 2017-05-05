<?php

namespace Gestion\NiveauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gestion\FiliereBundle\Entity\Filiere;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity(repositoryClass="Gestion\NiveauBundle\Repository\NiveauRepository")
 */
class Niveau
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
     * @ORM\Column(name="nomNiveau", type="string", length=255)
     */
    private $nomNiveau;
	
    public function __toString()
    {
        return $this->nomNiveau;
    }


    /**
     *@ORM\ManyToOne(targetEntity="Gestion\FiliereBundle\Entity\Filiere")
     *@ORM\JoinColumn(onDelete="SET NULL")
     */
    private $filiere;

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
     * Set nomNiveau
     *
     * @param string $nomNiveau
     *
     * @return Niveau
     */
    public function setNomNiveau($nomNiveau)
    {
        $this->nomNiveau = $nomNiveau;

        return $this;
    }

    /**
     * Get nomNiveau
     *
     * @return string
     */
    public function getNomNiveau()
    {
        return $this->nomNiveau;
    }


    /**
     * Set Filiere
     *
     * @param Filiere $filiere
     *
     * @return Niveau
     */
    public function setFiliere ($filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Get Filiere
     *
     * @return string
     */
    public function getFiliere()
    {
        return $this->filiere;
    }

}
