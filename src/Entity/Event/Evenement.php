<?php

namespace App\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Evenement
 *
 * @ORM\Table(name="event_evenement")
 * @ORM\Entity(repositoryClass="App\Repository\Event\EvenementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Evenement
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Event\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true))
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event\Tarif", cascade={"persist", "remove"} , mappedBy="evenement")
     * @ORM\JoinColumn(nullable=true))
     */
    private $tarifs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event\Reservation", cascade={"persist", "remove"}, mappedBy="evenement")
     */
    private $reservations;

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
     * @ORM\Column(name="titre", type="string", length=125)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=true)
     */
    private $heure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datelimit", type="date", nullable=true)
     */
    private $datelimit;

    /**
     * @var string
     *
     * @ORM\Column(name="bodyMail", type="text", nullable=true)
     */
    private $bodyMail;

    /**
     * @var bool
     *
     * @ORM\Column(name="gratuit", type="boolean", nullable=true)
     */
    private $gratuit;

    /**
     * @var bool
     *
     * @ORM\Column(name="resaGroupe", type="boolean", nullable=true)
     */
    private $resaGroupe;

    /**
     * @var bool
     *
     * @ORM\Column(name="resaEquipe", type="boolean", nullable=true)
     */
    private $resaEquipe;

    /**
     * @var string
     *
     * @ORM\Column(name="mailNotification", type="string", length=125)
     */
    private $mailNotification;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Evenement
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
     * @return Evenement
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
     * Set datelimit
     *
     * @param \DateTime $datelimit
     *
     * @return Evenement
     */
    public function setDatelimit($datelimit)
    {
        $this->datelimit = $datelimit;

        return $this;
    }

    /**
     * Get datelimit
     *
     * @return \DateTime
     */
    public function getDatelimit()
    {
        return $this->datelimit;
    }

    /**
     * Set bodyMail
     *
     * @param string $bodyMail
     *
     * @return Evenement
     */
    public function setBodyMail($bodyMail)
    {
        $this->bodyMail = $bodyMail;

        return $this;
    }

    /**
     * Get bodyMail
     *
     * @return string
     */
    public function getBodyMail()
    {
        return $this->bodyMail;
    }

    /**
     * Set gratuit
     *
     * @param boolean $gratuit
     *
     * @return Evenement
     */
    public function setGratuit($gratuit)
    {
        $this->gratuit = $gratuit;

        return $this;
    }

    /**
     * Get gratuit
     *
     * @return bool
     */
    public function getGratuit()
    {
        return $this->gratuit;
    }

    /**
     * Set resaGroupe
     *
     * @param boolean $resaGroupe
     *
     * @return Evenement
     */
    public function setResaGroupe($resaGroupe)
    {
        $this->resaGroupe = $resaGroupe;

        return $this;
    }

    /**
     * Get resaGroupe
     *
     * @return bool
     */
    public function getResaGroupe()
    {
        return $this->resaGroupe;
    }

    /**
     * Set resaEquipe
     *
     * @param boolean $resaEquipe
     *
     * @return Evenement
     */
    public function setResaEquipe($resaEquipe)
    {
        $this->resaEquipe = $resaEquipe;

        return $this;
    }

    /**
     * Get resaEquipe
     *
     * @return bool
     */
    public function getResaEquipe()
    {
        return $this->resaEquipe;
    }

    /**
     * Set mailNotification
     *
     * @param string $mailNotification
     *
     * @return Evenement
     */
    public function setMailNotification($mailNotification)
    {
        $this->mailNotification = $mailNotification;

        return $this;
    }

    /**
     * Get mailNotification
     *
     * @return string
     */
    public function getMailNotification()
    {
        return $this->mailNotification;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
        $this->tarifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set image
     *
     * @param \App\Entity\Event\Image $image
     *
     * @return Evenement
     */
    public function setImage(\App\Entity\Event\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \App\Entity\Event\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add tarif
     *
     * @param \App\Entity\Event\Tarif $tarif
     *
     * @return Evenement
     */
    public function addTarif(\App\Entity\Event\Tarif $tarif)
    {
        $this->tarifs[] = $tarif;
        $tarif->setEvenement($this); //Permet de réaliser la liaison onetomany
        return $this;
    }

    /**
     * Remove tarif
     *
     * @param \App\Entity\Event\Tarif $tarif
     */
    public function removeTarif(\App\Entity\Event\Tarif $tarif)
    {
        $this->tarifs->removeElement($tarif);
    }

    /**
     * Get tarifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTarifs()
    {
        return $this->tarifs;
    }

    /**
     * Add reservation
     *
     * @param \App\Entity\Event\Reservation $reservation
     *
     * @return Evenement
     */
    public function addReservation(\App\Entity\Event\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \App\Entity\Event\Reservation $reservation
     */
    public function removeReservation(\App\Entity\Event\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}

