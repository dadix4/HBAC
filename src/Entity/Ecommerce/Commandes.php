<?php

namespace App\Entity\Ecommerce;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Commandes
 *
 * @ORM\Table(name="ecommerce_commandes")
 * @ORM\Entity(repositoryClass="App\Repository\Ecommerce\CommandesRepository")
 */
class Commandes
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
     * @ORM\OneToMany(targetEntity="App\Entity\Ecommerce\Panier", mappedBy="commande", cascade={"remove"})
     */
    private $paniers;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs\UserAdresses")
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresseFacturation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs\UserAdresses")
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresseLivraison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;


    /**
     * @var bool
     *
     * @ORM\Column(name="valider", type="boolean")
     */
    private $valider;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="reference", type="integer")
     */
    private $reference;

    /**
     * @var array
     *
     * @ORM\Column(name="commandes", type="array")
     */
    private $commandes;

    /**
     * @var float
     *
     * @ORM\Column(name="totalHT", type="float", nullable=true)
     */
    private $totalHT;
    /**
     * @var float
     *
     * @ORM\Column(name="totalTVA", type="float", nullable=true)
     */
    private $totalTVA;
    /**
     * @var float
     *
     * @ORM\Column(name="totalTTC", type="float", nullable=true)
     */
    private $totalTTC;

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
     * Set valider
     *
     * @param boolean $valider
     *
     * @return Commandes
     */
    public function setValider($valider)
    {
        $this->valider = $valider;

        return $this;
    }

    /**
     * Get valider
     *
     * @return bool
     */
    public function getValider()
    {
        return $this->valider;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commandes
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
     * Set reference
     *
     * @param integer $reference
     *
     * @return Commandes
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set commandes
     *
     * @param array $commande
     *
     * @return Commandes
     */
    public function setCommandes($commandes)
    {
        $this->commandes = $commandes;

        return $this;
    }

    /**
     * Get commandes
     *
     * @return array
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set utilisateur
     *
     * @param \App\Entity\Utilisateurs\User $utilisateur
     *
     * @return Commandes
     */
    public function setUtilisateur(\App\Entity\Utilisateurs\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \App\Entity\Utilisateurs\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Commandes
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
     * @return Commandes
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
     * @return Commandes
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
     * @return Commandes
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
     * Constructor
     */
    public function __construct()
    {
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add panier
     *
     * @param \App\Entity\Ecommerce\Panier $panier
     *
     * @return Commandes
     */
    public function addPanier(\App\Entity\Ecommerce\Panier $panier)
    {
        $this->paniers[] = $panier;

        return $this;
    }

    /**
     * Remove panier
     *
     * @param \App\Entity\Ecommerce\Panier $panier
     */
    public function removePanier(\App\Entity\Ecommerce\Panier $panier)
    {
        $this->paniers->removeElement($panier);
    }

    /**
     * Get paniers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaniers()
    {
        return $this->paniers;
    }

    /**
     * Set adresseFacturation
     *
     * @param \App\Entity\Utilisateurs\userAdresses $adresseFacturation
     *
     * @return Commandes
     */
    public function setAdresseFacturation(\App\Entity\Utilisateurs\userAdresses $adresseFacturation = null)
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    /**
     * Get adresseFacturation
     *
     * @return \App\Entity\Utilisateurs\userAdresses
     */
    public function getAdresseFacturation()
    {
        return $this->adresseFacturation;
    }

    /**
     * Set adresseLivraison
     *
     * @param \App\Entity\Utilisateurs\userAdresses $adresseLivraison
     *
     * @return Commandes
     */
    public function setAdresseLivraison(\App\Entity\Utilisateurs\userAdresses $adresseLivraison = null)
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    /**
     * Get adresseLivraison
     *
     * @return \App\Entity\Utilisateurs\userAdresses
     */
    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     *
     * @return Commandes
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set totalTVA
     *
     * @param float $totalTVA
     *
     * @return Commandes
     */
    public function setTotalTVA($totalTVA)
    {
        $this->totalTVA = $totalTVA;

        return $this;
    }

    /**
     * Get totalTVA
     *
     * @return float
     */
    public function getTotalTVA()
    {
        return $this->totalTVA;
    }

    /**
     * Set totalTTC
     *
     * @param float $totalTTC
     *
     * @return Commandes
     */
    public function setTotalTTC($totalTTC)
    {

        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return float
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }
}
