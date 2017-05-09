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
     * @var string
     *
     * @ORM\Column(name="etudiant", type="string", length=255)
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
     * Set etudiant
     *
     * @param string $etudiant
     *
     * @return Note
     */
    public function setEtudiant($etudiant)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return string
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }
}
