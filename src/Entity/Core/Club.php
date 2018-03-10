<?php

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club
 *
 * @ORM\Table(name="core_club")
 * @ORM\Entity(repositoryClass="App\Repository\Core\ClubRepository")
 */
class Club
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Core\ClubLogo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true))
     * @Assert\Valid()
     */
    private $logo;

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
     * @ORM\Column(name="nomClub", type="string", length=125)
     */
    private $nomClub;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=50)
     */
    private $abreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroFederal", type="string", length=30)
     */
    private $numeroFederal;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur1", type="string", length=40, nullable=true)
     */
    private $couleur1;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur2", type="string", length=40, nullable=true)
     */
    private $couleur2;

    /**
     * @var string
     *
     * @ORM\Column(name="siteInternet", type="string", length=255, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="nomGymnase", type="string", length=100, nullable=true)
     */
    private $nomGymnase;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse1", type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse2", type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostale", type="string", length=40, nullable=true)
     */
    private $codePostale;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=125, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(name="monclub", type="boolean")
     */
    private $monclub ;

    /**
     * @ORM\Column(name="convention", type="boolean")
     */
    private $convention ;

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
     * Set nomClub
     *
     * @param string $nomClub
     *
     * @return Club
     */
    public function setNomClub($nomClub)
    {
        $this->nomClub = $nomClub;

        return $this;
    }

    /**
     * Get nomClub
     *
     * @return string
     */
    public function getNomClub()
    {
        return $this->nomClub;
    }

    /**
     * Set abreviation
     *
     * @param string $abreviation
     *
     * @return Club
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * Get abreviation
     *
     * @return string
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Set numeroFederal
     *
     * @param string $numeroFederal
     *
     * @return Club
     */
    public function setNumeroFederal($numeroFederal)
    {
        $this->numeroFederal = $numeroFederal;

        return $this;
    }

    /**
     * Get numeroFederal
     *
     * @return string
     */
    public function getNumeroFederal()
    {
        return $this->numeroFederal;
    }

    /**
     * Set couleur1
     *
     * @param string $couleur1
     *
     * @return Club
     */
    public function setCouleur1($couleur1)
    {
        $this->couleur1 = $couleur1;

        return $this;
    }

    /**
     * Get couleur1
     *
     * @return string
     */
    public function getCouleur1()
    {
        return $this->couleur1;
    }

    /**
     * Set couleur2
     *
     * @param string $couleur2
     *
     * @return Club
     */
    public function setCouleur2($couleur2)
    {
        $this->couleur2 = $couleur2;

        return $this;
    }

    /**
     * Get couleur2
     *
     * @return string
     */
    public function getCouleur2()
    {
        return $this->couleur2;
    }

    /**
     * Set siteInternet
     *
     * @param string $siteInternet
     *
     * @return Club
     */
    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    /**
     * Get siteInternet
     *
     * @return string
     */
    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Club
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set nomGymnase
     *
     * @param string $nomGymnase
     *
     * @return Club
     */
    public function setNomGymnase($nomGymnase)
    {
        $this->nomGymnase = $nomGymnase;

        return $this;
    }

    /**
     * Get nomGymnase
     *
     * @return string
     */
    public function getNomGymnase()
    {
        return $this->nomGymnase;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return Club
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Get adresse1
     *
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * Set adresse2
     *
     * @param string $adresse2
     *
     * @return Club
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2
     *
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * Set codePostale
     *
     * @param string $codePostale
     *
     * @return Club
     */
    public function setCodePostale($codePostale)
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    /**
     * Get codePostale
     *
     * @return string
     */
    public function getCodePostale()
    {
        return $this->codePostale;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Club
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
     * Set monclub
     *
     * @param boolean $monclub
     *
     * @return Club
     */
    public function setMonclub($monclub)
    {
        $this->monclub = $monclub;

        return $this;
    }

    /**
     * Get monclub
     *
     * @return boolean
     */
    public function getMonclub()
    {
        return $this->monclub;
    }

    /**
     * Set convention
     *
     * @param boolean $convention
     *
     * @return Club
     */
    public function setConvention($convention)
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * Get convention
     *
     * @return boolean
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Club
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
     * @return Club
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
     * Set logo
     *
     * @param \App\Entity\Core\ClubLogo $logo
     *
     * @return Club
     */
    public function setLogo(\App\Entity\Core\ClubLogo $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \App\Entity\Core\ClubLogo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return Club
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
     * @return Club
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
