<?php

namespace Gestion\UEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UE
 *
 * @ORM\Table(name="ue")
 * @ORM\Entity(repositoryClass="Gestion\UEBundle\Repository\UERepository")
 */
class UE
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

    /**
     * @var float
     *
     * @ORM\Column(name="coeffUnite", type="float")
     */
    private $coeffUnite;

    /**
     * @var float
     *
     * @ORM\Column(name="creditUnite", type="float")
     */
    private $creditUnite;


    /**
     * @ORM\ManyToOne(targetEntity="Gestion\NiveauBundle\Entity\Niveau", cascade={"persist"})
     */
    private $Niveau;


    /**
     * @ORM\ManyToMany(targetEntity="Gestion\MatiereBundle\Entity\Matiere")
     */
    protected $matieres;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="filiere", type="string", length=255)
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
     * Set coeffUnite
     *
     * @param float $coeffUnite
     *
     * @return UE
     */
    public function setCoeffUnite($coeffUnite)
    {
        $this->coeffUnite = $coeffUnite;

        return $this;
    }

    /**
     * Get coeffUnite
     *
     * @return float
     */
    public function getCoeffUnite()
    {
        return $this->coeffUnite;
    }

    /**
     * Set creditUnite
     *
     * @param float $creditUnite
     *
     * @return UE
     */
    public function setCreditUnite($creditUnite)
    {
        $this->creditUnite = $creditUnite;

        return $this;
    }

    /**
     * Get creditUnite
     *
     * @return float
     */
    public function getCreditUnite()
    {
        return $this->creditUnite;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return UE
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
     * Set Niveau
     *
     * @param \Gestion\NiveauBundle\Entity\Niveau $Niveau
     *
     * @return UE
     */
    public function setNiveau(\Gestion\NiveauBundle\Entity\Niveau $Niveau = null)
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    /**
     * Get Niveau
     *
     * @return \Gestion\NiveauBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->Niveau;
    }

    public function __toString()
    {
        return $this->Niveau;
    }

    /**
     * Add matiere
     *
     * @param \Gestion\MatiereBundle\Entity\Matiere $matiere
     *
     * @return UE
     */
    public function addMatiere(\Gestion\MatiereBundle\Entity\Matiere $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere
     *
     * @param \Gestion\MatiereBundle\Entity\Matiere $matiere
     */
    public function removeMatiere(\Gestion\MatiereBundle\Entity\Matiere $matiere)
    {
        $this->matieres->removeElement($matiere);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Set filiere
     *
     * @param string $filiere
     *
     * @return UE
     */
    public function setFiliere($filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Get filiere
     *
     * @return string
     */
    public function getFiliere()
    {
        return $this->filiere;
    }
}
