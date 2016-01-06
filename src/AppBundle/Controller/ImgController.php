<?php

namespace AppBundle\Controller;
use AppBundle\Entity\user;
use AppBundle\Entity\post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ImgController extends Controller
{
     /**
     *@Route("/categories/{id}")
     */
     public function Categories_list(Request $request,$id)
     {
      $s = $request->query->get('search');
      if (isset($s)) {


       $repository = $this->getDoctrine()
       ->getRepository('AppBundle:photo');
       $query = $repository->createQueryBuilder('p')
       ->where('p.title LIKE :title')
       ->setParameter('title','%'.$s.'%')
       ->getQuery();

       $ser = $query->getResult();

       if ($s) {
        return $this->redirect('/home?search='.$s);
      }
      elseif(!$s){
       return $this->redirect('/home?search='.$s);   
     }
   }


   $repository = $this->getDoctrine()
   ->getRepository('AppBundle:photo');
   $query = $repository->createQueryBuilder('p')
   ->where('p.categories = :categories')
   ->setMaxResults(4)
   ->setParameter('categories',$id)
   ->getQuery();

   $ser = $query->getResult();


        // replace this example code with whatever you need
   return $this->render('design/category_list_img.html.twig', array(
    'title' => 'Categories',
    'photo'=>$ser,
    'url' => 'categories',
    'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
    ));
 }

 
      /**
     *@Route("/categories")
     */
      public function Categoryies(Request $request)
      {
        $s = $request->query->get('search');
        if (isset($s)) {


         $repository = $this->getDoctrine()
         ->getRepository('AppBundle:photo');
         $query = $repository->createQueryBuilder('p')
         ->where('p.title LIKE :title')
         ->setParameter('title','%'.$s.'%')
         ->getQuery();

         $ser = $query->getResult();

         if ($s) {
          return $this->redirect('home?search='.$s);
        }
        elseif(!$s){
         return $this->redirect('home?search='.$s);   
       }
     }
     $category = rand(1,8) ;

     $repository = $this->getDoctrine()
     ->getRepository('AppBundle:photo');
     $query = $repository->createQueryBuilder('p')
     ->where('p.categories = :categories')
     ->setMaxResults(4)
     ->setParameter('categories',$category)
     ->getQuery();

     $ser = $query->getResult();


        // replace this example code with whatever you need
     return $this->render('design/category.html.twig', array(
      'title' => 'Categories',
      'photo'=>$ser,
      'url' => 'categories',
      'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
      ));
   }



   public function CategoryAction(Request $request)
   {
     $s = $request->query->get('search');
     if (isset($s)) {


       $repository = $this->getDoctrine()
       ->getRepository('AppBundle:photo');
       $query = $repository->createQueryBuilder('p')
       ->where('p.title LIKE :title')
       ->setParameter('title','%'.$s.'%')
       ->getQuery();

       $ser = $query->getResult();

       if ($s) {
        return $this->redirect('home?search='.$s);
      }
      elseif(!$s){
       return $this->redirect('home?search='.$s);   
     }
   }
   $category = rand(1,8) ;

   $repository = $this->getDoctrine()
   ->getRepository('AppBundle:photo');
   $query = $repository->createQueryBuilder('p')
   ->where('p.categories = :categories')
   ->setMaxResults(4)
   ->setParameter('categories',$category)
   ->getQuery();

   $ser = $query->getResult();


   return $this->render('design/category_list.html.twig', array(
    'title' => 'Categories',
    'photo'=>$ser,
    'url' => 'categories',
    'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
    ));
 }
       /**
     *@Route("/gallery")
     */
       public function Gallery(Request $request)
       {
        $id_user =$this->get('security.token_storage')->getToken()->getUser()->getId();
        $s = $request->query->get('search');
        if (isset($s)) {


         $repository = $this->getDoctrine()
         ->getRepository('AppBundle:photo');
         $query = $repository->createQueryBuilder('p')
         ->where('p.title LIKE :title')
         ->setParameter('title','%'.$s.'%')
         ->getQuery();

         $ser = $query->getResult();

         if ($s) {
          return $this->redirect('home?search='.$s);
        }
        elseif(!$s){
         return $this->redirect('home?search='.$s);   
       }
     }
     $repository = $this->getDoctrine()
     ->getRepository('AppBundle:photo');
     $query = $repository->createQueryBuilder('p')
     ->where('p.username = :id')
     ->setParameter('id',$id_user)
     ->getQuery();
     $photo = $query->getResult();

     return $this->render('design/img_gallery.html.twig', array(
      'title' => 'Gallery',
      'photo' => $photo,
      'url' => 'gallery',
      'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
      ));
   }
     /**
     *@Route("/add")
     *@Route("/Add")
     */
     public function Add(Request $request)
     {
      $s = $request->query->get('search');
      if (isset($s)) {


       $repository = $this->getDoctrine()
       ->getRepository('AppBundle:photo');
       $query = $repository->createQueryBuilder('p')
       ->where('p.title LIKE :title')
       ->setParameter('title','%'.$s.'%')
       ->getQuery();

       $ser = $query->getResult();

       if ($s) {
        return $this->redirect('home?search='.$s);
      }
      elseif(!$s){
       return $this->redirect('home?search='.$s);   
     }
   }
   return $this->render('design/img_add.html.twig', array(
    'title' => 'Add',
    'url' => 'add',
    'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
    ));
 }
    /**
     *@Route("/photo/{id}" , name="photos")
     */

    public function Photo(Request $request,$id)
    {

      $users =  $this->get('security.token_storage')->getToken()->getUser();
      $send=$request->get('post');
      if(isset($_POST['post'])) {



       $post = new Post();
       $em = $this->getDoctrine()->getManager();
       $post->setUsernameId($users);
       $post->setImageId($id);
       $post->setPost($send);
       $em->persist($post);
       $em->flush();


     }


     $s = $request->query->get('search');
     if (isset($s)) {


       $repository = $this->getDoctrine()
       ->getRepository('AppBundle:photo');
       $query = $repository->createQueryBuilder('p')
       ->where('p.title LIKE :title')
       ->setParameter('title','%'.$s.'%')
       ->getQuery();

       $ser = $query->getResult();

       if ($s) {
        return $this->redirect('/home?search='.$s);
      }
      elseif(!$s){
       return $this->redirect('/home?search='.$s);   
     }
   }

   $repository = $this->getDoctrine()
   ->getRepository('AppBundle:post');
   $query = $repository->createQueryBuilder('p')
   ->where('p.imageId LIKE :title')
   ->setMaxResults(5)
   ->orderBy('p.id', 'DESC')
   ->setParameter('title',$id)
   ->getQuery();

   $posts = $query->getResult();

   $repository = $this->getDoctrine()
   ->getRepository('AppBundle:photo');
   $photo = $repository->findById($id);

   return $this->render('design/img.html.twig', array(
            #'messages'=>$messages,
    'post' => $posts,
    'photo' => $photo,
    'title' => 'Photo',
    'url' => 'photo/'.$id,
    'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
    ));
 }
    /**
     *@Route("/" , name="search")
     *
     *
     */
    public function searchAction(Request $request)
    {
      $data = $request->get->all();
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.title LIKE :title')
      ->setParameter('title','%'.$data['search'].'%')
      ->getQuery();

      $ser = $query->getResult();



      if (!$ser) {
        throw $this->createNotFoundException(
          'Photo no found for title '.$search
          );
      }
      return $this->render('design/search.html.twig', array(
        'photo' => $ser,
        'title' => 'Search',
        'url' => $search,
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
  }
