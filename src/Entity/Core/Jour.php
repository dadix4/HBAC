<?php

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jour
 *
 * @ORM\Table(name="core_jour")
 * @ORM\Entity(repositoryClass="Repository\Core\JourRepository")
 */
class Jour
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Core\Entrainement", mappedBy="jourEntrainement" , cascade={"persist", "remove"})
     */
    private $entrainements;

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
     * @ORM\Column(name="jour", type="string", length=50)
     */
    private $jour;

    /**
     * @var int
     *
     * @ORM\Column(name="tri", type="integer")
     */
    private $tri;


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
     * Set jour
     *
     * @param string $jour
     *
     * @return Jour
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get jour
     *
     * @return string
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set tri
     *
     * @param integer $tri
     *
     * @return Jour
     */
    public function setTri($tri)
    {
        $this->tri = $tri;

        return $this;
    }

    /**
     * Get tri
     *
     * @return int
     */
    public function getTri()
    {
        return $this->tri;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entrainements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     *
     * @return Jour
     */
    public function addEntrainement(\App\Entity\Core\Entrainement $entrainement)
    {
        $this->entrainements[] = $entrainement;

        return $this;
    }

    /**
     * Remove entrainement
     *
     * @param \App\Entity\Core\Entrainement $entrainement
     */
    public function removeEntrainement(\App\Entity\Core\Entrainement $entrainement)
    {
        $this->entrainements->removeElement($entrainement);
    }

    /**
     * Get entrainements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntrainements()
    {
        return $this->entrainements;
    }
}
