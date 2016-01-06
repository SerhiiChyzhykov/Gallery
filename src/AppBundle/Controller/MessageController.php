<?php

namespace AppBundle\Controller;
use AppBundle\Entity\message;
use AppBundle\Entity\user;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MessageController extends Controller
{
    /**
     *@Route("/message/{id}", name = "message")
      */
    public function indexAction(Request $request,$id)
    {
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:message');
      $query = $repository->createQueryBuilder('p')
      ->where('p.userRequre = :user_id_login ')
      ->groupBy('p.userSend')
      ->setParameter('user_id_login',$id)
      ->getQuery();
      $em = $this->getDoctrine()->getManager();
      $qb = $em->createQueryBuilder()
      ->select('COUNT(message.id)  ')
      ->from('AppBundle:message', 'message')
      ->where('message.userRequre = :id')
      ->groupBy('message.userSend')
      ->setParameter('id', $id);

      $message = $qb->getQuery()->getResult();
      $messages = $query->getScalarResult();
$query = $em->
createQuery("SELECT  p,
 COUNT(p.id) FROM AppBundle:message p WHERE  
 p.userRequre = 17 GROUP BY p.userSend");
$users = $query->getResult(); // array of CustomerDTO



      return $this->render('design/message.html.twig', array(
        'message' => $message,
        'messages' => $messages,
        'users' => $users,
        'id' => $id,
        'a' => 'a',
        'title' => 'Home',
        'url' => 'home',
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    /**
     *@Route("/message/{id}/{user}", name = "messages_user")
      */
    public function userAction($id, $user, Request $request)
    {
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:message');
      $query = $repository->createQueryBuilder('p')
      ->where('p.userRequre = :user_id_login ')
      ->groupBy('p.userSend')
      ->setParameter('user_id_login',$id)
      ->getQuery();
      $em = $this->getDoctrine()->getManager();
      $sender = $query->getResult();
      $send=$request->get('text');
      $em = $this->getDoctrine()->getManager();
      $requre =  $em->getRepository("AppBundle:user")->find($user);
      $id_user =$this->get('security.token_storage')->getToken()->getUser();
      $qb = $em->createQueryBuilder()
      ->select(' COUNT(t.id) ')
      ->from('AppBundle:message', 't')
      ->where('t.userSend = :user and t.userRequre = :id or t.userSend = :id and t.userRequre = :user')
      ->setParameter('user', $user)
      ->setParameter('id', $id);

      $messagess = $qb->getQuery()->getScalarResult();
      if(isset($_POST['send'])) 
      { 



        $messages = new Message();
        $messages->setText($send);
        $messages->setUserSend($id_user);
        $messages->setUserRequre($em->getRepository("AppBundle:user")->find($user));
        $em->persist($messages);
        $em->flush();


      } 
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:message');
      $query = $repository->createQueryBuilder('p')
      ->where('p.userRequre = :user_id_login and p.userSend = :user_s or p.userRequre = :user_s and p.userSend = :user_id_login ')
      ->setParameter('user_id_login',$id)
      ->setParameter('user_s',$user)
      ->orderBy('p.id','ASC')
      ->getQuery();

      $message = $query->getResult();







      return $this->render('design/message_user.html.twig', array(
        'message' => $message,
        'messagess' => $messagess,
        'requre' => $requre,
        'sender' => $sender,
        'user' => $user,
        'id' => $id,
        'a' => 'a',
        'title' => 'Home',
        'url' => 'home',
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

  }
