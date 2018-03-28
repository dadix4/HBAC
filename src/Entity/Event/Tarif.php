<?php

namespace App\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Tarif
 *
 * @ORM\Table(name="event_tarif")
 * @ORM\Entity(repositoryClass="App\Repository\Event\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event\Evenement", inversedBy="tarifs")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $evenement;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="titrePrix", type="string", length=125)
     */
    private $titrePrix;

    public function getTitreetPrix()
    {
        return sprintf('%s  %s€', $this->titrePrix, $this->prix);
    }

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
     * Set prix
     *
     * @param float $prix
     *
     * @return Tarif
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set titrePrix
     *
     * @param string $titrePrix
     *
     * @return Tarif
     */
    public function setTitrePrix($titrePrix)
    {
        $this->titrePrix = $titrePrix;

        return $this;
    }

    /**
     * Get titrePrix
     *
     * @return string
     */
    public function getTitrePrix()
    {
        return $this->titrePrix;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tarif
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
     * @return Tarif
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
     * @return Tarif
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
     * @return Tarif
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
     * Set evenement
     *
     * @param \App\Entity\Event\Evenement $evenement
     *
     * @return Tarif
     */
    public function setEvenement(\App\Entity\Event\Evenement $evenement)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \App\Entity\Event\Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }
}

