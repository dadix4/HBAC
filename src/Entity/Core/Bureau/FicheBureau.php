<?php

namespace App\Entity\Core\Bureau;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * FicheBureau
 *
 * @ORM\Table(name="core_bureau_fiche_bureau")
 * @ORM\Entity(repositoryClass="App\Repository\Core\Bureau\FicheBureauRepository")
 */
class FicheBureau
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Licencie", inversedBy="ficheBureau", cascade={"persist"})
     * @ORM\JoinColumn(name="licencie_id", referencedColumnName="id")
     */
    private $licencies;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Bureau\Fonction", inversedBy="ficheBureau")
     * @ORM\JoinTable(name="fiche_bureau",
     *   joinColumns={@ORM\JoinColumn(name="fichelicencie_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="fonction_id", referencedColumnName="id")}
     * )
     */
    private $fonctions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Core\Saison", inversedBy="ficheBureau", cascade={"persist"})
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    private $saison;


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
     * Constructor
     */
    public function __construct()
    {
        $this->fonctions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FicheBureau
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
     * @return FicheBureau
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
     * Set licencies
     *
     * @param \App\Entity\Core\Licencie $licencies
     *
     * @return FicheBureau
     */
    public function setLicencies(\App\Entity\Core\Licencie $licencies = null)
    {
        $this->licencies = $licencies;

        return $this;
    }

    /**
     * Get licencies
     *
     * @return \App\Entity\Core\Licencie
     */
    public function getLicencies()
    {
        return $this->licencies;
    }

    /**
     * Add fonction
     *
     * @param \App\Entity\Core\Bureau\Fonction $fonction
     *
     * @return FicheBureau
     */
    public function addFonction(\App\Entity\Core\Bureau\Fonction $fonction)
    {
        $this->fonctions[] = $fonction;

        return $this;
    }

    /**
     * Remove fonction
     *
     * @param \App\Entity\Core\Bureau\Fonction $fonction
     */
    public function removeFonction(\App\Entity\Core\Bureau\Fonction $fonction)
    {
        $this->fonctions->removeElement($fonction);
    }

    /**
     * Get fonctions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFonctions()
    {
        return $this->fonctions;
    }

    /**
     * Set saison
     *
     * @param \App\Entity\Core\Saison $saison
     *
     * @return FicheBureau
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
     * Set createdBy
     *
     * @param \App\Entity\Utilisateurs\User $createdBy
     *
     * @return FicheBureau
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
     * @return FicheBureau
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
