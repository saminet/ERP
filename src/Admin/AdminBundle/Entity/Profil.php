<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="Admin\AdminBundle\Repository\ProfilRepository")
 */
class Profil
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
     * @ORM\Column(name="NomProfil", type="string", length=255)
     */
    private $nomProfil;

    /**
     * @var string
     *
     * @ORM\Column(name="PosteProfil", type="string", length=255)
     */
    private $posteProfil;
    
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
     * Set nomProfil
     *
     * @param string $nomProfil
     *
     * @return Profil
     */
    public function setNomProfil($nomProfil)
    {
        $this->nomProfil = $nomProfil;

        return $this;
    }

    /**
     * Get nomProfil
     *
     * @return string
     */
    public function getNomProfil()
    {
        return $this->nomProfil;
    }

    /**
     * Set posteProfil
     *
     * @param string $posteProfil
     *
     * @return Profil
     */
    public function setPosteProfil($posteProfil)
    {
        $this->posteProfil = $posteProfil;

        return $this;
    }

    /**
     * Get posteProfil
     *
     * @return string
     */
    public function getPosteProfil()
    {
        return $this->posteProfil;
    }
}
