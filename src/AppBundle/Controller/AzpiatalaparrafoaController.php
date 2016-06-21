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

                return $this->redirect( $request->headers->get( 'referer' ) );
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
         * @Route("/ezabatu/{id}", name="admin_azpiatalaparrafoa_ezabatu")
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

            if ( $form->isSubmitted() && $form->isValid() ) {
                $em = $this->getDoctrine()->getManager();
                $em->remove( $azpiatalaparrafoa );
                $em->flush();
            }

            return $this->redirectToRoute( 'admin_azpiatalaparrafoa_index' );
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
