<?php

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Licencie
 *
 * @ORM\Table(name="core_licencie")
 * @ORM\Entity(repositoryClass="App\Repository\Core\LicencieRepository")
 */
class Licencie
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Core\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true))
     */
    private $imgProfil;

    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Bureau\FicheBureau", mappedBy="licencies", orphanRemoval=true)
     */
    private $ficheBureau;

    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Entrainement", mappedBy="encadrants", orphanRemoval=true)
     */
    private $entrainements;

    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe\Equipe", mappedBy="entraineurs", orphanRemoval=true)
     */
    private $equipes;

    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe\Equipe", mappedBy="joueurs", orphanRemoval=true)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Import\FichierLicencie", inversedBy="licencies", cascade={"persist"})
     * @ORM\JoinColumn(name="fichierLicencie_id", referencedColumnName="id")
     */
    private $fichierLicencie;

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
     * @ORM\Column(name="prenom", type="string", length=75)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=75)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroLicence", type="string", length=255, nullable=true)
     */
    private $numeroLicence;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=125, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=50, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=50, nullable=true)
     */
    private $portable;

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

    public function getPrenomNom()
    {
        return sprintf('%s  %s', $this->prenom, $this->nom);
    }

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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Licencie
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Licencie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Licencie
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Licencie
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Licencie
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return Licencie
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Licencie
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
     * @return Licencie
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
     * Add equipe
     *
     * @param \App\Entity\Equipe\Equipe $equipe
     *
     * @return Licencie
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
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return Licencie
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
     * @return Licencie
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
     * Set fichierLicencie
     *
     * @param \App\Entity\Import\FichierLicencie $fichierLicencie
     *
     * @return Licencie
     */
    public function setFichierLicencie(\App\Entity\Import\FichierLicencie $fichierLicencie = null)
    {
        $this->fichierLicencie = $fichierLicencie;

        return $this;
    }

    /**
     * Get fichierLicencie
     *
     * @return \App\Entity\Import\FichierLicencie
     */
    public function getFichierLicencie()
    {
        return $this->fichierLicencie;
    }


    /**
     * Set numeroLicence
     *
     * @param string $numeroLicence
     *
     * @return Licencie
     */
    public function setNumeroLicence($numeroLicence)
    {
        $this->numeroLicence = $numeroLicence;

        return $this;
    }

    /**
     * Get numeroLicence
     *
     * @return string
     */
    public function getNumeroLicence()
    {
        return $this->numeroLicence;
    }

    /**
     * Add entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     *
     * @return Licencie
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
     * Add team
     *
     * @param \App\Entity\Equipe\Equipe $team
     *
     * @return Licencie
     */
    public function addTeam(\App\Entity\Equipe\Equipe $team)
    {
        $this->team[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \App\Entity\Equipe\Equipe $team
     */
    public function removeTeam(\App\Entity\Equipe\Equipe $team)
    {
        $this->team->removeElement($team);
    }

    /**
     * Get team
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeam()
    {
        return $this->team;
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

    /**
     * Set imgProfil
     *
     * @param \App\Entity\Core\Image $imgProfil
     *
     * @return Licencie
     */
    public function setImgProfil(\App\Entity\Core\ImgProfil $imgProfil = null)
    {
        $this->imgProfil = $imgProfil;

        return $this;
    }

    /**
     * Get imgProfil
     *
     * @return \App\Entity\Core\Image
     */
    public function getImgProfil()
    {
        return $this->imgProfil;
    }
}
