<?php

namespace Gestion\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnneScolaire
 *
 * @ORM\Table(name="anne_scolaire")
 * @ORM\Entity(repositoryClass="Gestion\AbsenceBundle\Repository\AnneScolaireRepository")
 */
class AnneScolaire
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
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\PreinscriptionBundle\Entity\Etudiant")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $etudiant;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\AbsenceBundle\Entity\Groupe")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $groupe;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AnneScolaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etudiant
     *
     * @param \Gestion\PreinscriptionBundle\Entity\Etudiant $etudiant
     *
     * @return AnneScolaire
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
     * Set groupe
     *
     * @param \Gestion\AbsenceBundle\Entity\Groupe $groupe
     *
     * @return AnneScolaire
     */
    public function setGroupe(\Gestion\AbsenceBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Gestion\AbsenceBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

}

