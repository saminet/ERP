<?php

namespace Gestion\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbsenceRetard
 *
 * @ORM\Table(name="absence_retard")
 * @ORM\Entity(repositoryClass="Gestion\AbsenceBundle\Repository\AbsenceRetardRepository")
 */
class AbsenceRetard
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateAbs", type="datetime")
     */
    private $dateAbs;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\PreinscriptionBundle\Entity\Etudiant")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $etudiant;


    /**
     *@ORM\ManyToOne(targetEntity="Gestion\MatiereBundle\Entity\Matiere")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $matiere;

    /**
     * @var int
     *
     * @ORM\Column(name="NumSeance", type="integer")
     */
    private $numSeance;


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
     * Set dateAbs
     *
     * @param \DateTime $dateAbs
     *
     * @return AbsenceRetard
     */
    public function setDateAbs($dateAbs)
    {
        $this->dateAbs = $dateAbs;

        return $this;
    }

    /**
     * Get dateAbs
     *
     * @return \DateTime
     */
    public function getDateAbs()
    {
        return $this->dateAbs;
    }

    /**
     * Set numSeance
     *
     * @param integer $numSeance
     *
     * @return AbsenceRetard
     */
    public function setNumSeance($numSeance)
    {
        $this->numSeance = $numSeance;

        return $this;
    }

    /**
     * Get numSeance
     *
     * @return int
     */
    public function getNumSeance()
    {
        return $this->numSeance;
    }

    /**
     * Set etudiant
     *
     * @param \Gestion\AbsenceBundle\Entity\Etudiant $etudiant
     *
     * @return AbsenceRetard
     */
    public function setEtudiant(\Gestion\PreinscriptionBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Gestion\PreinscriptionBundle\Entity\Etudiant
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set matiere
     *
     * @param \Gestion\MatiereBundle\Entity\Matiere $matiere
     *
     * @return AbsenceRetard
     */
    public function setMatiere(\Gestion\MatiereBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \Gestion\MatiereBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }
}
