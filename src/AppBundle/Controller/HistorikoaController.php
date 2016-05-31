<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Historikoa;
use AppBundle\Form\HistorikoaType;

/**
 * Historikoa controller.
 *
 * @Route("/admin/historikoa")
 */
class HistorikoaController extends Controller
{
    /**
     * Lists all Historikoa entities.
     *
     * @Route("/", name="admin_historikoa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $historikoas = $em->getRepository('AppBundle:Historikoa')->findAll();

        return $this->render('historikoa/index.html.twig', array(
            'historikoas' => $historikoas,
        ));
    }

    /**
     * Creates a new Historikoa entity.
     *
     * @Route("/new", name="admin_historikoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $historikoa = new Historikoa();
        $form = $this->createForm('AppBundle\Form\HistorikoaType', $historikoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($historikoa);
            $em->flush();

            return $this->redirectToRoute('admin_historikoa_show', array('id' => $historikoa->getId()));
        }

        return $this->render('historikoa/new.html.twig', array(
            'historikoa' => $historikoa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Historikoa entity.
     *
     * @Route("/{id}", name="admin_historikoa_show")
     * @Method("GET")
     */
    public function showAction(Historikoa $historikoa)
    {
        $deleteForm = $this->createDeleteForm($historikoa);

        return $this->render('historikoa/show.html.twig', array(
            'historikoa' => $historikoa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Historikoa entity.
     *
     * @Route("/{id}/edit", name="admin_historikoa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Historikoa $historikoa)
    {
        $deleteForm = $this->createDeleteForm($historikoa);
        $editForm = $this->createForm('AppBundle\Form\HistorikoaType', $historikoa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($historikoa);
            $em->flush();

            return $this->redirectToRoute('admin_historikoa_edit', array('id' => $historikoa->getId()));
        }

        return $this->render('historikoa/edit.html.twig', array(
            'historikoa' => $historikoa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Historikoa entity.
     *
     * @Route("/{id}", name="admin_historikoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Historikoa $historikoa)
    {
        $form = $this->createDeleteForm($historikoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($historikoa);
            $em->flush();
        }

        return $this->redirectToRoute('admin_historikoa_index');
    }

    /**
     * Creates a form to delete a Historikoa entity.
     *
     * @param Historikoa $historikoa The Historikoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Historikoa $historikoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_historikoa_delete', array('id' => $historikoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
