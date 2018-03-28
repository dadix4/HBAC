<?php

namespace App\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Inscrit
 *
 * @ORM\Table(name="event_inscrit")
 * @ORM\Entity(repositoryClass="App\Repository\Event\InscritRepository")
 */
class Inscrit
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event\Reservation", inversedBy="inscrits")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     */
    private $reservation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event\Tarif")
     * @ORM\JoinColumn(nullable=true))
     */
    private $tarif;
    
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
     * @ORM\Column(name="nom", type="string", length=75)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=75)
     */
    private $prenom;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Inscrit
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Inscrit
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
     * Set reservation
     *
     * @param \App\Entity\Event\Reservation $reservation
     *
     * @return Inscrit
     */
    public function setReservation(\App\Entity\Event\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \App\Entity\Event\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set tarif
     *
     * @param \App\Entity\Event\Tarif $tarif
     *
     * @return Inscrit
     */
    public function setTarif(\App\Entity\Event\Tarif $tarif = null)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return \App\Entity\Event\Tarif
     */
    public function getTarif()
    {
        return $this->tarif;
    }
}

