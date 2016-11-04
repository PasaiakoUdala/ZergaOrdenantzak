<?php
    namespace UserBundle\Controller;

    use AppBundle\Entity\User;

    use Pagerfanta\Exception\NotValidCurrentPageException;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
    use Symfony\Component\Security\Core\Security;
    use GuzzleHttp;

    use Pagerfanta\Pagerfanta;
    use Pagerfanta\Adapter\ArrayAdapter;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use AppBundle\Form\UserType;


    class SecurityController extends Controller
    {

        public function loginAction ( Request $request )
        {
            /***
             * IZFE-rako login da ?
             * Baldin eta parametroa badu bai
             ***/
//            $query_str = parse_url( $request->getSession()->get( '_security.main.target_path' ), PHP_URL_QUERY );
//            $urlOsoa= $request->getSession()->get( '_security.main.target_path' );
            $query_str = parse_url($request->getUri(),PHP_URL_QUERY );
            $urlOsoa=$request->getUri();



            if (( $query_str != null )&&($this->container->getParameter('izfe_login_path')!='')) 
            {
                parse_str( $query_str, $query_params );
                /* GET kodea*/
                if ( $query_str != null ) 
                {
                    $NA=$query_params["DNI"];
                    $udala=$query_params["AYUN"];
                    $hizkuntza=$query_params["IDIOMA"];
                    $fitxategia=$query_params["ficheroAuten"];

                    if ($this->izfelogin ($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)==1)
                    {
                        return $this->redirectToRoute( 'admin_ordenantza_index', array('_locale' => strtolower($hizkuntza)) );
                    }
                    else
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

        private function izfelogin($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)
        {

            /* fitxategia ez bada existitzen login orrira berbideratu */
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

                    return 1;
                }
                return 0;
            } return 0;
        }


        /**
         * Lists all USERS .
         *
         * @Route("/{_locale}/admin/user", defaults={"page" = 1}, name="users_index")
         * @Route("/{_locale}/admin/user/page{page}", name="user_index_paginated")
         * @Method("GET")
         */
        public function userAction($page) {
            $userManager = $this->get('fos_user.user_manager');
            $users = $userManager->findUsers();


            $adapter = new ArrayAdapter($users);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($users as $user) {
                $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
            }
            try {
                $entities = $pagerfanta
//                    ->setMaxPerPage($this->getUser()->getUdala()->getOrrikatzea())
                    ->setMaxPerPage('25')
                    ->setCurrentPage($page)
                    ->getCurrentPageResults()
                ;
            } catch ( NotValidCurrentPageException $e) {
                throw $this->createNotFoundException("Orria ez da existitzen");
            }

            return $this->render('UserBundle:Default:users.html.twig', array(
//                'users' =>   $users,
                'users' => $entities,
                'pager' => $pagerfanta,
                'deleteforms'=> $deleteForms,
            ));
        }

        /**
         * Creates a new User entity.
         *
         * @Route("/{_locale}/admin/user/new", name="user_new")
         * @Method({"GET", "POST"})
         */
        public function newAction(Request $request)
        {
            $auth_checker = $this->get('security.authorization_checker');
            if(($auth_checker->isGranted('ROLE_ADMIN')) || ($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
            {
                $userManager = $this->container->get('fos_user.user_manager');
                $user = $userManager->createUser();
                $user->setEnabled( 1 );
                $user->setUdala($this->getUser()->getUdala());
                $form = $this->createForm('UserBundle\Form\UsernewwithpasswordType', $user);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $user->setPlainPassword( $user->getPassword());
                    $userManager->updateUser($user, true);
                    return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
                }
                return $this->render('UserBundle:Default:new.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),
                ));
            }
        }



        /**
         * Displays a form to edit an existing User entity.
         *
         * @Route("/{_locale}/admin/user/{id}/edit", name="user_edit")
         * @Method({"GET", "POST"})
         */
        public function editAction(Request $request, User $user)
        {
            $auth_checker = $this->get('security.authorization_checker');
            if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
                ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
            {
                $deleteForm = $this->createDeleteForm($user);
                if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) {
                    $editForm = $this->createForm('UserBundle\Form\SuperuserType', $user);
                } else {
                    $editForm = $this->createForm('UserBundle\Form\UserType', $user);
                }

                $editForm->handleRequest($request);
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $userManager = $this->container->get('fos_user.user_manager');
                    $userManager->updateUser($user, true);

                    return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
                }

                return $this->render('UserBundle:Default:edit.html.twig', array(
                    'user' => $user,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
            }else
            {
                return $this->redirectToRoute('backend_errorea');
            }
        }

        /**
         * Password Edit Action
         *
         * @Route("/user/{id}/passwd", name="user_edit_passwd")
         * @Method({"GET", "POST"})
         */
        public function passwdAction(Request $request, User $user)
        {
            $auth_checker = $this->get('security.authorization_checker');
            if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
                ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
            {
                $editForm = $this->createForm('UserBundle\Form\UserpasswdType', $user);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $userManager = $this->container->get('fos_user.user_manager');
                    $user->setPlainPassword( $user->getPassword());
                    $user->setEnabled( 1 );
                    $userManager->updateUser($user, true);

                    return $this->redirectToRoute('users_index');
                }

                return $this->render('UserBundle:Default:passwd.html.twig', array(
                    'user' => $user,
                    'form' => $editForm->createView()
                ));
            }else
            {
                return $this->redirectToRoute('backend_errorea');
            }
        }



        /**
         * Deletes a User entity.
         *
         * @Route("/{_locale}/admin/user/{id}/del", name="user_delete")
         * @Method("DELETE")
         */
        public function deleteAction(Request $request, User $user)
        {
            //udala egokia den eta admin baimena duen egiaztatu
            $auth_checker = $this->get('security.authorization_checker');
            if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
                ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
            {
                $form = $this->createDeleteForm($user);
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($user);
                    $em->flush();
                }else
                {

                }
                return $this->redirectToRoute('users_index');
            }else
            {
                return $this->redirectToRoute('backend_errorea');
            }
        }

        /**
         * Creates a form to delete a User entity.
         *
         * @param User $user The User entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm(User $user)
        {
            return $this->createFormBuilder()
                ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
                ->setMethod('DELETE')
                ->getForm()
                ;
        }
    }