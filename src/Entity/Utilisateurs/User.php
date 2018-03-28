<?php


namespace App\Entity\Utilisateurs;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Utilisateurs\Avatar", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true))
     */
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Core\Licencie", orphanRemoval=true)
     */
    private $adherent;

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
     * Set adherent
     *
     * @param \App\Entity\Core\Licencie $adherent
     *
     * @return User
     */
    public function setAdherent(\App\Entity\Core\Licencie $adherent = null)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return \App\Entity\Core\Licencie
     */
    public function getAdherent()
    {
        return $this->adherent;
    }


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

    /**
     * Set avatar
     *
     * @param \App\Entity\Utilisateurs\Avatar $avatar
     *
     * @return User
     */
    public function setAvatar(\App\Entity\Utilisateurs\Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \App\Entity\Utilisateurs\Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * @return User
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

}
