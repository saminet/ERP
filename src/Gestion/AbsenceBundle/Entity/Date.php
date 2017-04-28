<?php

namespace Gestion\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Date
 *
 * @ORM\Table(name="date")
 * @ORM\Entity(repositoryClass="Gestion\AbsenceBundle\Repository\DateRepository")
 */
class Date
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
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\AbsenceBundle\Entity\Groupe")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $groupe;

    /**
     *@ORM\ManyToOne(targetEntity="Gestion\MatiereBundle\Entity\Matiere")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
    private $matiere;

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
     * @return Date
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
     * Set groupe
     *
     * @param \Gestion\AbsenceBundle\Entity\Groupe $groupe
     *
     * @return Date
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

    /**
     * Set matiere
     *
     * @param \Gestion\MatiereBundle\Entity\Matiere $matiere
     *
     * @return Date
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
