<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class message
{
       /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="message")
     * @ORM\JoinColumn(name="user_send", referencedColumnName="id")
     */
    protected $userSend;
      /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="message")
     * @ORM\JoinColumn(name="user_requre", referencedColumnName="id")
     */
    protected $userRequre;
    
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;
   
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
     * Set text
     *
     * @param string $text
     *
     * @return message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set userSend
     *
     * @param \AppBundle\Entity\user $userSend
     *
     * @return message
     */
    public function setUserSend(\AppBundle\Entity\user $userSend)
    {
        $this->userSend = $userSend;

        return $this;
    }

    /**
     * Get userSend
     *
     * @return \AppBundle\Entity\user
     */
    public function getUserSend()
    {
        return $this->userSend;
    }

    /**
     * Set userRequre
     *
     * @param \AppBundle\Entity\user $userRequre
     *
     * @return message
     */
    public function setUserRequre(\AppBundle\Entity\user $userRequre = null)
    {
        $this->userRequre = $userRequre;

        return $this;
    }

    /**
     * Get userRequre
     *
     * @return \AppBundle\Entity\user
     */
    public function getUserRequre()
    {
        return $this->userRequre;
    }
}
