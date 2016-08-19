<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\user;

class AdminController extends Controller
{

  public function user(){
    $user =  $this->get('security.token_storage')->getToken()->getUser();
    return $user;
  }

  public function indexAction(Request $request)
  {

    $title =  $request->get('title');
    $articles = 'TEST';

    $categories = $this->getDoctrine()
    ->getRepository('AppBundle:categories')
    ->createQueryBuilder('p')
    ->getQuery()
    ->getResult();

    $categories_count = $this->getDoctrine()
    ->getRepository('AppBundle:photo')
    ->createQueryBuilder('a')
    ->select('COUNT(a)')
    ->groupBy('a.categories')
    ->getQuery()
    ->getResult();


    return $this->render('admin/menu.html.twig', array(
      'title'             => $title,
      'categories'        => $categories,
      'categories_count'  => $categories_count,
      ));
  }

  /*********************************************************************************************************/
     /**
     * @Route("/admin",name="admin")
     */
     /*********************************************************************************************************/     
     public function homeAction(Request $request)
     {

      $photos = $this->getDoctrine()
      ->getRepository('AppBundle:photo')
      ->createQueryBuilder('p')
      ->orderBy('p.id', 'DESC')
      ->setMaxResults(4)
      ->getQuery()
      ->getResult();

      $comments = $this->getDoctrine()
      ->getRepository('AppBundle:post')
      ->createQueryBuilder('p')
      ->orderBy('p.id', 'DESC')
      ->setMaxResults(5)
      ->getQuery()
      ->getResult();

      $date = date('Y-m-d');

      if($delete = $request->get('delete')){
        $em = $this->getDoctrine()->getManager();
        $delete = $em->getRepository('AppBundle:post')->findOneById($delete);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('admin');
      }

      $user = $this->user();

      if($user->role >= 2):
        return $this->render('admin/index.html.twig', array(
         'title'     =>  'Dashboard',
         'comments'  =>  $comments,
         'photos'    =>  $photos ,
         'date'      =>  $date,
         'base_dir'  =>  realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }
    /*********************************************************************************************************/   
     /**
     *@Route("/admin/profile",name="admin_profile")
     */
     /*********************************************************************************************************/   
     public function profileAction(Request $request)
     {

       $message=[];
       $user = $this->user();

       $username   = $request->get('username');
       $last_name  = $request->get('last_name');
       $first_name = $request->get('first_name');
       $twitter = $request->get('twitter');
       $password = $request->get('password');
       $git = $request->get('git');
       $google = $request->get('google');
       $avatar = $request->get('image');
       $role = $request->get('role');

       function is_valid_type($file)
       {

        $valid_types = array("image/jpg","image/jpeg", "image/bmp", "image/gif", "image/png");

        if (in_array($file['type'], $valid_types))
          return 1;
        return 0;
      }
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery(
        'SELECT p
        FROM AppBundle:user p
        WHERE p.id = :id'
        )->setParameter('id', $user->id);

      $db_username = $query->getResult();

      if (isset($_FILES['image'])) {
        if (!empty($_FILES['image'])) {
          if (is_valid_type($_FILES['image'])){
            if (!file_exists($_FILES['image']['name'])){
              $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
              $filename = DFileHelper::getRandomFileName($extension);
              $target =  'img/avatar/' . $filename . '.' . $extension;
              if (move_uploaded_file($_FILES['image']['tmp_name'],$target)){
               if(isset($last_name) && isset($first_name) && isset($twitter) && isset($password) && isset($git) && isset($google)){
                if(!empty($last_name) ){
                  if(!empty($first_name)){
                    if(!empty($twitter)){
                      if(!empty($password)){
                        if(!empty($git)){
                          if(!empty($google)){

                            $em = $this->getDoctrine()->getManager();
                            $user = $em->getRepository('AppBundle:user')->find($user->id);
                            $user->setUsername($user->username);
                            $user->setlast_name($last_name);
                            $user->settwitter($twitter);
                            $user->setgoogle($google);
                            $user->setgit($git);
                            $user->setrole($user->role);
                            $passwords = $this->get('security.password_encoder')
                            ->encodePassword($user,$password);
                            $user->setPassword($passwords);
                            $user->setfirst_name($first_name);
                            $user->setavatar('/img/avatar/'.$filename. '.' . $extension);
                            $em->persist($user);
                            $em->flush();

                            $message['success'] = "User updated";
                          }else{$message['danger'] = "google missing";}
                        }else{$message['danger'] = "git missing";}
                      }else{$message['danger'] = "password missing";}
                    }else{$message['danger'] = "twitter missing";}
                  }else{$message['danger'] = "first_name missing";}
                }else{$message['danger'] = "last_name missing";}
              }else{$message['danger'] = "Somsing missing";}
            }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
          }else{$message['danger'] = "File with this name already exists";}
        }else{$message['danger'] = "You can upload files : JPEG, GIF, BMP, PNG";}
      }
    }

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

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $photo,$request->query->getInt('page', 1),8);

    if($user->role >= 2):
      return $this->render('admin/admin.profile.html.twig', array(
       'user'     => $user_profile,
       'photo'    => $photo,
       'photos'   => $photos,
       'title'    => $user,
       'message'  =>  $message,
       'pagination' => $pagination,
       'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
       ));
    else:
      return $this->redirectToRoute('home');
    endif;
  }
  /*********************************************************************************************************/   
    /**
     *@Route("/admin/users",name="admin_users")
     */
    /*********************************************************************************************************/   
    public function  usersAction(Request $request)
    {
      $user = $this->user();
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:user');
      $query = $repository->createQueryBuilder('p')->getQuery();
      $users = $query->getResult();

      if($user->role >= 2):
        return $this->render('admin/admin.users.html.twig', array(
         'users' => $users,
         'title' => 'Users',
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /*********************************************************************************************************/   
    /**
     *@Route("/admin/user/{id}",name="admin_user")
    */

    /*********************************************************************************************************/   

    public function  userAction(Request $request,$id)
    {
      $user = $this->user();

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


      if($user->role >= 2):
        return $this->render('admin/admin.user.html.twig', array(
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

    /*********************************************************************************************************/   

    /**
     *@Route("/admin/photos",name="admin_photos")
     */
    
    /*********************************************************************************************************/   

    public function  photosAction(Request $request)
    {
      $user = $this->user();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.username = :id')
      ->setParameter('id',$user)
      ->getQuery();
      $photo = $query->getResult();

      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $photo,$request->query->getInt('page', 1),8);

      if($delete = $request->get('delete')):
        $em = $this->getDoctrine()->getManager();
      $delete = $em->getRepository('AppBundle:photo')->findOneById($delete);
      $em->remove($delete);
      $em->flush();
      return $this->redirectToRoute('admin_photos');
      endif;
      
      if($user->role >= 2):
        return $this->render('admin/admin.photos.html.twig', array(
         'pagination' => $pagination,
         'user' => $user,
         'title' => 'Photos',
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /*********************************************************************************************************/   
    /**
     *@Route("/admin/new_user",name="admin_new_user")
     */
    
    /*********************************************************************************************************/   

    public function new_userAction(Request $request)
    {
     $message=[];
     $user = $this->user();

     $username   = $request->get('username');
     $last_name  = $request->get('last_name');
     $first_name = $request->get('first_name');
     $twitter = $request->get('twitter');
     $password = $request->get('password');
     $git = $request->get('git');
     $google = $request->get('google');
     $avatar = $request->get('image');
     $role = $request->get('role');

     function is_valid_type($file)
     {

      $valid_types = array("image/jpg","image/jpeg", "image/bmp", "image/gif", "image/png");

      if (in_array($file['type'], $valid_types))
        return 1;
      return 0;
    }

    if (isset($_FILES['image'])) {
      if (!empty($_FILES['image'])) {
        if (is_valid_type($_FILES['image'])){
          if (!file_exists($_FILES['image']['name'])){
            $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
            $filename = DFileHelper::getRandomFileName($extension);
            $target =  'img/avatar/' . $filename . '.' . $extension;
            if (move_uploaded_file($_FILES['image']['tmp_name'],$target)){
             if(isset($username) && isset($last_name) && isset($first_name) && isset($twitter) && isset($password) && isset($git) && isset($google)){
              if(!empty($username) && !empty($last_name) && !empty($first_name) && !empty($twitter) && !empty($password) && !empty($git) && !empty($google)){

                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery(
                  'SELECT p
                  FROM AppBundle:user p
                  WHERE p.username = :username'
                  )->setParameter('username', $username);

                $db_username = $query->getResult();

                if(!$db_username){

                  $user = new User();
                  $em = $this->getDoctrine()->getManager();
                  $user->setUsername($username);
                  $user->setlast_name($last_name);
                  $user->settwitter($twitter);
                  $user->setgoogle($google);
                  $user->setgit($git);
                  $user->setrole($role);
                  $passwords = $this->get('security.password_encoder')
                  ->encodePassword($user,$password);
                  $user->setPassword($passwords);
                  $user->setfirst_name($first_name);
                  $user->setavatar('/img/avatar/'.$filename. '.' . $extension);
                  $em->persist($user);
                  $em->flush();

                  $message['success'] = "User added";
                  
                }else{$message['danger'] = "This username name already exist";}
              }else{$message['danger'] = "Somsing missing";}
            }else{$message['danger'] = "Somsing missing";}
          }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
        }else{$message['danger'] = "File with this name already exists";}
      }else{$message['danger'] = "You can upload files : JPEG, GIF, BMP, PNG";}
    }
  }

  if($user->role >= 2){
    return $this->render('admin/admin.new_user.html.twig', array(
     'user' => $user,
     'title' => 'New User',
     'message' => $message,
     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
     ));
  }
  else{
    return $this->redirectToRoute('home');
  }
  
}

/*********************************************************************************************************/   
    /**
     *@Route("/admin/edit_user/{id}",name="admin_edit_user")
     */
    
    /*********************************************************************************************************/   

    public function edit_userAction(Request $request,$id)
    {
     $message=[];
     $user = $this->user();

     $username   = $request->get('username');
     $last_name  = $request->get('last_name');
     $first_name = $request->get('first_name');
     $twitter = $request->get('twitter');
     $password = $request->get('password');
     $git = $request->get('git');
     $google = $request->get('google');
     $avatar = $request->get('image');
     $role = $request->get('role');

     function is_valid_type($file)
     {

      $valid_types = array("image/jpg","image/jpeg", "image/bmp", "image/gif", "image/png");

      if (in_array($file['type'], $valid_types))
        return 1;
      return 0;
    }
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery(
      'SELECT p
      FROM AppBundle:user p
      WHERE p.id = :id'
      )->setParameter('id', $id);

    $db_username = $query->getResult();

    if (isset($_FILES['image'])) {
      if (!empty($_FILES['image'])) {
        if (is_valid_type($_FILES['image'])){
          if (!file_exists($_FILES['image']['name'])){
            $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
            $filename = DFileHelper::getRandomFileName($extension);
            $target =  'img/avatar/' . $filename . '.' . $extension;
            if (move_uploaded_file($_FILES['image']['tmp_name'],$target)){
             if(isset($username) && isset($last_name) && isset($first_name) && isset($twitter) && isset($password) && isset($git) && isset($google)){
              if(!empty($username) && !empty($last_name) && !empty($first_name) && !empty($twitter) && !empty($password) && !empty($git) && !empty($google)){

                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('AppBundle:user')->find($id);
                $user->setUsername($username);
                $user->setlast_name($last_name);
                $user->settwitter($twitter);
                $user->setgoogle($google);
                $user->setgit($git);
                $user->setrole($role);
                $passwords = $this->get('security.password_encoder')
                ->encodePassword($user,$password);
                $user->setPassword($passwords);
                $user->setfirst_name($first_name);
                $user->setavatar('/img/avatar/'.$filename. '.' . $extension);
                $em->persist($user);
                $em->flush();

                $message['success'] = "User updated";

              }else{$message['danger'] = "Somsing missing";}
            }else{$message['danger'] = "Somsing missing";}
          }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
        }else{$message['danger'] = "File with this name already exists";}
      }else{$message['danger'] = "You can upload files : JPEG, GIF, BMP, PNG";}
    }
  }

  if($user->role >= 2):
    return $this->render('admin/admin.edit_user.html.twig', array(
     'user' => $user,
     'title' => 'Edit User',
     'db_username' => $db_username,
     'message' => $message,
     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
     ));
  else:
    return $this->redirectToRoute('home');
  endif;
}


/*********************************************************************************************************/   

    /**
     *@Route("/admin/comments",name="admin_comments")
     */
    
    /*********************************************************************************************************/   

    public function  commentsAction(Request $request)
    {
      $message = [];

      $user = $this->user();
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.username = :id')
      ->setParameter('id',$user)
      ->getQuery();
      $photo = $query->getResult();

      $comments = $this->getDoctrine()
      ->getRepository('AppBundle:post')
      ->createQueryBuilder('p')
      ->getQuery()->getResult();

      if($delete = $request->get('delete')){

        $em = $this->getDoctrine()->getManager();
        $delete = $em->getRepository('AppBundle:photo')->findOneById($delete);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('admin_photos');
      }
      
      if($user->role >= 2):
        return $this->render('admin/admin.comments.html.twig', array(
         'photo' => $photo,
         'user' => $user,
         'message' => $message,
         'title' => 'Photos',
         'comments' => $comments,
         'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
         ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    /*********************************************************************************************************/
     /**
     * @Route("/admin/category/{id}",name="category/{id}")
     */
     /*********************************************************************************************************/     
     public function categoryAction(Request $request,$id)
     {

      $photo = $this->getDoctrine()
      ->getRepository('AppBundle:photo')
      ->createQueryBuilder('p')
      ->where('p.categories = :id')
      ->setParameter('id',$id)
      ->getQuery()
      ->getResult();

      $category = $this->getDoctrine()
      ->getRepository('AppBundle:categories')
      ->createQueryBuilder('p')
      ->where('p.id = :id')
      ->setParameter('id',$id)
      ->getQuery()
      ->getResult();

      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $photo,$request->query->getInt('page', 1),8);

      if($delete = $request->get('delete')){
        $em = $this->getDoctrine()->getManager();
        $delete = $em->getRepository('AppBundle:photo')->findOneById($delete);
        $em->remove($delete);
        $em->flush();

        return $this->redirect('/admin/category/'.$id);
      }

      $user = $this->user();

      if($user->role >= 2):
        return $this->render('admin/admin.category.html.twig', array(
          'pagination'    => $pagination,
          'category'     => $category,
          'base_dir'      =>  realpath($this->container->getParameter('kernel.root_dir').'/..'),
          ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }


    /*********************************************************************************************************/
     /**
     * @Route("/admin/categories",name="categories")
     */
     /*********************************************************************************************************/    


     public function categoriesAction(Request $request)
     {

      $user = $this->user();

      if($user->role >= 2):
        return $this->render('admin/admin.categories.html.twig', array(
          'base_dir'      => realpath($this->container->getParameter('kernel.root_dir').'/..'),
          ));
      else:
        return $this->redirectToRoute('home');
      endif;
    }

    public function categorieslistAction(Request $request)
    {

     $count = $this->getDoctrine()->getManager()
     ->getRepository('AppBundle:categories')
     ->createQueryBuilder('a')
     ->select('COUNT(a)')
     ->getQuery()
     ->getSingleScalarResult();

     $id = rand(1,$count);

     $photo = $this->getDoctrine()
     ->getRepository('AppBundle:photo')
     ->createQueryBuilder('p')
     ->orderBy('p.categories')
     ->where('p.categories = :id')
     ->setMaxResults(1)
     ->setParameter('id',$id )
     ->getQuery()
     ->getResult();

     if($delete = $request->get('delete')){

      $this->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:categories')
      ->findOneById($delete)
      ->remove($delete)
      ->flush();

      $this->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:photo')
      ->createQueryBuilder("p")
      ->delete()
      ->where('p.сategories  = :id')->setParameter("id", $delete)
      ->getQuery()
      ->execute();

      return $this->redirect('/admin/categories');
    }

    $user = $this->user();

    if($user->role >= 2):
      return $this->render('admin/admin.categories.list.html.twig', array(
        'photo'    => $photo,
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    else:
      return $this->redirectToRoute('home');
    endif;
  }

}