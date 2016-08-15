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

  public function user(){
    $user =  $this->get('security.token_storage')->getToken()->getUser();

    return $user;
  }

    /**
     *@Route("/admin",name="admin")
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
    if($user != 'anon'):
      return $this->render('design/admin/index.html.twig', array(
       'message' =>$message,
       'title' => 'Dashboard',
       'url' => 'home',
       'photos' => $photos ,
       'pagination' => $pagination,
       'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
       ));
    else:
      return $this->redirectToRoute('home');
    endif;
  }

     /**
     *@Route("/admin/profile",name="admin_profile")
     */
     public function profileAction(Request $request)
     {
      $user =  $this->get('security.token_storage')->getToken()->getUser();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:user');

      $query = $repository->createQueryBuilder('p')
      ->where('p.id = :id')
      ->setMaxResults(1)
      ->setParameter('id',$user )
      ->getQuery();

      $user_profile = $query->getResult();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.username = :id')
      ->setParameter('id',$user )
      ->getQuery();
      $photo = $query->getResult();

      $qb = $repository->createQueryBuilder('a');
      $qb->select('COUNT(a)');
      $qb->where('a.username = :usernameId');
      $qb->setParameter('usernameId', $user );

      $photos = $qb->getQuery()->getSingleScalarResult();


      if($user != 'anon'):
        return $this->render('design/admin/user.html.twig', array(
         'user'     => $user_profile,
         'photo'    => $photo,
         'photos'   => $photos,
         'title' => $user,
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /**
     *@Route("/admin/profile/photo",name="admin_my_photo")
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

      if($user != 'anon'):
        return $this->render('design/admin/my_photos.html.twig', array(
         'photo' => $photo,
         'title' => '$user',
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /**
     *@Route("/admin/users",name="admin_users")
     */
    public function  usersAction(Request $request)
    {
      $user =  $this->get('security.token_storage')->getToken()->getUser();
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:user');
      $query = $repository->createQueryBuilder('p')->getQuery();
      $users = $query->getResult();

      if($user != 'anon'):
        return $this->render('design/admin/users.html.twig', array(
         'users' => $users,
         'title' => 'Users',
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /**
     *@Route("/admin/user/{id}",name="admin_user")
     */
    public function  userAction(Request $request,$id)
    {
      $user =  $this->get('security.token_storage')->getToken()->getUser();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:user');

      $query = $repository->createQueryBuilder('p')
      ->where('p.id = :id')
      ->setMaxResults(1)
      ->setParameter('id',$id)
      ->getQuery();

      $user_profile = $query->getResult();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.username = :id')
      ->setParameter('id',$id)
      ->getQuery();
      $photo = $query->getResult();

      $qb = $repository->createQueryBuilder('a');
      $qb->select('COUNT(a)');
      $qb->where('a.username = :usernameId');
      $qb->setParameter('usernameId', $id);

      $photos = $qb->getQuery()->getSingleScalarResult();


      if($user != 'anon'):
        return $this->render('design/admin/user.html.twig', array(
         'user'     => $user_profile,
         'photo'    => $photo,
         'photos'   => $photos,
         'title' => $user,
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /**
     *@Route("/admin/photos",name="admin_photos")
     */
    public function  photosAction(Request $request)
    {
      $user =  $this->get('security.token_storage')->getToken()->getUser();
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.username = :id')
      ->setParameter('id',$user)
      ->getQuery();
      $photo = $query->getResult();

      if($delete = $request->get('delete')):
        $em = $this->getDoctrine()->getManager();
      $delete = $em->getRepository('AppBundle:photo')->findOneById($delete);
      $em->remove($delete);
      $em->flush();
      return $this->redirectToRoute('admin_photos');
      endif;
      
      if($user != 'anon'):
        return $this->render('design/admin/photos.html.twig', array(
         'photo' => $photo,
         'user' => $user,
         'title' => 'Photos',
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /**
     *@Route("/admin/new_user",name="admin_new_user")
     */
    public function new_userAction(Request $request)
    {

      $user =  $this->get('security.token_storage')->getToken()->getUser();

      $username   = $request->get('username');
      $last_name  = $request->get('last_name');
      $first_name = $request->get('first_name');
      $twitter = $request->get('twitter');
      $password = $request->get('password');
      $git = $request->get('git');
      $google = $request->get('google');
      $avatar = $request->get('avatar');

      function is_valid_type($file)
      {

        $valid_types = array("image/jpg","image/jpeg", "image/bmp", "image/gif", "image/png");

        if (in_array($file['type'], $valid_types))
          return 1;
        return 0;
      }
      if (isset($_FILES['image'])) {
        if (!empty($_FILES['image'])) {
          if (is_valid_type($_FILES['image']))
          {
            if (!file_exists($_FILES['image']['name']))
            {
              $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
              $filename = DFileHelper::getRandomFileName($extension);
              $target =  'img/' . $filename . '.' . $extension;
              if (move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                $user = new User();
                $em = $this->getDoctrine()->getManager();
                $user->setUsername($username);
                $user->setlast_name($last_name);
                $user->settwitter($twitter);
                $user->setgoogle($google);
                $user->setgit($git);
                $user->setpassword($password);
                $user->setfirst_name($first_name);
                $user->setavatar('img/'.$filename. '.' . $extension);
                $em->persist($user);
                $em->flush();
                $message['success'] = "Photo added";
              }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
            }else{$message['danger'] = "File with this name already exists";}
          }else{$message['danger'] = "You can upload files : JPEG, GIF, BMP, PNG";}
        }
      }
      
      if($user != 'anon'):
        return $this->render('design/admin/new_user.html.twig', array(
         'user' => $user,
         'title' => 'Photos',
        'message' => $message,
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

  }


