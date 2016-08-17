<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\UserType;
use AppBundle\Entity\user;

class UserController extends Controller
{

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        $message = [];

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           $db_username = $this->getDoctrine()->getManager()
           ->createQuery(
              'SELECT p
              FROM AppBundle:user p
              WHERE p.username = :username'
              )->setParameter('username', $user->username)->getResult();

           if($db_username){

               $message['danger'] = 'This username is already taken';

           }else{

            $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
            
        }
    }

    return $this->render(
        'register.html.twig',
        array(
            'message' => $message,
            'title' => 'Registration',
            'form' => $form->createView())
        );
}

        /**
     * @Route("/login_check", name="login_check")
      * @Template()
     */
        public function checkAction(){}



    /**
     *@Route("/login", name="login")
      * @Template()
     */
    public function loginAction(Request $request)
    {

     return [];
 }
        /**
         * @Template()
     * @Route("/logout", name="logout")
     */
        public function logoutAction(){}
    }
