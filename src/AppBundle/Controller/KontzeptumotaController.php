<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Kontzeptumota;
use AppBundle\Form\KontzeptumotaType;

/**
 * Kontzeptumota controller.
 *
 * @Route("/admin/kontzeptumota")
 */
class KontzeptumotaController extends Controller
{
    /**
     * Lists all Kontzeptumota entities.
     *
     * @Route("/", name="admin_kontzeptumota_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $kontzeptumotas = $em->getRepository('AppBundle:Kontzeptumota')->findAll();

        return $this->render('kontzeptumota/index.html.twig', array(
            'kontzeptumotas' => $kontzeptumotas,
        ));
    }

    /**
     * Creates a new Kontzeptumota entity.
     *
     * @Route("/new", name="admin_kontzeptumota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $kontzeptumotum = new Kontzeptumota();
        $form = $this->createForm('AppBundle\Form\KontzeptumotaType', $kontzeptumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptumotum);
            $em->flush();

            return $this->redirectToRoute('admin_kontzeptumota_show', array('id' => $kontzeptumotum->getId()));
        }

        return $this->render('kontzeptumota/new.html.twig', array(
            'kontzeptumotum' => $kontzeptumotum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Kontzeptumota entity.
     *
     * @Route("/{id}", name="admin_kontzeptumota_show")
     * @Method("GET")
     */
    public function showAction(Kontzeptumota $kontzeptumotum)
    {
        $deleteForm = $this->createDeleteForm($kontzeptumotum);

        return $this->render('kontzeptumota/show.html.twig', array(
            'kontzeptumotum' => $kontzeptumotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kontzeptumota entity.
     *
     * @Route("/{id}/edit", name="admin_kontzeptumota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kontzeptumota $kontzeptumotum)
    {
        $deleteForm = $this->createDeleteForm($kontzeptumotum);
        $editForm = $this->createForm('AppBundle\Form\KontzeptumotaType', $kontzeptumotum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptumotum);
            $em->flush();

            return $this->redirectToRoute('admin_kontzeptumota_edit', array('id' => $kontzeptumotum->getId()));
        }

        return $this->render('kontzeptumota/edit.html.twig', array(
            'kontzeptumotum' => $kontzeptumotum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Kontzeptumota entity.
     *
     * @Route("/{id}", name="admin_kontzeptumota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kontzeptumota $kontzeptumotum)
    {
        $form = $this->createDeleteForm($kontzeptumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kontzeptumotum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_kontzeptumota_index');
    }

    /**
     * Creates a form to delete a Kontzeptumota entity.
     *
     * @param Kontzeptumota $kontzeptumotum The Kontzeptumota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kontzeptumota $kontzeptumotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_kontzeptumota_delete', array('id' => $kontzeptumotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
