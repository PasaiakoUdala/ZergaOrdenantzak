<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Kontzeptua;
use AppBundle\Form\KontzeptuaType;

/**
 * Kontzeptua controller.
 *
 * @Route("/admin/kontzeptua")
 */
class KontzeptuaController extends Controller
{
    /**
     * Lists all Kontzeptua entities.
     *
     * @Route("/", name="admin_kontzeptua_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $kontzeptuas = $em->getRepository('AppBundle:Kontzeptua')->findAll();

        return $this->render('kontzeptua/index.html.twig', array(
            'kontzeptuas' => $kontzeptuas,
        ));
    }

    /**
     * Creates a new Kontzeptua entity.
     *
     * @Route("/new", name="admin_kontzeptua_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $kontzeptua = new Kontzeptua();
        $form = $this->createForm('AppBundle\Form\KontzeptuaType', $kontzeptua);
        $form->getData()->setUdala($this->getUser()->getUdala());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptua);
            $em->flush();

            return $this->redirectToRoute('admin_kontzeptua_show', array('id' => $kontzeptua->getId()));
        }

        return $this->render('kontzeptua/new.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Kontzeptua entity.
     *
     * @Route("/{id}", name="admin_kontzeptua_show")
     * @Method("GET")
     */
    public function showAction(Kontzeptua $kontzeptua)
    {
        $deleteForm = $this->createDeleteForm($kontzeptua);

        return $this->render('kontzeptua/show.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kontzeptua entity.
     *
     * @Route("/{id}/edit", name="admin_kontzeptua_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kontzeptua $kontzeptua)
    {
        $deleteForm = $this->createDeleteForm($kontzeptua);
        $editForm = $this->createForm('AppBundle\Form\KontzeptuaType', $kontzeptua);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptua);
            $em->flush();

            return $this->redirectToRoute('admin_kontzeptua_edit', array('id' => $kontzeptua->getId()));
        }

        return $this->render('kontzeptua/edit.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Kontzeptua entity.
     *
     * @Route("/{id}", name="admin_kontzeptua_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kontzeptua $kontzeptua)
    {
        $form = $this->createDeleteForm($kontzeptua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kontzeptua);
            $em->flush();
        }

        return $this->redirectToRoute('admin_kontzeptua_index');
    }

    /**
     * Creates a form to delete a Kontzeptua entity.
     *
     * @param Kontzeptua $kontzeptua The Kontzeptua entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kontzeptua $kontzeptua)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_kontzeptua_delete', array('id' => $kontzeptua->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
