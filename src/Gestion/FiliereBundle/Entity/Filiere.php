<?php

namespace Gestion\FiliereBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table(name="filiere")
 * @ORM\Entity(repositoryClass="Gestion\FiliereBundle\Repository\FiliereRepository")
 */
class Filiere
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
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    public function __toString()
    {
        return $this->intitule;
    }

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\NiveauBundle\Entity\Niveau")
     */
    private $niveau;

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
     * @return Filiere
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
     * Constructor
     */
    public function __construct()
    {
        $this->niveau = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add niveau
     *
     * @param \Gestion\NiveauBundle\Entity\Niveau $niveau
     *
     * @return Filiere
     */
    public function addNiveau(\Gestion\NiveauBundle\Entity\Niveau $niveau)
    {
        $this->niveau[] = $niveau;

        return $this;
    }

    /**
     * Remove niveau
     *
     * @param \Gestion\NiveauBundle\Entity\Niveau $niveau
     */
    public function removeNiveau(\Gestion\NiveauBundle\Entity\Niveau $niveau)
    {
        $this->niveau->removeElement($niveau);
    }

    /**
     * Get niveau
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set niveau
     *
     * @param \Gestion\NiveauBundle\Entity\Niveau $niveau
     *
     * @return Filiere
     */
    public function setNiveau(\Gestion\NiveauBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }
}
