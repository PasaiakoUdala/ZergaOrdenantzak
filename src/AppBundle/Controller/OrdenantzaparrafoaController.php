<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ordenantzaparrafoa;
use AppBundle\Form\OrdenantzaparrafoaType;

/**
 * Ordenantzaparrafoa controller.
 *
 * @Route("/admin/ordenantzaparrafoa")
 */
class OrdenantzaparrafoaController extends Controller
{
    /**
     * @Route("/up/{id}", name="admin_ordenantzaparrafoa_up")
     * @Method("GET")
     */
    public function upAction(Request $request, Ordenantzaparrafoa $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() - 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/down/{id}", name="admin_ordenantzaparrafoa_down")
     * @Method("GET")
     */
    public function downAction(Request $request, Ordenantzaparrafoa $op)
    {
        $em = $this->getDoctrine()->getManager();
        $op->setOrdena($op->getOrdena() + 1);
        $em->persist($op);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Creates a new Ordenantzaparrafoa entity.
     *
     * @Route("/new/{ordenantzaid}", name="admin_ordenantzaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $ordenantzaid)
    {
        $em = $this->getDoctrine();

        $ordenantzaparrafoa = new Ordenantzaparrafoa();
        $ordenantza = $em->getRepository( 'AppBundle:Ordenantza' )->find( $ordenantzaid );
        $ordenantzaparrafoa->setOrdenantza( $ordenantza );
        $ordenantzaparrafoa->setUdala( $this->getUser()->getUdala() );

        $form = $this->createForm('AppBundle\Form\OrdenantzaparrafoaType', $ordenantzaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenantzaparrafoa);
            $em->flush();

            return $this->redirect( $request->headers->get( 'referer' ) . '#ordenantzaparrafoa'.$ordenantzaparrafoa->getId());
        } 
        
        return $this->render('ordenantzaparrafoa/new.html.twig', array(
            'ordenantzaparrafoa' => $ordenantzaparrafoa,
            'ordenantzaid' => $ordenantzaid,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/ezabatu/{id}", name="admin_ordenantzaparrafoa_ezabatu")
     * @Method("GET")
     */
    public function ezabatuAction(Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($ordenantzaparrafoa);

        return $this->render('ordenantzaparrafoa/_ordenantzaparrafoadeleteform.html.twig', array(            
            'delete_form' => $deleteForm->createView(),
            'id' => $ordenantzaparrafoa->getId()
        ));
    }

    /**
     * Deletes a Ordenantzaparrafoa entity.
     *
     * @Route("/{id}", name="admin_ordenantzaparrafoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        $form = $this->createDeleteForm($ordenantzaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ordenantzaparrafoa);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Ordenantzaparrafoa entity.
     *
     * @param Ordenantzaparrafoa $ordenantzaparrafoa The Ordenantzaparrafoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ordenantzaparrafoa_delete', array('id' => $ordenantzaparrafoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
