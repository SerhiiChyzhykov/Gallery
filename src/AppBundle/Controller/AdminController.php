<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class AdminController extends Controller
{
    /**
     *@Route("/profile",name="profile")
     */
    public function homeAction(Request $request)
    {

      $message = [];
      $data = $request->get('search');
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.title LIKE :title')
      ->setParameter('title','%'.$data.'%')
      ->getQuery();

      $ser = $query->getResult();
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $ser,$request->query->getInt('page', 1),8);

      if (!$ser) {
       $message['danger'] = '
       Search No results: ' .$data;
     }elseif(!empty($data)){ $message['success'] = '
     Search: ' .$data;}

     $user =  $this->get('security.token_storage')->getToken()->getUser();

     if($user):

      $repo = $this->getDoctrine()->getManager()
    ->getRepository('AppBundle:photo');

    $qb = $repo->createQueryBuilder('a');
    $qb->select('COUNT(a)');
    $qb->where('a.username = :usernameId');
    $qb->setParameter('usernameId', $user);

    $photos = $qb->getQuery()->getSingleScalarResult();
    endif;

    return $this->render('design/admin/index.html.twig', array(
     'message' =>$message,
     'title' => 'Home',
     'url' => 'home',
     'photos' => $photos ,
     'pagination' => $pagination,
     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
     ));
  }

     /**
     *@Route("/my_profile",name="my_profile")
     */
     public function profileAction(Request $request)
     {

      $message = [];
      $data = $request->get('search');
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.title LIKE :title')
      ->setParameter('title','%'.$data.'%')
      ->getQuery();

      $ser = $query->getResult();
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $ser,$request->query->getInt('page', 1),8);

      if (!$ser) {
       $message['danger'] = '
       Search No results: ' .$data;
     }elseif(!empty($data)){ $message['success'] = '
     Search: ' .$data;}

     $user =  $this->get('security.token_storage')->getToken()->getUser();

     if($user):

      $repo = $this->getDoctrine()->getManager()
    ->getRepository('AppBundle:photo');

    $qb = $repo->createQueryBuilder('a');
    $qb->select('COUNT(a)');
    $qb->where('a.username = :usernameId');
    $qb->setParameter('usernameId', $user);

    $photos = $qb->getQuery()->getSingleScalarResult();
    endif;

    return $this->render('design/admin/profile.html.twig', array(
     'message' =>$message,
     'title' => 'Home',
     'url' => 'home',
     'photos' => $photos ,
     'pagination' => $pagination,
     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
     ));
  }

   /**
     *@Route("/my_photos",name="my_photos")
     */
   public function  my_photosAction(Request $request)
   {

    $user =  $this->get('security.token_storage')->getToken()->getUser();
    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:photo');
    $query = $repository->createQueryBuilder('p')
        ->where('p.username = :id')
        ->setParameter('id',$user)
    ->getQuery();
    $photo = $query->getResult();

    return $this->render('design/admin/my_photos.html.twig', array(
     'photo' => $photo,
     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
     ));
  }

}
