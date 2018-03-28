<?php

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Saison
 *
 * @ORM\Table(name="core_saison")
 * @ORM\Entity(repositoryClass="App\Repository\Core\SaisonRepository")
 * @UniqueEntity("nomSaison",  message="Cette saison existe déjà")
 */
class Saison
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Core\Entrainement", mappedBy="saison" , cascade={"persist", "remove"})
     */
    private $entrainements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipe\Equipe", mappedBy="saison" , cascade={"persist", "remove"})
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Core\Bureau\FicheBureau", mappedBy="ficheBureau" , cascade={"persist", "remove"})
     */
    private $ficheBureau;


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
     * @ORM\Column(name="nomSaison", type="string", length=50, unique=true)
     */
    private $nomSaison;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nomSaison"})
     * @ORM\Column(name="slug", type="string", length=125)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saisonDebut", type="date")
     */
    private $saisonDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saisonFin", type="date")
     */
    private $saisonFin;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_At", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at",type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string $createdBy
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var string $updatedBy
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $updatedBy;



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
     * Set nomSaison
     *
     * @param string $nomSaison
     *
     * @return Saison
     */
    public function setNomSaison($nomSaison)
    {
        $this->nomSaison = $nomSaison;

        return $this;
    }

    /**
     * Get nomSaison
     *
     * @return string
     */
    public function getNomSaison()
    {
        return $this->nomSaison;
    }

    /**
     * Set saisonDebut
     *
     * @param \DateTime $saisonDebut
     *
     * @return Saison
     */
    public function setSaisonDebut($saisonDebut)
    {
        $this->saisonDebut = $saisonDebut;

        return $this;
    }

    /**
     * Get saisonDebut
     *
     * @return \DateTime
     */
    public function getSaisonDebut()
    {
        return $this->saisonDebut;
    }

    /**
     * Set saisonFin
     *
     * @param \DateTime $saisonFin
     *
     * @return Saison
     */
    public function setSaisonFin($saisonFin)
    {
        $this->saisonFin = $saisonFin;

        return $this;
    }

    /**
     * Get saisonFin
     *
     * @return \DateTime
     */
    public function getSaisonFin()
    {
        return $this->saisonFin;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Saison
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Saison
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Saison
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return Saison
     */
    public function setCreatedBy(\App\Entity\Utilisateurs\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \App\Entity\Utilisateurs\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \App\Entity\Utilisateurs\User $updatedBy
     *
     * @return Saison
     */
    public function setUpdatedBy(\App\Entity\Utilisateurs\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \App\Entity\Utilisateurs\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Saison
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add equipe
     *
     * @param \App\Entity\Equipe\Equipe $equipe
     *
     * @return Saison
     */
    public function addEquipe(\App\Entity\Equipe\Equipe $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     *
     * @param \App\Entity\Equipe\Equipe $equipe
     */
    public function removeEquipe(\App\Entity\Equipe\Equipe $equipe)
    {
        $this->equipes->removeElement($equipe);
    }

    public function setEquipes($equipes)
    {
        $this->equipes = $equipes;

        return $this;
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    /**
     * Add entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     *
     * @return Saison
     */
    public function addEntrainement(\App\Entity\Core\Entrainement $entrainement)
    {
        $this->entrainements[] = $entrainement;

        return $this;
    }

    /**
     * Remove entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     */
    public function removeEntrainement(\App\Entity\Core\Entrainement $entrainement)
    {
        $this->entrainements->removeElement($entrainement);
    }

    /**
     * Get entrainements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntrainements()
    {
        return $this->entrainements;
    }

    /**
     * Remove ficheBureau
     *
     * @param \App\Entity\Core\Bureau\FicheBureau $ficheBureau
     */
    public function removeFicheBureau(\App\Entity\Core\Bureau\FicheBureau $ficheBureau)
    {
        $this->ficheBureau->removeElement($ficheBureau);
    }

    /**
     * Get ficheBureau
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFicheBureau()
    {
        return $this->ficheBureau;
    }
}
