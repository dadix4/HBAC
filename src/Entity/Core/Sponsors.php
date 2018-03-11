<?php

namespace Hbac\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sponsors
 *
 * @ORM\Table(name="sponsors")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Hbac\CoreBundle\Repository\SponsorsRepository")
 */
class Sponsors
{

    /**
     * @ORM\ManyToOne(targetEntity="Hbac\UserBundle\Entity\User", inversedBy="sponsors", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="Hbac\EquipeBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true))
     * @Assert\Valid()
     */
    private $image;

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true))
     */
    private $web;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="created")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true))
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=50, nullable=true))
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true))
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cpmtadresse", type="string", length=255, nullable=true))
     */
    private $cpmtadresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=10, nullable=true))
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true))
     */
    private $ville;

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
     * @return Sponsors
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
     * Set web
     *
     * @param string $web
     *
     * @return Sponsors
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @ORM\PrePersist()
     *
     */
    public function prePersist()
    {
        $this->created = new \DateTime;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Sponsors
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set author
     *
     * @param \Hbac\UserBundle\Entity\User $author
     *
     * @return Sponsors
     */
    public function setAuthor(\Hbac\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Hbac\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set image
     *
     * @param \Hbac\EquipeBundle\Entity\Image $image
     *
     * @return Sponsors
     */
    public function setImage(\Hbac\EquipeBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Hbac\EquipeBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Sponsors
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Sponsors
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Sponsors
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cpmtadresse
     *
     * @param string $cpmtadresse
     *
     * @return Sponsors
     */
    public function setCpmtadresse($cpmtadresse)
    {
        $this->cpmtadresse = $cpmtadresse;

        return $this;
    }

    /**
     * Get cpmtadresse
     *
     * @return string
     */
    public function getCpmtadresse()
    {
        return $this->cpmtadresse;
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return Sponsors
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Sponsors
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }
}
