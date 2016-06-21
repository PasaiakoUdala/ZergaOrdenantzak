<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Atala;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Form\AtalaparrafoaType;

/**
 * Atalaparrafoa controller.
 *
 * @Route("/admin/atalaparrafoa")
 */
class AtalaparrafoaController extends Controller
{

    /**
     * Creates a new Atalaparrafoa entity.
     *
     * @Route("/new/{atalaid}", options = { "expose" = true }, name="admin_atalaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $atalaid)
    {
        $em = $this->getDoctrine();

        $atala = $em->getRepository( 'AppBundle:Atala' )->find( $atalaid );
        $atalaparrafoa = new Atalaparrafoa();

        $atalaparrafoa->setAtala( $atala );
        $atalaparrafoa->setUdala($this->getUser()->getUdala());

        $form = $this->createForm('AppBundle\Form\AtalaparrafoaType', $atalaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atalaparrafoa);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('atalaparrafoa/new.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'atalaid' => $atalaid,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/ezabatu/{id}", name="admin_atalaparrafoa_ezabatu")
     * @Method("GET")
     */
    public function ezabatuAction(Atalaparrafoa $atalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($atalaparrafoa);

        return $this->render('atalaparrafoa/_atalaparrafoadeleteform.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'id' => $atalaparrafoa->getId()
        ));
    }

    /**
     * Deletes a Atalaparrafoa entity.
     *
     * @Route("/{id}", name="admin_atalaparrafoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Atalaparrafoa $atalaparrafoa)
    {
        $form = $this->createDeleteForm($atalaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($atalaparrafoa);
            $em->flush();
        }

        return $this->redirectToRoute('admin_atalaparrafoa_index');
    }

    /**
     * Creates a form to delete a Atalaparrafoa entity.
     *
     * @param Atalaparrafoa $atalaparrafoa The Atalaparrafoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Atalaparrafoa $atalaparrafoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_atalaparrafoa_delete', array('id' => $atalaparrafoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
