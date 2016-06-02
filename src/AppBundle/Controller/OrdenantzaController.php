<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ordenantza;
use AppBundle\Form\OrdenantzaType;

/**
 * Ordenantza controller.
 *
 * @Route("/admin/ordenantza")
 */
class OrdenantzaController extends Controller
{
    /**
     * Lists all Ordenantza entities.
     *
     * @Route("/", name="admin_ordenantza_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAll();

        return $this->render('ordenantza/index.html.twig', array(
            'ordenantzas' => $ordenantzas,
        ));
    }

    /**
     * Creates a new Ordenantza entity.
     *
     * @Route("/new", name="admin_ordenantza_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ordenantza = new Ordenantza();
        $form = $this->createForm('AppBundle\Form\OrdenantzaType', $ordenantza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenantza);
            $em->flush();

            return $this->redirectToRoute('admin_ordenantza_show', array('id' => $ordenantza->getId()));
        }

        return $this->render('ordenantza/new.html.twig', array(
            'ordenantza' => $ordenantza,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/{id}", name="admin_ordenantza_show")
     * @Method("GET")
     */
    public function showAction(Ordenantza $ordenantza)
    {
        $deleteForm = $this->createDeleteForm($ordenantza);

//        dump($ordenantza);
        return $this->render('ordenantza/show.html.twig', array(
            'ordenantza' => $ordenantza,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ordenantza entity.
     *
     * @Route("/{id}/edit", name="admin_ordenantza_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ordenantza $ordenantza)
    {
        $deleteForm = $this->createDeleteForm($ordenantza);
        $editForm = $this->createForm('AppBundle\Form\OrdenantzaType', $ordenantza);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenantza);
            $em->flush();

            return $this->redirectToRoute('admin_ordenantza_edit', array('id' => $ordenantza->getId()));
        }

        return $this->render('ordenantza/edit.html.twig', array(
            'ordenantza' => $ordenantza,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ordenantza entity.
     *
     * @Route("/{id}", name="admin_ordenantza_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ordenantza $ordenantza)
    {
        $form = $this->createDeleteForm($ordenantza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ordenantza);
            $em->flush();
        }

        return $this->redirectToRoute('admin_ordenantza_index');
    }

    /**
     * Creates a form to delete a Ordenantza entity.
     *
     * @param Ordenantza $ordenantza The Ordenantza entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ordenantza $ordenantza)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ordenantza_delete', array('id' => $ordenantza->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
