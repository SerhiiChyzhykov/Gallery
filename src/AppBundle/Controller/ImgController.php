<?php

namespace AppBundle\Controller;
use AppBundle\Entity\user;
use AppBundle\Entity\post;
use AppBundle\Entity\photo;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ImgController extends Controller
{
  public function user(){
    $user =  $this->get('security.token_storage')->getToken()->getUser();

    return $user;
  }
     /**
     *@Route("/categories/{id}")
     */
     public function Categories_list(Request $request,$id)
     {

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.categories = :categories')
      ->setMaxResults(4)
      ->setParameter('categories',$id)
      ->getQuery();
      $ser = $query->getResult();

      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:categories');
      $id_cat =  $repository->createQueryBuilder('p')
      ->where('p.id = :categories')
      ->setParameter('categories',$id)
      ->getQuery();
      $cat =  $id_cat->getResult();

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

      return $this->render('design/category_list_img.html.twig', array(
        'title' => 'Categories',
        'photo'=>$ser,
        'id' => $cat ,
        'photos' => $photos,
        'url' => 'categories',
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

      /**
     *@Route("/categories")
     */
      public function Categoryies(Request $request)
      {
        $repo = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:categories');

        $qb = $repo->createQueryBuilder('a');
        $qb->select('COUNT(a)');

        $count = $qb->getQuery()->getSingleScalarResult();

        $category = rand(1,$count) ;

        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:photo');
        $query = $repository->createQueryBuilder('p')
        ->where('p.categories = :categories')
        ->setMaxResults(4)
        ->setParameter('categories',$category)
        ->getQuery();

        $ser = $query->getResult();

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

        return $this->render('design/category.html.twig', array(
          'title' => 'Categories',
          'photo'=>$ser,
          'url' => 'categories',
          'photos' => $photos,
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
          ));
      }

      public function CategoryAction(Request $request)
      {

        $repo = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:categories');

        $qb = $repo->createQueryBuilder('a');
        $qb->select('COUNT(a)');

        $count = $qb->getQuery()->getSingleScalarResult();

        $category = rand(1,$count) ;

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

        $id_user = $request->get('user');
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:photo');
        $query = $repository->createQueryBuilder('p')
        ->where('p.username = :id')
        ->setParameter('id',$id_user)
        ->getQuery();
        $photo = $query->getResult();

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

        return $this->render('design/img_gallery.html.twig', array(
          'title' => 'Gallery',
          'photo' => $photo,
          'photos' => $photos,
          'url' => 'gallery',
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
          ));
      }

     /**
     *@Route("/add")
     */
     public function Add(Request $request)
     {

      $message = [];
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:categories');
      $query = $repository->createQueryBuilder('p')
      ->getQuery();

      $category = $query->getResult();

      $user =  $this->get('security.token_storage')->getToken()->getUser();
      $title=$request->get('title');
      $description=$request->get('description');
      $categories=$request->get('categories');
      $image =$request->get('image');

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
                $photo = new Photo();
                $em = $this->getDoctrine()->getManager();
                $photo->setUsername($user);
                $photo->setDescription($description);
                $photo->setTitle($title);
                $photo->setCategories($em->getRepository("AppBundle:categories")->find($categories));
                $photo->setImage('img/'.$filename. '.' . $extension);
                $em->persist($photo);
                $em->flush();
                $message['success'] = "Photo added";
              }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
            }else{$message['danger'] = "File with this name already exists";}
          }else{$message['danger'] = "You can upload files : JPEG, GIF, BMP, PNG";}
        }
      }
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

      return $this->render('design/img_add.html.twig', array(
        'title' => 'Add photo',
        'url' => 'add',
        'message' => $message,
        'photos' => $photos,
        'var' => $image,
        'category' => $category,
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     *@Route("/photo/{id}" , name="photos/$id")
     */

    public function Photo(Request $request,$id)
    {
      $message = [] ;
      $users =  $this->get('security.token_storage')->getToken()->getUser();

      $send=$request->get('post');

      if(isset($send)) {
       if ($users != "anon." ) {
         $post = new Post();
         $em = $this->getDoctrine()->getManager();
         $post->setUsernameId($users);
         $post->setImageId($id);
         $post->setPost($send);
         $em->persist($post);
         $sd = $em->flush(); 
       }else{$message['danger'] = 'You are not registered!';}
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

     $repository = $this->getDoctrine()
     ->getRepository('AppBundle:categories');
     $query = $repository->createQueryBuilder('p')
     ->getQuery();

     $category = $query->getResult();

     if($delete = $request->get('delete')):
      $em = $this->getDoctrine()->getManager();
    $delete = $em->getRepository('AppBundle:photo')->findOneById($delete);
    $em->remove($delete);
    $em->flush();
    return $this->redirectToRoute('home');
    endif;
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
    if($edit = $request->get('edit')):

      $repository = $this->getDoctrine()
    ->getRepository('AppBundle:categories');
    $query = $repository->createQueryBuilder('p')
    ->getQuery();
    $category = $query->getResult();
    $user =  $this->get('security.token_storage')->getToken()->getUser();
    $title=$request->get('title');
    $description=$request->get('description');
    $categories=$request->get('categories');
    $image =$request->get('image');

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
              $photo = new Photo();
              $em = $this->getDoctrine()->getManager();
              $photo = $em->getRepository('AppBundle:photo')->findOneById($id);
              $photo->setUsername($user);
              $photo->setDescription($description);
              $photo->setTitle($title);
              $photo->setCategories($em->getRepository("AppBundle:categories")->find($categories));
              $photo->setImage('img/'.$filename. '.' . $extension);
              $em->persist($photo);
              $em->flush();
              $message['success'] = "Photo added";

              return $this->render('design/img.html.twig', array(
                'users'    =>$users,
                'post'     => $posts,
                'photo'    => $photo,
                'message'  => $message,
                'title'    => 'Photo',
                'photos'   => $photos,
                'url'      => 'photo/'.$id,
                'category' => $category,
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                ));
            }else{$message['danger'] = "You can not download the file. Check permissions to the directory ( read / write)";}
          }else{$message['danger'] = "File with this name already exists";}
        }else{
          $photo = new Photo();
          $em = $this->getDoctrine()->getManager();
          $photo = $em->getRepository('AppBundle:photo')->findOneById($id);
          $photo->setUsername($user);
          $photo->setDescription($description);
          $photo->setTitle($title);
          $photo->setCategories($em->getRepository("AppBundle:categories")->find($categories));
          $em->persist($photo);
          $em->flush();
          $message['success'] = "Photo edited!";
          return $this->redirect('/photo/'.$edit);
        }
      }
    }
    endif;

    return $this->render('design/img.html.twig', array(
      'users'    =>$users,
      'post'     => $posts,
      'photo'    => $photo,
      'message'  => $message,
      'title'    => 'Photo',
      'url'      => 'photo/'.$id,
      'category' => $category,
      'photos'   => $photos,
      'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
      ));
  }

}
