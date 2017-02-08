<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * categories
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class categories
{
      /**
     * @ORM\OneToMany(targetEntity="photo", mappedBy="categories")
     * @ORM\JoinColumn(name="photo", referencedColumnName="id" , onDelete="CASCADE")
     */
    protected $photo;

    public function __construct()
    {
        $this->photo = new ArrayCollection();
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return categories
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\photo $photo
     *
     * @return categories
     */
    public function addPhoto(\AppBundle\Entity\photo $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\photo $photo
     */
    public function removePhoto(\AppBundle\Entity\photo $photo)
    {
        $this->photo->removeElement($photo);
    }

    /**
     * Get photo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
