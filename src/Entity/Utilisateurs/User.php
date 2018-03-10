<?php


namespace App\Entity\Utilisateurs;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_stripe", type="string", nullable=true)
     */
    private $idStripe;

    public function __construct()
    {
        parent::__construct();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ecommerce\Commandes", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateurs\UserAdresses", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;

    /**
     * Add commande
     *
     * @param \App\Entity\Ecommerce\Commandes $commande
     *
     * @return User
     */
    public function addCommande(\App\Entity\Ecommerce\Commandes $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \App\Entity\Ecommerce\Commandes $commande
     */
    public function removeCommande(\App\Entity\Ecommerce\Commandes $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adress
     *
     * @param \App\Entity\Utilisateurs\UserAdresses $adress
     *
     * @return User
     */
    public function addAdress(\App\Entity\Utilisateurs\UserAdresses $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \App\Entity\Utilisateurs\UserAdresses $adress
     */
    public function removeAdress(\App\Entity\Utilisateurs\UserAdresses $adress)
    {
        $this->adresses->removeElement($adress);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set idStripe
     *
     * @param string $idStripe
     *
     * @return User
     */
    public function setIdStripe($idStripe)
    {
        $this->idStripe = $idStripe;

        return $this;
    }

    /**
     * Get idStripe
     *
     * @return string
     */
    public function getIdStripe()
    {
        return $this->idStripe;
    }
}
