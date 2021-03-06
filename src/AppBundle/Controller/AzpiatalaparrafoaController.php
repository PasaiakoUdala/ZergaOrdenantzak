<?php

    namespace AppBundle\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use AppBundle\Entity\Azpiatalaparrafoa;
    use AppBundle\Form\AzpiatalaparrafoaType;

    /**
     * Azpiatalaparrafoa controller.
     *
     * @Route("/admin/azpiatalaparrafoa")
     */
    class AzpiatalaparrafoaController extends Controller
    {
        /**
         * @Route("/up/{id}", name="admin_azpiatalaparrafoa_up")
         * @Method("GET")
         */
        public function upAction(Request $request, Azpiatalaparrafoa $op)
        {
            $em = $this->getDoctrine()->getManager();
            $op->setOrdena($op->getOrdena() - 1);
            $em->persist($op);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        /**
         * @Route("/down/{id}", name="admin_azpiatalaparrafoa_down")
         * @Method("GET")
         */
        public function downAction(Request $request, Azpiatalaparrafoa $op)
        {
            $em = $this->getDoctrine()->getManager();
            $op->setOrdena($op->getOrdena() + 1);
            $em->persist($op);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }
        
        /**
         * Creates a new Azpiatalaparrafoa entity.
         *
         * @Route("/new/{azpiatalaid}", options = { "expose" = true }, name="admin_azpiatalaparrafoa_new")
         * @Method({"GET", "POST"})
         */
        public function newAction ( Request $request, $azpiatalaid )
        {
            $em = $this->getDoctrine();

            $azpiatala = $em->getRepository( 'AppBundle:Azpiatala' )->find( $azpiatalaid );
            $azpiatalaparrafoa = new Azpiatalaparrafoa();
            $azpiatalaparrafoa->setAzpiatala( $azpiatala );
            $azpiatalaparrafoa->setUdala( $this->getUser()->getUdala() );

            $form = $this->createForm( 'AppBundle\Form\AzpiatalaparrafoaType', $azpiatalaparrafoa );
            $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
                $em = $this->getDoctrine()->getManager();
                $em->persist( $azpiatalaparrafoa );
                $em->flush();

                return $this->redirect( $request->headers->get( 'referer' ) . '#azpiatalaparrafoa'.$azpiatalaparrafoa->getId());
            }

            return $this->render(
                'azpiatalaparrafoa/new.html.twig',
                array (
                    'azpiatalaparrafoa' => $azpiatalaparrafoa,
                    'azpiatalaid'       => $azpiatalaid,
                    'form'              => $form->createView(),
                )
            );
        }

        /**
         *
         * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_azpiatalaparrafoa_ezabatu")
         * @Method("GET")
         */
        public function ezabatuAction(Azpiatalaparrafoa $azpiatalaparrafoa)
        {
            $deleteForm = $this->createDeleteForm($azpiatalaparrafoa);

            return $this->render('azpiatalaparrafoa/_azpiatalaparrafoadeleteform.html.twig', array(
                'delete_form' => $deleteForm->createView(),
                'id' => $azpiatalaparrafoa->getId()
            ));
        }
        
        /**
         * Deletes a Azpiatalaparrafoa entity.
         *
         * @Route("/{id}", name="admin_azpiatalaparrafoa_delete")
         * @Method("DELETE")
         */
        public function deleteAction ( Request $request, Azpiatalaparrafoa $azpiatalaparrafoa )
        {
            $form = $this->createDeleteForm( $azpiatalaparrafoa );
            $form->handleRequest( $request );

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                /* Begiratu ezabatze marka duen (dev) baldin badu, ezabatu
                bestela marka ezarri */
                if ( $azpiatalaparrafoa->getEzabatu() === 1 ) {
                    $em->remove($azpiatalaparrafoa);
                } else {
                    $azpiatalaparrafoa->setEzabatu( 1 );
                    $em->persist( $azpiatalaparrafoa );
                }

                $em->flush();
            }

            return $this->redirect( $request->headers->get( 'referer' ) );
        }

        /**
         * Creates a form to delete a Azpiatalaparrafoa entity.
         *
         * @param Azpiatalaparrafoa $azpiatalaparrafoa The Azpiatalaparrafoa entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm ( Azpiatalaparrafoa $azpiatalaparrafoa )
        {
            return $this->createFormBuilder()
                ->setAction(
                    $this->generateUrl( 'admin_azpiatalaparrafoa_delete', array ('id' => $azpiatalaparrafoa->getId()) )
                )
                ->setMethod( 'DELETE' )
                ->getForm();
        }
    }
