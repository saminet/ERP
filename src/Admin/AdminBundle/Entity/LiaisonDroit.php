<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LiaisonDroit
 *
 * @ORM\Table(name="liaison_droit")
 * @ORM\Entity(repositoryClass="Admin\AdminBundle\Repository\LiaisonDroitRepository")
 */
class LiaisonDroit
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
     *@ORM\ManyToOne(targetEntity="Admin\AdminBundle\Entity\DroitAcces")
     *@ORM\JoinColumn(onDelete="SET NULL")
     */
     private $droitAcces;

    /**
     *@ORM\ManyToOne(targetEntity="Admin\AdminBundle\Entity\Acces")
     *@ORM\joinColumn(onDelete="SET NULL")
     */
     private $acces;


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
     * Set droitAcces
     *
     * @param \Admin\AdminBundle\Entity\DroitAcces $droitAcces
     *
     * @return LiaisonDroit
     */
    public function setDroitAcces(\Admin\AdminBundle\Entity\DroitAcces $droitAcces = null)
    {
        $this->droitAcces = $droitAcces;

        return $this;
    }

    /**
     * Get droitAcces
     *
     * @return \Admin\AdminBundle\Entity\DroitAcces
     */
    public function getDroitAcces()
    {
        return $this->droitAcces;
    }

    /**
     * Set acces
     *
     * @param \Admin\AdminBundle\Entity\Acces $acces
     *
     * @return LiaisonDroit
     */
    public function setAcces(\Admin\AdminBundle\Entity\Acces $acces = null)
    {
        $this->acces = $acces;

        return $this;
    }

    /**
     * Get acces
     *
     * @return \Admin\AdminBundle\Entity\Acces
     */
    public function getAcces()
    {
        return $this->acces;
    }
}
