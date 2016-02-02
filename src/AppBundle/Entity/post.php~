<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class post
{
        /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="user", inversedBy="post")
     * @ORM\JoinColumn(name="username_id", referencedColumnName="id")
     */
    protected $usernameId;
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
     * @ORM\Column(name="post", type="string", length=255)
     */
    private $post;

  
    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer")
     */
    private $imageId;



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
     * Set post
     *
     * @param string $post
     *
     * @return post
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set imageId
     *
     * @param integer $imageId
     *
     * @return post
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get imageId
     *
     * @return integer
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set usernameId
     *
     * @param \AppBundle\Entity\user $usernameId
     *
     * @return post
     */
    public function setUsernameId(\AppBundle\Entity\user $usernameId = null)
    {
        $this->usernameId = $usernameId;

        return $this;
    }

    /**
     * Get usernameId
     *
     * @return \AppBundle\Entity\user
     */
    public function getUsernameId()
    {
        return $this->usernameId;
    }
}
