<?php

namespace App\Entity\Core\Bureau;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Fonction
 *
 * @ORM\Table(name="core_bureau_fonction")
 * @ORM\Entity(repositoryClass="App\Repository\Core\Bureau\FonctionRepository")
 */
class Fonction
{
    /**
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="App\Entity\Core\Bureau\FicheBureau", mappedBy="fonctions")
     */
    private $ficheBureau;

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
     * @ORM\Column(name="fonction", type="string", length=125)
     */
    private $fonction;

    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", length=125)
     */
    private $groupe;

    /**
     * @var int
     *
     * @ORM\Column(name="hierarchie", type="smallint")
     */
    private $hierarchie;

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
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Fonction
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set groupe
     *
     * @param string $groupe
     *
     * @return Fonction
     */
    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return string
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set hierarchie
     *
     * @param integer $hierarchie
     *
     * @return Fonction
     */
    public function setHierarchie($hierarchie)
    {
        $this->hierarchie = $hierarchie;

        return $this;
    }

    /**
     * Get hierarchie
     *
     * @return int
     */
    public function getHierarchie()
    {
        return $this->hierarchie;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Fonction
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
     * @return Fonction
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
     * @return Fonction
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
     * @return Fonction
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
        $this->ficheBureau = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ficheBureau
     *
     * @param \App\Entity\Core\Bureau\FicheBureau $ficheBureau
     *
     * @return Fonction
     */
    public function addFicheBureau(\App\Entity\Core\Bureau\FicheBureau $ficheBureau)
    {
        $this->ficheBureau[] = $ficheBureau;

        return $this;
    }

    /**
     * Remove ficheBureau
     *
     * @param \App\Entity\Core\Bureau\FicheBureau $ficheBureau
     */
    public function removeFicheBureau(\App\Entity\Core\Bureau\FicheBureau $ficheBureau)
    {
        $this->ficheBureau->removeElement($ficheBureau);
    }

    /**
     * Get ficheBureau
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFicheBureau()
    {
        return $this->ficheBureau;
    }
}
