<?php

namespace Gestion\SalleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity(repositoryClass="Gestion\SalleBundle\Repository\SalleRepository")
 */
class Salle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSalle", type="string", length=255)
     */
    private $nomSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrMaxChaises", type="integer")
     */
    private $nbrMaxChaises;

    /**
     * @var int
     *
     * @ORM\Column(name="etage", type="integer")
     */
    private $etage;


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
     * Set nomSalle
     *
     * @param string $nomSalle
     *
     * @return Salle
     */
    public function setNomSalle($nomSalle)
    {
        $this->nomSalle = $nomSalle;

        return $this;
    }

    /**
     * Get nomSalle
     *
     * @return string
     */
    public function getNomSalle()
    {
        return $this->nomSalle;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Salle
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return bool
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nbrMaxChaises
     *
     * @param integer $nbrMaxChaises
     *
     * @return Salle
     */
    public function setNbrMaxChaises($nbrMaxChaises)
    {
        $this->nbrMaxChaises = $nbrMaxChaises;

        return $this;
    }

    /**
     * Get nbrMaxChaises
     *
     * @return int
     */
    public function getNbrMaxChaises()
    {
        return $this->nbrMaxChaises;
    }

    /**
     * Set etage
     *
     * @param integer $etage
     *
     * @return Salle
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return int
     */
    public function getEtage()
    {
        return $this->etage;
    }
}
