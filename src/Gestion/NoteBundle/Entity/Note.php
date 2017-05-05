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
     *@ORM\ManyToOne(targetEntity="Gestion\PreinscriptionBundle\Entity\Etudiant")
     *@ORM\JoinColumn(onDelete="SET NULL")
     */
    private $etudiant;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\MatiereBundle\Entity\Matiere")
     *@ORM\JoinColumn(onDelete="SET NULL")
     */
    private $matiere;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="session", type="string", length=255)
     */
    private $session;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\AbsenceBundle\Entity\Classe")
     *@ORM\JoinColumn(onDelete="SET NULL")
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

    /**
     * Set matiere
     *
     * @param \Gestion\MatiereBundle\Entity\Matiere $matiere
     *
     * @return Note
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

    /**
     * Set note
     *
     * @param float $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set classe
     *
     * @param \Gestion\AbsenceBundle\Entity\Classe $classe
     *
     * @return Note
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
