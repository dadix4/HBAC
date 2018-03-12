<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Reservation
 *
 * @ORM\Table(name="event_reservation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Event\ReservationRepository")
 */
class Reservation
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
     * @var string
     *
     * @ORM\Column(name="nomReservation", type="string", length=125)
     */
    private $nomReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="mailReservation", type="string", length=125)
     */
    private $mailReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="telReservation", type="string", length=50)
     */
    private $telReservation;

    /**
     * @var bool
     *
     * @ORM\Column(name="statutPaiement", type="boolean", nullable=true)
     */
    private $statutPaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePaiement", type="datetime", nullable=true)
     */
    private $datePaiement;

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
     * Set nomReservation
     *
     * @param string $nomReservation
     *
     * @return Reservation
     */
    public function setNomReservation($nomReservation)
    {
        $this->nomReservation = $nomReservation;

        return $this;
    }

    /**
     * Get nomReservation
     *
     * @return string
     */
    public function getNomReservation()
    {
        return $this->nomReservation;
    }

    /**
     * Set mailReservation
     *
     * @param string $mailReservation
     *
     * @return Reservation
     */
    public function setMailReservation($mailReservation)
    {
        $this->mailReservation = $mailReservation;

        return $this;
    }

    /**
     * Get mailReservation
     *
     * @return string
     */
    public function getMailReservation()
    {
        return $this->mailReservation;
    }

    /**
     * Set telReservation
     *
     * @param string $telReservation
     *
     * @return Reservation
     */
    public function setTelReservation($telReservation)
    {
        $this->telReservation = $telReservation;

        return $this;
    }

    /**
     * Get telReservation
     *
     * @return string
     */
    public function getTelReservation()
    {
        return $this->telReservation;
    }

    /**
     * Set statutPaiement
     *
     * @param boolean $statutPaiement
     *
     * @return Reservation
     */
    public function setStatutPaiement($statutPaiement)
    {
        $this->statutPaiement = $statutPaiement;

        return $this;
    }

    /**
     * Get statutPaiement
     *
     * @return bool
     */
    public function getStatutPaiement()
    {
        return $this->statutPaiement;
    }

    /**
     * Set datePaiement
     *
     * @param \DateTime $datePaiement
     *
     * @return Reservation
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return \DateTime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Reservation
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
     * @return Reservation
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
     * @return Reservation
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
     * @return Reservation
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

