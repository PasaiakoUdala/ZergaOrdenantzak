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
     * Lists all Atala entities.
     *
     * @Route("/", name="admin_atala_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $atalas = $em->getRepository('AppBundle:Atala')->findAll();

        return $this->render('atala/index.html.twig', array(
            'atalas' => $atalas,
        ));
    }

    /**
     * Creates a new Atala entity.
     *
     * @Route("/new", name="admin_atala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $atala = new Atala();
        $form = $this->createForm('AppBundle\Form\AtalaType', $atala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atala);
            $em->flush();

            return $this->redirectToRoute('admin_atala_show', array('id' => $atala->getId()));
        }

        return $this->render('atala/new.html.twig', array(
            'atala' => $atala,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Atala entity.
     *
     * @Route("/{id}", name="admin_atala_show")
     * @Method("GET")
     */
    public function showAction(Atala $atala)
    {
        $deleteForm = $this->createDeleteForm($atala);

        return $this->render('atala/show.html.twig', array(
            'atala' => $atala,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Atala entity.
     *
     * @Route("/{id}/edit", name="admin_atala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Atala $atala)
    {
        $deleteForm = $this->createDeleteForm($atala);
        $editForm = $this->createForm('AppBundle\Form\AtalaType', $atala);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atala);
            $em->flush();

            return $this->redirectToRoute('admin_atala_edit', array('id' => $atala->getId()));
        }

        return $this->render('atala/edit.html.twig', array(
            'atala' => $atala,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
