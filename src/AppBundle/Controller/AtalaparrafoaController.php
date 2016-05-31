<?php

namespace AppBundle\Controller;

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
     * Lists all Atalaparrafoa entities.
     *
     * @Route("/", name="admin_atalaparrafoa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $atalaparrafoas = $em->getRepository('AppBundle:Atalaparrafoa')->findAll();

        return $this->render('atalaparrafoa/index.html.twig', array(
            'atalaparrafoas' => $atalaparrafoas,
        ));
    }

    /**
     * Creates a new Atalaparrafoa entity.
     *
     * @Route("/new", name="admin_atalaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $atalaparrafoa = new Atalaparrafoa();
        $form = $this->createForm('AppBundle\Form\AtalaparrafoaType', $atalaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atalaparrafoa);
            $em->flush();

            return $this->redirectToRoute('admin_atalaparrafoa_show', array('id' => $atalaparrafoa->getId()));
        }

        return $this->render('atalaparrafoa/new.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Atalaparrafoa entity.
     *
     * @Route("/{id}", name="admin_atalaparrafoa_show")
     * @Method("GET")
     */
    public function showAction(Atalaparrafoa $atalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($atalaparrafoa);

        return $this->render('atalaparrafoa/show.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Atalaparrafoa entity.
     *
     * @Route("/{id}/edit", name="admin_atalaparrafoa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Atalaparrafoa $atalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($atalaparrafoa);
        $editForm = $this->createForm('AppBundle\Form\AtalaparrafoaType', $atalaparrafoa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atalaparrafoa);
            $em->flush();

            return $this->redirectToRoute('admin_atalaparrafoa_edit', array('id' => $atalaparrafoa->getId()));
        }

        return $this->render('atalaparrafoa/edit.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
