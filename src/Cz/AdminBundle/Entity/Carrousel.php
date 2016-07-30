<?php

namespace Cz\AdminBundle\Entity;

use Cz\ManagerBundle\Entity\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Carrousel
 *
 * @ORM\Table(name="cz_adminbundle_carrousel")
 * @ORM\Entity(repositoryClass="Cz\AdminBundle\Repository\CarrouselRepository")
 */
class Carrousel
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
     * @ORM\Column(name="format", type="boolean")
     */
    private $format;
    /**
     * @var string
     *
     * @ORM\Column(name="fleches", type="boolean")
     */
    private $fleches;

    /**
     * @ORM\OneToOne(targetEntity="Cz\AdminBundle\Entity\MediaAdmin", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;


    /**
     * Unidirectional - Many users have marked many comments as read
     *
     * @ORM\ManyToMany(targetEntity="Cz\AdminBundle\Entity\Namec", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="name_read_carrousel",
     *   joinColumns={@ORM\JoinColumn(name="carrousel_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="namec_id", referencedColumnName="id")}
     * )
     */
    private $namecs;



    /**
     * Constructor
     */
    public function __construct()
    {

        $this->namecs = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set format
     *
     * @param boolean $format
     *
     * @return Carrousel
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return boolean
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set fleches
     *
     * @param boolean $fleches
     *
     * @return Carrousel
     */
    public function setFleches($fleches)
    {
        $this->fleches = $fleches;

        return $this;
    }

    /**
     * Get fleches
     *
     * @return boolean
     */
    public function getFleches()
    {
        return $this->fleches;
    }

    /**
     * Set image
     *
     * @param \Cz\AdminBundle\Entity\MediaAdmin $image
     *
     * @return Carrousel
     */
    public function setImage(\Cz\AdminBundle\Entity\MediaAdmin $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Cz\AdminBundle\Entity\MediaAdmin
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add page
     *
     * @param \Cz\AdminBundle\Entity\PagesCarrousel $page
     *
     * @return Carrousel
     */
    public function addPage(\Cz\AdminBundle\Entity\PagesCarrousel $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \Cz\AdminBundle\Entity\PagesCarrousel $page
     */
    public function removePage(\Cz\AdminBundle\Entity\PagesCarrousel $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Add namec
     *
     * @param \Cz\AdminBundle\Entity\Namec $namec
     *
     * @return Carrousel
     */
    public function addNamec(\Cz\AdminBundle\Entity\Namec $namec)
    {
        $this->namecs[] = $namec;

        return $this;
    }

    /**
     * Remove namec
     *
     * @param \Cz\AdminBundle\Entity\Namec $namec
     */
    public function removeNamec(\Cz\AdminBundle\Entity\Namec $namec)
    {
        $this->namecs->removeElement($namec);
    }

    /**
     * Get namecs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNamecs()
    {
        return $this->namecs;
    }
}
