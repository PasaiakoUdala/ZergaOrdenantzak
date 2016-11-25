<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Azpiatalaparrafoaondoren;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Azpiatalaparrafoaondoren controller.
 *
 * @Route("admin/azpiatalaparrafoaondoren")
 */
class AzpiatalaparrafoaondorenController extends Controller
{
    /**
     * Lists all azpiatalaparrafoaondoren entities.
     *
     * @Route("/", name="admin_azpiatalaparrafoaondoren_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $azpiatalaparrafoaondorens = $em->getRepository('AppBundle:Azpiatalaparrafoaondoren')->findAll();

        return $this->render('azpiatalaparrafoaondoren/index.html.twig', array(
            'azpiatalaparrafoaondorens' => $azpiatalaparrafoaondorens,
        ));
    }

    /**
     * Creates a new azpiatalaparrafoaondoren entity.
     *
     * @Route("/new", name="admin_azpiatalaparrafoaondoren_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $azpiatalaparrafoaondoren = new Azpiatalaparrafoaondoren();
        $form = $this->createForm('AppBundle\Form\AzpiatalaparrafoaondorenType', $azpiatalaparrafoaondoren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpiatalaparrafoaondoren);
            $em->flush($azpiatalaparrafoaondoren);

            return $this->redirectToRoute('admin_azpiatalaparrafoaondoren_show', array('id' => $azpiatalaparrafoaondoren->getId()));
        }

        return $this->render('azpiatalaparrafoaondoren/new.html.twig', array(
            'azpiatalaparrafoaondoren' => $azpiatalaparrafoaondoren,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a azpiatalaparrafoaondoren entity.
     *
     * @Route("/{id}", name="admin_azpiatalaparrafoaondoren_show")
     * @Method("GET")
     */
    public function showAction(Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren)
    {
        $deleteForm = $this->createDeleteForm($azpiatalaparrafoaondoren);

        return $this->render('azpiatalaparrafoaondoren/show.html.twig', array(
            'azpiatalaparrafoaondoren' => $azpiatalaparrafoaondoren,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing azpiatalaparrafoaondoren entity.
     *
     * @Route("/{id}/edit", name="admin_azpiatalaparrafoaondoren_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren)
    {
        $deleteForm = $this->createDeleteForm($azpiatalaparrafoaondoren);
        $editForm = $this->createForm('AppBundle\Form\AzpiatalaparrafoaondorenType', $azpiatalaparrafoaondoren);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_azpiatalaparrafoaondoren_edit', array('id' => $azpiatalaparrafoaondoren->getId()));
        }

        return $this->render('azpiatalaparrafoaondoren/edit.html.twig', array(
            'azpiatalaparrafoaondoren' => $azpiatalaparrafoaondoren,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a azpiatalaparrafoaondoren entity.
     *
     * @Route("/{id}", name="admin_azpiatalaparrafoaondoren_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren)
    {
        $form = $this->createDeleteForm($azpiatalaparrafoaondoren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($azpiatalaparrafoaondoren);
            $em->flush($azpiatalaparrafoaondoren);
        }

        return $this->redirectToRoute('admin_azpiatalaparrafoaondoren_index');
    }

    /**
     * Creates a form to delete a azpiatalaparrafoaondoren entity.
     *
     * @param Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren The azpiatalaparrafoaondoren entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_azpiatalaparrafoaondoren_delete', array('id' => $azpiatalaparrafoaondoren->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
