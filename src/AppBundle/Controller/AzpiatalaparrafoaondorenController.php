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
     * @Route("/up/{id}", name="admin_azpiatalaparrafoaondoren_up")
     * @Method("GET")
     */
    public function upAction(Request $request, Azpiatalaparrafoaondoren $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() - 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/down/{id}", name="admin_azpiatalaparrafoaondoren_down")
     * @Method("GET")
     */
    public function downAction(Request $request, Azpiatalaparrafoaondoren $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() + 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
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
     * @Route("/new/{azpiatalaid}", options = { "expose" = true }, name="admin_azpiatalaparrafoaondoren_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $azpiatalaid )
    {
        $em = $this->getDoctrine();

        $azpiatala = $em->getRepository( 'AppBundle:Azpiatala' )->find( $azpiatalaid );
        $azpiatalaparrafoaondoren = new Azpiatalaparrafoaondoren();
        $azpiatalaparrafoaondoren->setAzpiatala( $azpiatala );
        $azpiatalaparrafoaondoren->setUdala( $this->getUser()->getUdala() );

        $form = $this->createForm('AppBundle\Form\AzpiatalaparrafoaondorenType', $azpiatalaparrafoaondoren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpiatalaparrafoaondoren);
            $em->flush($azpiatalaparrafoaondoren);

            return $this->redirect( $request->headers->get( 'referer' ) . '#azpiatalaparrafoaondoren'.$azpiatalaparrafoaondoren->getId());
        }

        return $this->render('azpiatalaparrafoaondoren/new.html.twig', array(
            'azpiatalaparrafoaondoren' => $azpiatalaparrafoaondoren,
            'azpiatalaid'       => $azpiatalaid,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_azpiatalaparrafoaondoren_ezabatu")
     * @Method("GET")
     */
    public function ezabatuAction(Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren)
    {
        $deleteForm = $this->createDeleteForm($azpiatalaparrafoaondoren);

        return $this->render('azpiatalaparrafoaondoren/_azpiatalaparrafoaondorendeleteform.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'id' => $azpiatalaparrafoaondoren->getId()
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

        return $this->redirect( $request->headers->get( 'referer' ) );
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
