<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use AppBundle\Entity\user;

class UserController extends Controller
{
 
    /**
     *@Route("/register" , name = "register")
     *@Template()
     */
    public function registrationAction(Request $request)
    {
 $user = new User();
        $form = $this->createForm(new UserType(), $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('home');
    }

        return $this->render(

            'design/user.html.twig',
            array(
            'title' => 'Registration',
                'pages'=> '$pages',
            'url'=> 'register',
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
