<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Baldintza;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Baldintza controller.
 *
 * @Route("baldintza")
 */
class BaldintzaController extends Controller
{
    /**
     * Lists all baldintza entities.
     *
     * @Route("/", name="baldintza_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $baldintzas = $em->getRepository('AppBundle:Baldintza')->findAll();

        return $this->render('baldintza/index.html.twig', array(
            'baldintzas' => $baldintzas,
        ));
    }

    /**
     * Creates a new baldintza entity.
     *
     * @Route("/new", name="baldintza_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $baldintza = new Baldintza();
        $form = $this->createForm('AppBundle\Form\BaldintzaType', $baldintza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($baldintza);
            $em->flush($baldintza);

            return $this->redirectToRoute('baldintza_show', array('id' => $baldintza->getId()));
        }

        return $this->render('baldintza/new.html.twig', array(
            'baldintza' => $baldintza,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a baldintza entity.
     *
     * @Route("/{id}", name="baldintza_show")
     * @Method("GET")
     */
    public function showAction(Baldintza $baldintza)
    {
        $deleteForm = $this->createDeleteForm($baldintza);

        return $this->render('baldintza/show.html.twig', array(
            'baldintza' => $baldintza,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing baldintza entity.
     *
     * @Route("/{id}/edit", name="baldintza_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Baldintza $baldintza)
    {
        $deleteForm = $this->createDeleteForm($baldintza);
        $editForm = $this->createForm('AppBundle\Form\BaldintzaType', $baldintza);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('baldintza_edit', array('id' => $baldintza->getId()));
        }

        return $this->render('baldintza/edit.html.twig', array(
            'baldintza' => $baldintza,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a baldintza entity.
     *
     * @Route("/{id}", name="baldintza_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Baldintza $baldintza)
    {
        $form = $this->createDeleteForm($baldintza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($baldintza);
            $em->flush($baldintza);
        }

        return $this->redirectToRoute('baldintza_index');
    }

    /**
     * Creates a form to delete a baldintza entity.
     *
     * @param Baldintza $baldintza The baldintza entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Baldintza $baldintza)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('baldintza_delete', array('id' => $baldintza->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
