<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Azpiatala;
use AppBundle\Form\AzpiatalaType;

/**
 * Azpiatala controller.
 *
 * @Route("/admin/azpiatala")
 */
class AzpiatalaController extends Controller
{

    /**
     * Creates a new Azpiatala entity.
     *
     * @Route("/new/{atalaid}", options = { "expose" = true }, name="admin_azpiatala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $atalaid)
    {
        $em = $this->getDoctrine();

        $atala = $em->getRepository( 'AppBundle:Atala' )->find( $atalaid );
        $azpiatala = new Azpiatala();
        $azpiatala->setAtala( $atala );
        $azpiatala->setUdala( $this->getUser()->getUdala() );
        
        $form = $this->createForm('AppBundle\Form\AzpiatalaType', $azpiatala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpiatala);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('azpiatala/new.html.twig', array(
            'azpiatala' => $azpiatala,
            'atalaid' => $atalaid,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_azpiatala_ezabatu")
     * @Method("GET")
     */
    public function ezabatuAction(Azpiatala $azpiatala)
    {

        $deleteForm = $this->createDeleteForm($azpiatala);

        return $this->render('azpiatala/_azpiataladeleteform.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'id' => $azpiatala->getId()
        ));
    }

    /**
     * Deletes a Azpiatala entity.
     *
     * @Route("/{id}", name="admin_azpiatala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpiatala $azpiatala)
    {
        $form = $this->createDeleteForm($azpiatala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($azpiatala);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Azpiatala entity.
     *
     * @param Azpiatala $azpiatala The Azpiatala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpiatala $azpiatala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_azpiatala_delete', array('id' => $azpiatala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
