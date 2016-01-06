<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login1", name="login_route")
     */
    public function loginAction(Request $request)
    {

    	$authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render(
        'design/login.html.twig',
        array(
            // last username entered by the user

            'title' => 'Login1',
            'url' => 'login',

            'error'         => $error,
        )
    );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {


        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}