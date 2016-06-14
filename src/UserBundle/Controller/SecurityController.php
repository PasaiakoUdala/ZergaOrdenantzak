<?php
    /**
     * User: iibarguren
     * Date: 14/06/16
     * Time: 11:05
     */

    namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
    use Symfony\Component\Security\Core\Security;
    use Symfony\Component\Security\Core\SecurityContextInterface;
    use Symfony\Component\Security\Core\Exception\AuthenticationException;


    class SecurityController extends Controller
    {
        public function loginAction(Request $request)
        {



            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername('admin');
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('admin_ordenantza_index',array(), 301);
        }
    }