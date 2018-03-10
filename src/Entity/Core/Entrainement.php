<?php

namespace App\Entity\Core;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entrainement
 *
 * @ORM\Table(name="core_entrainement")
 * @ORM\Entity(repositoryClass="App\Repository\Core\EntrainementRepository")
 */
class Entrainement
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Licencie", inversedBy="entrainements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true))
     * @ORM\JoinTable(name="core_entrainement_encadrant",
     *   joinColumns={@ORM\JoinColumn(name="entrainement_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     * )
     */
    private $encadrants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe\Equipe", inversedBy="entrainements", cascade={"persist"})
     * @ORM\JoinTable(name="core_entrainement_equipe",
     *   joinColumns={@ORM\JoinColumn(name="entrainement_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="equipe_id", referencedColumnName="id")}
     * )
     */
    private $equipes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Saison", inversedBy="entrainements", cascade={"persist"})
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Jour", inversedBy="entrainements", cascade={"persist"})
     * @ORM\JoinColumn(name="jour_id", referencedColumnName="id")
     */
    private $jourEntrainement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Salle", inversedBy="entrainements", cascade={"persist"})
     * @ORM\JoinColumn(name="salle_id", referencedColumnName="id")
     */
    private $salle;

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
     * @ORM\Column(name="horaireDebut", type="time")
     */
    private $horaireDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaireFin", type="time")
     */
    private $horaireFin;

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
     * Set horaireDebut
     *
     * @param \DateTime $horaireDebut
     *
     * @return Entrainement
     */
    public function setHoraireDebut($horaireDebut)
    {
        $this->horaireDebut = $horaireDebut;

        return $this;
    }

    /**
     * Get horaireDebut
     *
     * @return \DateTime
     */
    public function getHoraireDebut()
    {
        return $this->horaireDebut;
    }

    /**
     * Set horaireFin
     *
     * @param \DateTime $horaireFin
     *
     * @return Entrainement
     */
    public function setHoraireFin($horaireFin)
    {
        $this->horaireFin = $horaireFin;

        return $this;
    }

    /**
     * Get horaireFin
     *
     * @return \DateTime
     */
    public function getHoraireFin()
    {
        return $this->horaireFin;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->encadrants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Entrainement
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
     * @return Entrainement
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
     * Add encadrant
     *
     * @param \App\Entity\Core\Licencie $encadrant
     *
     * @return Entrainement
     */
    public function addEncadrant(\App\Entity\Core\Licencie $encadrant)
    {
        $this->encadrants[] = $encadrant;

        return $this;
    }

    /**
     * Remove encadrant
     *
     * @param \App\Entity\Core\Licencie $encadrant
     */
    public function removeEncadrant(\App\Entity\Core\Licencie $encadrant)
    {
        $this->encadrants->removeElement($encadrant);
    }

    /**
     * Get encadrants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEncadrants()
    {
        return $this->encadrants;
    }

    /**
     * Add equipe
     *
     * @param \App\Entity\Equipe\Equipe $equipe
     *
     * @return Entrainement
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
     * Set saison
     *
     * @param \App\Entity\Core\Saison $saison
     *
     * @return Entrainement
     */
    public function setSaison(\App\Entity\Core\Saison $saison = null)
    {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return \App\Entity\Core\Saison
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set jourEntrainement
     *
     * @param \App\Entity\Core\Jour $jourEntrainement
     *
     * @return Entrainement
     */
    public function setJourEntrainement(\App\Entity\Core\Jour $jourEntrainement = null)
    {
        $this->jourEntrainement = $jourEntrainement;

        return $this;
    }

    /**
     * Get jourEntrainement
     *
     * @return \App\Entity\Core\Jour
     */
    public function getJourEntrainement()
    {
        return $this->jourEntrainement;
    }

    /**
     * Set salle
     *
     * @param \App\Entity\Core\Salle $salle
     *
     * @return Entrainement
     */
    public function setSalle(\App\Entity\Core\Salle $salle = null)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return \App\Entity\Core\Salle
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return Entrainement
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
     * @return Entrainement
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
}
