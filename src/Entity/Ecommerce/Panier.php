<?php

namespace App\Entity\Ecommerce;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="ecommerce_panier")
 * @ORM\Entity(repositoryClass="App\Repository\Ecommerce\PanierRepository")
 */
class Panier
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ecommerce\Produits", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ecommerce\Commandes", inversedBy="paniers", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prixUnitaireHT", type="float")
     */
    private $prixUnitaireHT;

    /**
     * @var float
     *
     * @ORM\Column(name="prixUnitaireTTC", type="float")
     */
    private $prixUnitaireTTC;

    /**
     * @var float
     *
     * @ORM\Column(name="tvaUnitaire", type="float")
     */
    private $tvaUnitaire;


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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Panier
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set produit
     *
     * @param \App\Entity\Ecommerce\Produits $produit
     *Q
     * @return Panier
     */
    public function setProduit(\App\Entity\Ecommerce\Produits $produit)
    {
        $this->produit = $produit;
        return $this;
    }

    /**
     * Get produit
     *
     * @return \App\Entity\Ecommerce\Produits
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Get allProduits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllProduits()
    {
        return $this->produit;
    }


    /**
     * Set prixUnitaireHT
     *
     * @param float $prixUnitaireHT
     *
     * @return Panier
     */
    public function setPrixUnitaireHT($prixUnitaireHT)
    {
        $this->prixUnitaireHT = $prixUnitaireHT;

        return $this;
    }

    /**
     * Get prixUnitaireHT
     *
     * @return float
     */
    public function getPrixUnitaireHT()
    {
        return $this->prixUnitaireHT;
    }

    /**
     * Set prixUnitaireTTC
     *
     * @param float $prixUnitaireTTC
     *
     * @return Panier
     */
    public function setPrixUnitaireTTC($prixUnitaireTTC)
    {
        $this->prixUnitaireTTC = $prixUnitaireTTC;

        return $this;
    }

    /**
     * Get prixUnitaireTTC
     *
     * @return float
     */
    public function getPrixUnitaireTTC()
    {
        return $this->prixUnitaireTTC;
    }

    /**
     * Set tvaUnitaire
     *
     * @param float $tvaUnitaire
     *
     * @return Panier
     */
    public function setTvaUnitaire($tvaUnitaire)
    {
        $this->tvaUnitaire = $tvaUnitaire;

        return $this;
    }

    /**
     * Get tvaUnitaire
     *
     * @return float
     */
    public function getTvaUnitaire()
    {
        return $this->tvaUnitaire;
    }

    /**
     * Set commande
     *
     * @param \App\Entity\Ecommerce\Commandes $commande
     *
     * @return Panier
     */
    public function setCommande(\App\Entity\Ecommerce\Commandes $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \App\Entity\Ecommerce\Commandes
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
