<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class user implements UserInterface, \Serializable
{
     /**
     * @ORM\OneToMany(targetEntity="post", mappedBy="user")
     */
     protected $post;

     public function __construct()
     {
        $this->post = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $git;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $google;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $rank;

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
            ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return user
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getavatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return user
     */
    public function setavatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getrank()
    {
        return $this->rank;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     */
    public function setrank($rank)
    {
        $this->rank = $rank;

        return $this;
    }


    /**
     * Get last_name
     *
     * @return string
     */
    public function getlast_name()
    {
        return $this->last_name;
    }

    /**
     * Set last_name
     *
     * @param string $last_name
     *
     * @return user
     */
    public function setlast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

        /**
     * Get first_name
     *
     * @return string
     */
        public function getfirst_name()
        {
            return $this->first_name;
        }

    /**
     * Set first_name
     *
     * @param string $first_name
     *
     * @return user
     */
    public function setfirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getgit()
    {
        return $this->git;
    }

    /**
     * Set git
     *
     * @param string $git
     *
     * @return user
     */
    public function setgit($git)
    {
        $this->git = $git;

        return $this;
    }

        /**
     * Get google
     *
     * @return string
     */
        public function getgoogle()
        {
            return $this->google;
        }

    /**
     * Set google
     *
     * @param string $google
     *
     * @return user
     */
    public function setgoogle($google)
    {
        $this->google = $google;

        return $this;
    }
    /**
     * Get twitter
     *
     * @return string
     */
    public function gettwitter()
    {
        return $this->twitter;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return user
     */
    public function settwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return user
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }



    /**
     * Add post
     *
     * @param \AppBundle\Entity\post $post
     *
     * @return user
     */
    public function addPost(\AppBundle\Entity\post $post)
    {
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\post $post
     */
    public function removePost(\AppBundle\Entity\post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }
}
