<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class HomeController extends Controller
{
    /**
     *@Route("/",name="home")
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

     return $this->render('design/index.html.twig', array(
       'message' =>$message,
       'title' => 'Home',
       'url' => 'home',
       'pagination' => $pagination,
       'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
       ));
   }
 }
