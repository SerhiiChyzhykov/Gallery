<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class photo
{

    /**
     * @ORM\ManyToOne(targetEntity="categories", inversedBy="photo")
     * @ORM\JoinColumn(name="categories_id", referencedColumnName="id")
     */
     protected $categories;
     /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="photo")
     * @ORM\JoinColumn(name="username_id", referencedColumnName="id")
     */
     protected $username;
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    


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
     * @return photo
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
     * Set description
     *
     * @param string $description
     *
     * @return photo
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
     * Set image
     *
     * @param string $image
     *
     * @return photo
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    

    /**
     * Set categories
     *
     * @param \AppBundle\Entity\categories $categories
     *
     * @return photo
     */
    public function setCategories(\AppBundle\Entity\categories $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \AppBundle\Entity\categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\user $user
     *
     * @return photo
     */
    public function setUser(\AppBundle\Entity\user $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\user
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set username
     *
     * @param \AppBundle\Entity\user $username
     *
     * @return photo
     */
    public function setUsername(\AppBundle\Entity\user $username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return \AppBundle\Entity\user
     */
    public function getUsername()
    {
        return $this->username;
    }
}
