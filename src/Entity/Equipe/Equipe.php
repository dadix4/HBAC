<?php

namespace App\Entity\Equipe;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Equipe
 *
 * @ORM\Table(name="equipe_equipe")
 * @ORM\Entity(repositoryClass="App\Repository\Equipe\EquipeRepository")
 */
class Equipe
{
    /**
     * Inverse Sid
     * @ORM\OneToMany(targetEntity="App\Entity\Match\Match", mappedBy="equipe", orphanRemoval=true)
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $matchs;

    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Entrainement", mappedBy="equipes", orphanRemoval=true)
     */
    private $entrainements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipe\RefCompetition", cascade={"persist", "remove"}, orphanRemoval=true, mappedBy="equipe")
     */
    private $refCompetitions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Licencie", inversedBy="equipes", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true))
     * @ORM\JoinTable(name="equipe_entraineur",
     *   joinColumns={@ORM\JoinColumn(name="equipe_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="licencie_id", referencedColumnName="id")}
     * )
     */
    private $entraineurs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Licencie", inversedBy="team", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true))
     * @ORM\JoinTable(name="equipe_joueur",
     *   joinColumns={@ORM\JoinColumn(name="equipe_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="licencie_id", referencedColumnName="id")}
     * )
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Saison", inversedBy="equipes", cascade={"persist"})
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe\Categorie", inversedBy="equipes", cascade={"persist"} )
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipe\Image", cascade={"persist", "remove"})
     */
    private $image;

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
     * @ORM\Column(name="nomEquipe", type="string", length=125)
     */
    private $nomEquipe;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nomEquipe"})
     * @ORM\Column(name="slug", type="string", length=125)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="convention", type="string", length=125, nullable=true)
     */
    private $convention;

    /**
     * @var string
     *
     * @ORM\Column(name="urlfhh", type="string", length=255, nullable=true)
     */
    private $urlfhh;

    /**
     * @var string
     *
     * @ORM\Column(name="division", type="string", length=255, nullable=true)
     */
    private $division;

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
     * Set nomEquipe
     *
     * @param string $nomEquipe
     *
     * @return Equipe
     */
    public function setNomEquipe($nomEquipe)
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    /**
     * Get nomEquipe
     *
     * @return string
     */
    public function getNomEquipe()
    {
        return $this->nomEquipe;
    }

    /**
     * Set convention
     *
     * @param string $convention
     *
     * @return Equipe
     */
    public function setConvention($convention)
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * Get convention
     *
     * @return string
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * Set urlfhh
     *
     * @param string $urlfhh
     *
     * @return Equipe
     */
    public function setUrlfhh($urlfhh)
    {
        $this->urlfhh = $urlfhh;

        return $this;
    }

    /**
     * Get urlfhh
     *
     * @return string
     */
    public function getUrlfhh()
    {
        return $this->urlfhh;
    }

    /**
     * Set division
     *
     * @param string $division
     *
     * @return Equipe
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Equipe
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Equipe
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
     * @return Equipe
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
     * @return Equipe
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
     * @return Equipe
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
     * Set saison
     *
     * @param \App\Entity\Core\Saison $saison
     *
     * @return Equipe
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
     * Set categorie
     *
     * @param \App\Entity\Equipe\Categorie $categorie
     *
     * @return Equipe
     */
    public function setCategorie(\App\Entity\Equipe\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \App\Entity\Equipe\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set image
     *
     * @param \App\Entity\Equipe\Image $image
     *
     * @return Equipe
     */
    public function setImage(\App\Entity\Equipe\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \App\Entity\Equipe\Image
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Add entraineur
     *
     * @param \App\Entity\Core\Licencie $entraineur
     *
     * @return Equipe
     */
    public function addEntraineur(\App\Entity\Core\Licencie $entraineur)
    {
        $this->entraineurs[] = $entraineur;

        return $this;
    }

    /**
     * Remove entraineur
     *
     * @param \App\Entity\Core\Licencie $entraineur
     */
    public function removeEntraineur(\App\Entity\Core\Licencie $entraineur)
    {
        $this->entraineurs->removeElement($entraineur);
    }

    /**
     * Get entraineurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntraineurs()
    {
        return $this->entraineurs;
    }

    /**
     * Add joueur
     *
     * @param \App\Entity\Core\Licencie $joueur
     *
     * @return Equipe
     */
    public function addJoueur(\App\Entity\Core\Licencie $joueur)
    {
        $this->joueurs[] = $joueur;

        return $this;
    }

    /**
     * Remove joueur
     *
     * @param \App\Entity\Core\Licencie $joueur
     */
    public function removeJoueur(\App\Entity\Core\Licencie $joueur)
    {
        $this->joueurs->removeElement($joueur);
    }

    /**
     * Get joueurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    /**
     * Add refCompetition
     *
     * @param \App\Entity\Equipe\RefCompetition $refCompetition
     *
     * @return Equipe
     */
    public function addRefCompetition(\App\Entity\Equipe\RefCompetition $refCompetition)
    {
        $this->refCompetitions[] = $refCompetition;
        $refCompetition->setEquipe($this); //Permet de réaliser la liaison onetomany + mettre 'by_reference' => false dans EquipeType.php
        return $this;
    }

    public function setRefCompetitions(\App\Entity\Equipe\RefCompetition $refCompetitions)
    {
        if(!empty($refCompetitions) && $refCompetitions === $this->refCompetitions) {
            reset($refCompetitions);
            $refCompetitions[key($refCompetitions)] = clone current($refCompetitions);
        }
        $this->refCompetitions = $refCompetitions;
        return $this;
    }


    /**
     * Remove refCompetition
     *
     * @param \App\Entity\Equipe\RefCompetition $refCompetition
     */
    public function removeRefCompetition(\App\Entity\Equipe\RefCompetition $refCompetition)
    {
        $this->refCompetitions->removeElement($refCompetition);
    }

    /**
     * Get refCompetitions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRefCompetitions()
    {
        return $this->refCompetitions;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->refCompetitions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entraineurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     *
     * @return Equipe
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
     * Add match
     *
     * @param \App\Entity\Match\Match $match
     *
     * @return Equipe
     */
    public function addMatch(\App\Entity\Match\Match $match)
    {
        $this->matchs[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \App\Entity\Match\Match $match
     */
    public function removeMatch(\App\Entity\Match\Match $match)
    {
        $this->matchs->removeElement($match);
    }

    /**
     * Get matchs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchs()
    {
        return $this->matchs;
    }
}
