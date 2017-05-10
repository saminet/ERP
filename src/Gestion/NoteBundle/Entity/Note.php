<?php

namespace Gestion\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gestion\PreinscriptionBundle\Entity\Etudiant;
use Gestion\MatiereBundle\Entity\Matiere;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="Gestion\NoteBundle\Repository\NoteRepository")
 */
class Note
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
     * @ORM\ManyToOne(targetEntity="Gestion\PreinscriptionBundle\Entity\Etudiant", cascade={"persist"})
     */
    private $etudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="matiere", type="string", length=255)
     */
    private $matiere;

    /**
     * @var float
     *
     * @ORM\Column(name="cc", type="float")
     */
    private $cc;

    /**
     * @var float
     *
     * @ORM\Column(name="ds", type="float")
     */
    private $ds;

    /**
     * @var float
     *
     * @ORM\Column(name="examen", type="float")
     */
    private $examen;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

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
     * Set type
     *
     * @param string $type
     *
     * @return Note
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set session
     *
     * @param string $session
     *
     * @return Note
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set matiere
     *
     * @param string $matiere
     *
     * @return Note
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return string
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Note
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set cc
     *
     * @param float $cc
     *
     * @return Note
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * Get cc
     *
     * @return float
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set ds
     *
     * @param float $ds
     *
     * @return Note
     */
    public function setDs($ds)
    {
        $this->ds = $ds;

        return $this;
    }

    /**
     * Get ds
     *
     * @return float
     */
    public function getDs()
    {
        return $this->ds;
    }

    /**
     * Set examen
     *
     * @param float $examen
     *
     * @return Note
     */
    public function setExamen($examen)
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return float
     */
    public function getExamen()
    {
        return $this->examen;
    }

    /**
     * Set etudiant
     *
     * @param \Gestion\PreinscriptionBundle\Entity\Etudiant $etudiant
     *
     * @return Note
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
}
