<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Form\AtalaparrafoaType;
use AppBundle\Entity\Atala;

/**
 * Atalaparrafoa controller.
 *
 * @Route("/admin/atalaparrafoa")
 */
class AtalaparrafoaController extends Controller
{
    /**
     * @Route("/up/{id}", name="admin_atalaparrafoa_up")
     * @Method("GET")
     */
    public function upAction(Request $request, Atalaparrafoa $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() - 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/down/{id}", name="admin_atalaparrafoa_down")
     * @Method("GET")
     */
    public function downAction(Request $request, Atalaparrafoa $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() + 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }


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
     * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_atalaparrafoa_ezabatu")
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

        return $this->redirect($request->headers->get('referer'));
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
