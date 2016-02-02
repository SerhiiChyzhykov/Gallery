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
     *@Route("/")
     *@Route("/home",name="home")
     */
    public function indexAction(Request $request)
    {

$repository = $this->getDoctrine()
->getRepository('AppBundle:photo');
$query = $repository->createQueryBuilder('p')
->where('p.title LIKE :title')
->orderBy('p.id','ASC')
->setParameter('title','%'.$request->query->get('search').'%')
->getQuery();

$ser = $query->getResult();


if (!$ser) {
  throw $this->createNotFoundException(
    'Photo no found for title '.$search
    );
}



return $this->render('design/index.html.twig', array(
  'photo' => $ser,
  'title' => 'Home',
  'url' => 'home',
  'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
  ));
}

}
