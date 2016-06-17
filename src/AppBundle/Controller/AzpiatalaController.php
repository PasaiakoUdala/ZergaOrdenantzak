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
     * Lists all Azpiatala entities.
     *
     * @Route("/", name="admin_azpiatala_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $azpiatalas = $em->getRepository('AppBundle:Azpiatala')->findAll();

        return $this->render('azpiatala/index.html.twig', array(
            'azpiatalas' => $azpiatalas,
        ));
    }

    /**
     * Creates a new Azpiatala entity.
     *
     * @Route("/new", name="admin_azpiatala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $azpiatala = new Azpiatala();
        $form = $this->createForm('AppBundle\Form\AzpiatalaType', $azpiatala);
        $form->getData()->setUdala($this->getUser()->getUdala());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpiatala);
            $em->flush();

            return $this->redirectToRoute('admin_azpiatala_show', array('id' => $azpiatala->getId()));
        }

        return $this->render('azpiatala/new.html.twig', array(
            'azpiatala' => $azpiatala,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Azpiatala entity.
     *
     * @Route("/{id}", name="admin_azpiatala_show")
     * @Method("GET")
     */
    public function showAction(Azpiatala $azpiatala)
    {
        $deleteForm = $this->createDeleteForm($azpiatala);

        return $this->render('azpiatala/show.html.twig', array(
            'azpiatala' => $azpiatala,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Azpiatala entity.
     *
     * @Route("/{id}/edit", name="admin_azpiatala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpiatala $azpiatala)
    {
        $deleteForm = $this->createDeleteForm($azpiatala);
        $editForm = $this->createForm('AppBundle\Form\AzpiatalaType', $azpiatala);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpiatala);
            $em->flush();

            return $this->redirectToRoute('admin_azpiatala_edit', array('id' => $azpiatala->getId()));
        }

        return $this->render('azpiatala/edit.html.twig', array(
            'azpiatala' => $azpiatala,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        return $this->redirectToRoute('admin_azpiatala_index');
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
