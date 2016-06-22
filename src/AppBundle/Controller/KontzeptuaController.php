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
     * Creates a new Kontzeptua entity.
     *
     * @Route("/new/{azpiatalaid}", options = { "expose" = true }, name="admin_kontzeptua_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $azpiatalaid)
    {
        $em = $this->getDoctrine();

        $azpiatala = $em->getRepository( 'AppBundle:Kontzeptua' )->find( $azpiatalaid );
        $kontzeptua = new Kontzeptua();
        $kontzeptua->setAzpiatala( $azpiatala );
        $kontzeptua->setUdala( $this->getUser()->getUdala() );

        $form = $this->createForm('AppBundle\Form\KontzeptuaType', $kontzeptua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptua);
            $em->flush();

            return $this->redirect( $request->headers->get( 'referer' ) );
        }

        return $this->render('kontzeptua/new.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'form' => $form->createView(),
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

        return $this->redirect( $request->headers->get( 'referer' ) );
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
