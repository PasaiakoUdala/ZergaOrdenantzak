<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ordenantza;
use AppBundle\Form\OrdenantzaType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Ordenantza controller.
 *
 * @Route("/admin/ordenantza")
 */
class OrdenantzaController extends Controller
{

    /**
     * @Route("/eguneratu/{id}", name="admin_ordenantza_eguneratu")
     * @Method("POST")
     */
    public function eguneratuAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantza = $em->getRepository('AppBundle:Ordenantza')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "izenburuaeu":
                $ordenantza->setIzenburuaeu($value);
                break;
            case "izenburuaes":
                $ordenantza->setIzenburuaes($value);
                break;
            case "testuaeu":
                $ordenantza->setTestuaeu($value);
                break;
            case "testuaes":
                $ordenantza->setTestuaes($value);
                break;
        }

        $em->persist($ordenantza);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
     * @Route("/eguneratuparrafoa/{id}", name="admin_ordenantza_parrafoak_eguneratu")
     * @Method("POST")
     */
    public function eguneratuparrafoakAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzaparrafoa = $em->getRepository('AppBundle:Ordenantzaparrafoa')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "testuaeu":
                $ordenantzaparrafoa->setTestuaeu($value);
                break;
            case "testuaes":
                $ordenantzaparrafoa->setTestuaes($value);
                break;
        }

        $em->persist($ordenantzaparrafoa);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
     * @Route("/eguneratuatala/{id}", name="admin_ordenantza_atala_eguneratu")
     * @Method("POST")
     */
    public function eguneratuatalaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $atala = $em->getRepository('AppBundle:Atala')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "kodea":
                $atala->setKodea($value);
                break;
            case "izenburuaeu":
                $atala->setIzenburuaeu($value);
                break;
            case "izenburuaes":
                $atala->setIzenburuaes($value);
                break;
        }

        $em->persist($atala);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
     * @Route("/eguneratuatalaparrafoa/{id}", name="admin_ordenantza_atalaparrafoa_eguneratu")
     * @Method("POST")
     */
    public function eguneratuatalaparrafoaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $atalap = $em->getRepository('AppBundle:Atalaparrafoa')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "testuaeu":
                $atalap->setTestuaeu($value);
                break;
            case "testuaes":
                $atalap->setTestuaes($value);
                break;
        }

        $em->persist($atalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
     * @Route("/eguneratuazpiatala/{id}", name="admin_ordenantza_azpiatala_eguneratu")
     * @Method("POST")
     */
    public function eguneratuazpiatalaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "izenburuaeu":
                $azpiatala->setIzenburuaeu($value);
                break;
            case "izenburuaes":
                $azpiatala->setIzenburuaes($value);
                break;
        }

        $em->persist($azpiatala);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
 * @Route("/eguneratuazpiatalaparrafoa/{id}", name="admin_ordenantza_azpiatalaparrafoa_eguneratu")
 * @Method("POST")
 */
    public function eguneratuazpiatalaparrafoaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $azpiatalap = $em->getRepository('AppBundle:Azpiatalaparrafoa')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "testuaeu":
                $azpiatalap->setTestuaeu($value);
                break;
            case "testuaes":
                $azpiatalap->setTestuaes($value);
                break;
        }

        $em->persist($azpiatalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

    /**
     * @Route("/eguneratuazpiatalakontzeptuoa/{id}", name="admin_ordenantza_azpiatalakontzeptua_eguneratu")
     * @Method("POST")
     */
    public function eguneratuazpiatalakontzeptuaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $azpiatalap = $em->getRepository('AppBundle:Kontzeptua')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "kontzeptuaeu":
                $azpiatalap->setKontzeptuaeu($value);
                break;
            case "kontzeptuaes":
                $azpiatalap->setKontzeptuaes($value);
                break;
            case "kopurua":
                $azpiatalap->setKopurua($value);
                break;
            case "kontzeptuaes":
                $azpiatalap->setUnitatea($value);
                break;

        }

        $em->persist($azpiatalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
            'resul' => "OK"
        ));
        return $response;
    }

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
        $form->getData()->setUdala($this->getUser()->getUdala());
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
        $deleteForms = array();

        foreach ($ordenantza->getParrafoak() as $p) {
            $deleteForms[$p->getId()] = $this->createFormBuilder()
                ->setAction($this->generateUrl('admin_ordenantzaparrafoa_delete', array('id' => $p->getId())))
                ->setMethod('DELETE')
                ->getForm()->createView();
        }

        return $this->render('ordenantza/show.html.twig', array(
            'ordenantza' => $ordenantza,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/pdf/{id}", name="admin_ordenantza_show_pdf")
     * @Method("GET")
     */
    public function showpdfAction(Ordenantza $ordenantza)
    {

        $mihtml= $this->render('ordenantza/pdf.html.twig', array('ordenantza' => $ordenantza));

        
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor($this->getUser()->getUdala());
        $pdf->SetTitle(($ordenantza->getIzenburuaeu()));
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        $filename = 'zzoo';
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $mihtml->getContent(), $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
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
        } else {

            $string = (string) $form->getErrors(true, false);
            dump($form->getErrors(true, false));
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
