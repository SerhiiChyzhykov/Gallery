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
    public function homeAction(Request $request, $page = 1)
    {

 $message = [];
      $data = $request->get('search');
      $repository = $this->getDoctrine()
      ->getRepository('AppBundle:photo');
      $query = $repository->createQueryBuilder('p')
      ->where('p.title LIKE :title')
      ->setParameter('title','%'.$data.'%')
      ->setMaxResults('8')
      ->getQuery();

      $ser = $query->getResult();

      if (!$ser) {
       $message['danger'] = '
Search No results: ' .$data;
      }elseif(!empty($data)){ $message['success'] = '
Search: ' .$data;}

$repo = $this   ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:photo');

$qb = $repo->createQueryBuilder('a')
        ->select('COUNT(a)')
      ->where('a.title LIKE :title')
      ->setParameter('title','%'.$data.'%');

$count = $qb->getQuery()->getSingleScalarResult();

$limit = 8;
    $maxPages = ceil($count / $limit);
    $thisPage = $page;


return $this->render('design/index.html.twig', array(
  'message' =>$message,
  'maxPages' => $maxPages,
  'thisPage' =>  $thisPage,
  'photo' => $ser,
  'title' => 'Home',
  'url' => 'home',
  'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
  ));
}


}
