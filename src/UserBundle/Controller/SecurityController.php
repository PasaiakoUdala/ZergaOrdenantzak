<?php
    namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
    use Symfony\Component\Security\Core\Security;
    use GuzzleHttp;


    class SecurityController extends Controller
    {

        public function loginAction ( Request $request )
        {
            /***
             * IZFE-rako login da ?
             * Baldin eta parametroa badu bai
             ***/
            $query_str = parse_url( $request->getSession()->get( '_security.main.target_path' ) );
            $miurl = $query_str['host'].'/'.$query_str['path'];
            $query_str = parse_url( $request->getSession()->get( '_security.main.target_path' ), PHP_URL_QUERY );

            $urlOsoa= $request->getSession()->get( '_security.main.target_path' )."\n";            
            
            if (( $query_str != null )&&($this->container->getParameter('izfe_login_path')!='')) 
            {
                parse_str( $query_str, $query_params );
                /* GET kodea*/
                if ( $query_str != null ) 
                {
//                    $valget = $query_params["kodea"];
//                    if ( $valget != "" ) {
//                        if ( $this->izfelogin( $valget, $miurl ) == 1 ) {
//                            return $this->redirectToRoute( 'admin_ordenantza_index' );
//                        }
//                    }
                    $NA=$query_params["DNI"];
                    $udala=$query_params["AYUN"];
                    $hizkuntza=$query_params["IDIOMA"];
                    $fitxategia=$query_params["ficheroAuten"];

                    if ($this->izfelogin ($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)==1)
                    {
                        return $this->redirectToRoute( 'admin_ordenantza_index' );
                    }else
                    {
                        $lastUsername = null;
                        $csrfToken = $this->get( 'security.csrf.token_manager' )->getToken( 'authenticate' )->getValue();
                        $error = null;
                        return $this->renderLogin(
                            array (
                                'last_username' => $lastUsername,
                                'error'         => $error,
                                'csrf_token'    => $csrfToken,
                            )
                        );
//                        return $this->render( 'FOSUserBundle:Security:login.html.twig', $data );
                    }
                }
            }
            else
            {
                /** FOSUSERBUNDLE LoginAction */
                /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
                $session = $request->getSession();

                if ( class_exists( '\Symfony\Component\Security\Core\Security' ) ) {
                    $authErrorKey = Security::AUTHENTICATION_ERROR;
                    $lastUsernameKey = Security::LAST_USERNAME;
                } else {
                    // BC for SF < 2.6
                    $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
                    $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
                }

                // get the error if any (works with forward and redirect -- see below)
                if ( $request->attributes->has( $authErrorKey ) ) {
                    $error = $request->attributes->get( $authErrorKey );
                } elseif ( null !== $session && $session->has( $authErrorKey ) ) {
                    $error = $session->get( $authErrorKey );
                    $session->remove( $authErrorKey );
                } else {
                    $error = null;
                }

                if ( !$error instanceof AuthenticationException ) {
                    $error = null; // The value does not come from the security component.
                }

                // last username entered by the user
                $lastUsername = (null === $session) ? '' : $session->get( $lastUsernameKey );

                if ( $this->has( 'security.csrf.token_manager' ) ) {
                    $csrfToken = $this->get( 'security.csrf.token_manager' )->getToken( 'authenticate' )->getValue();
                } else {
                    // BC for SF < 2.4
                    $csrfToken = $this->has( 'form.csrf_provider' )
                        ? $this->get( 'form.csrf_provider' )->generateCsrfToken( 'authenticate' )
                        : null;
                }

                return $this->renderLogin(
                    array (
                        'last_username' => $lastUsername,
                        'error'         => $error,
                        'csrf_token'    => $csrfToken,
                    )
                );


            }

        }

        protected function renderLogin ( array $data )
        {
            return $this->render( 'FOSUserBundle:Security:login.html.twig', $data );
        }

//        private function izfelogin ( $valget )
//        {
//            /* fitxategiko kodea */
//            $client = new GuzzleHttp\Client();
//            $res = $client->request( 'GET', 'http://obelix/izfe.txt' );
//            if ( $res->getStatusCode() == 200 ) {
//                $valftp = (string)$res->getBody();
//                $valftp = str_replace( PHP_EOL, '', $valftp );
//            }
//
//            /* Konparatu ta bestela errorea */
//            if ( $valftp == $valget ) {
//                $userManager = $this->container->get( 'fos_user.user_manager' );
//                $user = $userManager->findUserByUsername( 'admin' );
//                $token = new UsernamePasswordToken( $user, null, 'main', $user->getRoles() );
//                $this->get( 'security.token_storage' )->setToken( $token );
//                $this->get( 'session' )->set( '_security_main', serialize( $token ) );
//
//                return 1;
//            }
//
//            return 0;
//
//        }
        private function izfelogin($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)
        {
            /* fitxategiko kodea */
//        $fitx = fopen($this->container->getParameter('izfe_login_path').'/'.$fitxategia,"r") or die("Unable to open file!");
            /* fitxategia ez bada existitzen login orrira berbideratu */

        dump($urlOsoa);
            if (file_exists ($this->container->getParameter('izfe_login_path').'/'.$fitxategia))
            {
                $fitx = fopen($this->container->getParameter('izfe_login_path').'/'.$fitxategia,"r");
                $lerro = fgets($fitx);

                /* fitxategiaren edukia eta url-a berdinak diren konparatu*/
                if ($lerro == $urlOsoa)
                {
                    $userManager = $this->container->get('fos_user.user_manager');
                    $user = $userManager->findUserByUsername($NA);

                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));

                    /* login-a egin ondoren fitxategia ezabatu */
                    unlink($this->container->getParameter('izfe_login_path') . '/' . $fitxategia);
                    return 1;
                }
                return 0;
            } return 0;
        }        
        

    }