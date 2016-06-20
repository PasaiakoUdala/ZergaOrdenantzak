<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Atala;
use AppBundle\Form\AtalaType;

/**
 * Atala controller.
 *
 * @Route("/admin/atala")
 */
class AtalaController extends Controller
{

    /**
     * Creates a new Atala entity.
     *
     * @Route("/new/{ordenantzaid}", name="admin_atala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $ordenantzaid)
    {
        $em = $this->getDoctrine();

        $atala = new Atala();
        $ordenantza = $em->getRepository( 'AppBundle:Ordenantza' )->find( $ordenantzaid );
        $atala->setOrdenantza( $ordenantza );
        $atala->setUdala( $this->getUser()->getUdala() );
        
        $form = $this->createForm('AppBundle\Form\AtalaType', $atala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atala);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        } else {
            dump( "Hodor" );
        }

        return $this->render('atala/new.html.twig', array(
            'atala' => $atala,
            'ordenantzaid' => $ordenantzaid,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a Atala entity.
     *
     * @Route("/{id}", name="admin_atala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Atala $atala)
    {
        $form = $this->createDeleteForm($atala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($atala);
            $em->flush();
        }

        return $this->redirectToRoute('admin_atala_index');
    }

    /**
     * Creates a form to delete a Atala entity.
     *
     * @param Atala $atala The Atala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Atala $atala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_atala_delete', array('id' => $atala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
