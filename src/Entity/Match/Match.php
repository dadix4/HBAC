<?php

namespace App\Entity\Match;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Match
 *
 * @ORM\Table(name="match_match")
 * @ORM\Entity(repositoryClass="App\Repository\Match\MatchRepository")
 */
class Match
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe\Equipe", inversedBy="matchs", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true))
     * @ORM\JoinTable(name="matchs_equipe",
     *   joinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="equipe_id", referencedColumnName="id")}
     * )
     */
    private $equipe_matchs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Club" )
     * @ORM\JoinColumn(name="clubvisiteur_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true))
     */
    private $clubVisiteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Club")
     * @ORM\JoinColumn(name="clublocal_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true))
     */
    private $clubReceveur;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Import\ImportMatch", cascade={"persist"}, inversedBy="matchs")
     * @ORM\JoinColumn(name="importMatch_id", referencedColumnName="id")
     */
    private $importMatch;

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
     * @ORM\Column(name="semaine", type="string")
     */
    private $semaine;

    /**
     * @var string
     *
     * @ORM\Column(name="numPoule", type="string", length=75, nullable=true)
     */
    private $numPoule;

    /**
     * @var string
     *
     * @ORM\Column(name="competition", type="string", length=100)
     */
    private $competition;

    /**
     * @var string
     *
     * @ORM\Column(name="poule", type="string", length=50)
     */
    private $poule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time")
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=75)
     */
    private $local;

    /**
     * @var string
     *
     * @ORM\Column(name="visiteur", type="string", length=75)
     */
    private $visiteur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSalle", type="string", length=75, nullable=true)
     */
    private $nomSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseSalle", type="string", length=125, nullable=true)
     */
    private $adresseSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="cpSalle", type="string", length=30, nullable=true)
     */
    private $cpSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=55)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="numReceveur", type="string", length=75, nullable=true)
     */
    private $numReceveur;

    /**
     * @var string
     *
     * @ORM\Column(name="numVisiteur", type="string", length=75, nullable=true)
     */
    private $numVisiteur;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreLocal", type="string", length=255, nullable=true)
     */
    private $scoreLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreVisiteur", type="string", length=255, nullable=true)
     */
    private $scoreVisiteur;

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
     * Set semaine
     *
     * @param \DateTime $semaine
     *
     * @return Match
     */
    public function setSemaine($semaine)
    {
        $this->semaine = $semaine;

        return $this;
    }

    /**
     * Get semaine
     *
     * @return string
     */
    public function getSemaine()
    {
        return $this->semaine;
    }

    /**
     * Set numPoule
     *
     * @param integer $numPoule
     *
     * @return Match
     */
    public function setNumPoule($numPoule)
    {
        $this->numPoule = $numPoule;

        return $this;
    }

    /**
     * Get numPoule
     *
     * @return int
     */
    public function getNumPoule()
    {
        return $this->numPoule;
    }

    /**
     * Set competition
     *
     * @param string $competition
     *
     * @return Match
     */
    public function setCompetition($competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * Get competition
     *
     * @return string
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Set poule
     *
     * @param string $poule
     *
     * @return Match
     */
    public function setPoule($poule)
    {
        $this->poule = $poule;

        return $this;
    }

    /**
     * Get poule
     *
     * @return string
     */
    public function getPoule()
    {
        return $this->poule;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Match
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
     * Set heure
     *
     * @param \DateTime $heure
     *
     * @return Match
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set nomSalle
     *
     * @param string $nomSalle
     *
     * @return Match
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
     * Set adresseSalle
     *
     * @param string $adresseSalle
     *
     * @return Match
     */
    public function setAdresseSalle($adresseSalle)
    {
        $this->adresseSalle = $adresseSalle;

        return $this;
    }

    /**
     * Get adresseSalle
     *
     * @return string
     */
    public function getAdresseSalle()
    {
        return $this->adresseSalle;
    }

    /**
     * Set cpSalle
     *
     * @param string $cpSalle
     *
     * @return Match
     */
    public function setCpSalle($cpSalle)
    {
        $this->cpSalle = $cpSalle;

        return $this;
    }

    /**
     * Get cpSalle
     *
     * @return string
     */
    public function getCpSalle()
    {
        return $this->cpSalle;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Match
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set numReceveur
     *
     * @param string $numReceveur
     *
     * @return Match
     */
    public function setNumReceveur($numReceveur)
    {
        $this->numReceveur = $numReceveur;

        return $this;
    }

    /**
     * Get numReceveur
     *
     * @return string
     */
    public function getNumReceveur()
    {
        return $this->numReceveur;
    }

    /**
     * Set numVisiteur
     *
     * @param string $numVisiteur
     *
     * @return Match
     */
    public function setNumVisiteur($numVisiteur)
    {
        $this->numVisiteur = $numVisiteur;

        return $this;
    }

    /**
     * Get numVisiteur
     *
     * @return string
     */
    public function getNumVisiteur()
    {
        return $this->numVisiteur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipe_matchs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Match
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
     * @return Match
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
     * Add equipeMatch
     *
     * @param \App\Entity\Equipe\Equipe $equipeMatch
     *
     * @return Match
     */
    public function addEquipeMatch(\App\Entity\Equipe\Equipe $equipeMatch)
    {
        $this->equipe_matchs[] = $equipeMatch;

        return $this;
    }

    /**
     * Remove equipeMatch
     *
     * @param \App\Entity\Equipe\Equipe $equipeMatch
     */
    public function removeEquipeMatch(\App\Entity\Equipe\Equipe $equipeMatch)
    {
        $this->equipe_matchs->removeElement($equipeMatch);
    }

    /**
     * Get equipeMatchs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipeMatchs()
    {
        return $this->equipe_matchs;
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
     * @return Match
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
     * Set importMatch
     *
     * @param \App\Entity\Import\ImportMatch $importMatch
     *
     * @return Match
     */
    public function setImportMatch(\App\Entity\Import\ImportMatch $importMatch = null)
    {
        $this->importMatch = $importMatch;

        return $this;
    }

    /**
     * Get importMatch
     *
     * @return \App\Entity\Import\ImportMatch
     */
    public function getImportMatch()
    {
        return $this->importMatch;
    }

    /**
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return Match
     */
    public function setCreatedBy(\App\Entity\Utilisateurs\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Set scoreLocal
     *
     * @param string $scoreLocal
     *
     * @return Match
     */
    public function setScoreLocal($scoreLocal)
    {
        $this->scoreLocal = $scoreLocal;

        return $this;
    }

    /**
     * Get scoreLocal
     *
     * @return string
     */
    public function getScoreLocal()
    {
        return $this->scoreLocal;
    }

    /**
     * Set scoreVisiteur
     *
     * @param string $scoreVisiteur
     *
     * @return Match
     */
    public function setScoreVisiteur($scoreVisiteur)
    {
        $this->scoreVisiteur = $scoreVisiteur;

        return $this;
    }

    /**
     * Get scoreVisiteur
     *
     * @return string
     */
    public function getScoreVisiteur()
    {
        return $this->scoreVisiteur;
    }

    /**
     * Set local
     *
     * @param string $local
     *
     * @return Match
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set visiteur
     *
     * @param string $visiteur
     *
     * @return Match
     */
    public function setVisiteur($visiteur)
    {
        $this->visiteur = $visiteur;

        return $this;
    }

    /**
     * Get visiteur
     *
     * @return string
     */
    public function getVisiteur()
    {
        return $this->visiteur;
    }

    /**
     * Set clubVisiteur
     *
     * @param \App\Entity\Core\Club $clubVisiteur
     *
     * @return Match
     */
    public function setClubVisiteur(\App\Entity\Core\Club $clubVisiteur = null)
    {
        $this->clubVisiteur = $clubVisiteur;

        return $this;
    }

    /**
     * Get clubVisiteur
     *
     * @return \App\Entity\Core\Club
     */
    public function getClubVisiteur()
    {
        return $this->clubVisiteur;
    }

    /**
     * Set clubReceveur
     *
     * @param \App\Entity\Core\Club $clubReceveur
     *
     * @return Match
     */
    public function setClubReceveur(\App\Entity\Core\Club $clubReceveur = null)
    {
        $this->clubReceveur = $clubReceveur;

        return $this;
    }

    /**
     * Get clubReceveur
     *
     * @return \App\Entity\Core\Club
     */
    public function getClubReceveur()
    {
        return $this->clubReceveur;
    }
}
