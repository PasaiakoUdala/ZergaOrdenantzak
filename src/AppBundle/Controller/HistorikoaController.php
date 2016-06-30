<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Atala;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Entity\Azpiatala;
use AppBundle\Entity\Azpiatalaparrafoa;
use AppBundle\Entity\Kontzeptua;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Historikoa;
use AppBundle\Form\HistorikoaType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

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
     * @Route("/new/{ordenantzaid}", name="admin_historikoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $ordenantzaid)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantza = $em->getRepository( 'AppBundle:Ordenantza' )->find( $ordenantzaid );


        /* PDF-a sortu eta web/doc/{UDALKODEA}/pdf karpetan gorde */
//        $mihtml= $this->render('ordenantza/pdf.html.twig', array('ordenantza' => $ordenantza));
//
//        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//        $pdf->SetAuthor($this->getUser()->getUdala());
//        $pdf->SetTitle(($ordenantza->getIzenburuaeu()));
//        $pdf->setFontSubsetting(true);
//        $pdf->SetFont('helvetica', '', 11, '', true);
//        $pdf->AddPage();
//        $path = $this->get('kernel')->getRootDir() . '/../web/doc/';
//        $filename = $path. $this->getUser()->getUdala()->getKodea() . '/pdf/' . $ordenantza->getKodea();

        $filename = $this->getFilename( $this->getUser()->getUdala()->getKodea(), $ordenantza->getKodea() );
        
            
//        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $mihtml->getContent(), $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//        $pdf->Output($filename.".pdf",'F'); // This will output the PDF as a response directly

        /* Begiratu ezabatze marka duen, baldin badu ezabatu */

        if ( $ordenantza->getEzabatu() == 1 ){
            $em->remove( $ordenantza );
        } else {

            /* Historikora pasa, hau da prod eremuetara */

            $ordenantza->setIzenburuaesProd( $ordenantza->getIzenburuaes() );
            $ordenantza->setIzenburuaeuProd( $ordenantza->getIzenburuaeu() );

            foreach ( $ordenantza->getAtalak() as $atala  ) {

                if ( $atala->getEzabatu() == 1 ) {
                    $em->remove( $atala );
                } else {
                    $atala->setIzenburuaeuProd( $atala->getIzenburuaeu() );
                    $atala->setIzenburuaesProd( $atala->getIzenburuaes() );
                    $atala->setKodeaProd( $atala->getKodea() );
                    $atala->setUtsaProd( $atala->getUtsa() );

                    foreach ($atala->getParrafoak() as $atalaparrafoa ) {
                        if ($atalaparrafoa->getEzabatu()==1){
                            $em->remove( $atalaparrafoa );
                        } else {
                            $atalaparrafoa->setOrdenaProd( $atalaparrafoa->getOrdena() );
                            $atalaparrafoa->setTestuaesProd( $atalaparrafoa->getTestuaes() );
                            $atalaparrafoa->setTestuaeuProd( $atalaparrafoa->getTestuaeu() );
                        }
                    }


                    foreach ($atala->getAzpiatalak() as $azpiatala) {
                        if ($azpiatala->getEzabatu()==1){
                            $em->remove( $azpiatala );
                        } else {
                            $azpiatala->setKodeaProd( $azpiatala->getKodea() );
                            $azpiatala->setIzenburuaesProd( $azpiatala->getIzenburuaes() );
                            $azpiatala->setIzenburuaeuProd( $azpiatala->getIzenburuaeu() );
                            foreach ($azpiatala->getParrafoak() as $azpiatalaparrafoa){

                                if ( $azpiatalaparrafoa->getEzabatu() == 1 ) {
                                    $em->remove( $azpiatalaparrafoa );
                                } else {
                                    $azpiatalaparrafoa->setTestuaesProd( $azpiatalaparrafoa->getTestuaes() );
                                    $azpiatalaparrafoa->setTestuaeuProd( $azpiatalaparrafoa->getTestuaeu() );
                                    $azpiatalaparrafoa->setOrdenaProd( $azpiatalaparrafoa->getOrdena() );

                                }
                            }


                            foreach ($azpiatala->getKontzeptuak() as $kontzeptua){

                                if ( $kontzeptua->getEzabatu() == 1 ) {
                                    $em->remove( $kontzeptua );
                                } else {
                                    $kontzeptua = new Kontzeptua();
                                    $kontzeptua->setKodeaProd( $kontzeptua->getKodea() );
                                    $kontzeptua->setKontzeptuaesProd( $kontzeptua->getKontzeptuaes() );
                                    $kontzeptua->setKontzeptuaeuProd( $kontzeptua->getKontzeptuaeu() );
                                    $kontzeptua->setKopuruaProd( $kontzeptua->getKopurua() );
                                    $kontzeptua->setUnitateaProd( $kontzeptua->getUnitatea() );
                                }
                            }
                        }
                    }
                }
            }
        }

        $em->flush();

        $historikoa = new Historikoa();
        $form = $this->createForm('AppBundle\Form\HistorikoaType', $historikoa);
        $form->getData()->setUdala($this->getUser()->getUdala());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($historikoa);
            $em->flush();

            return $this->redirectToRoute('admin_historikoa_index');
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

    private function getFilename($udala, $ordenantzaKodea)
    {
        $fs = new Filesystem();

        $base = $this->get('kernel')->getRootDir() . '/../web/doc/';

        try {
            if ( $fs->exists($base . $udala) == false ) {
                $fs->mkdir($base .$udala);
            }
        } catch (IOExceptionInterface $e) {
            echo "Arazoa bat egon da karpeta sortzerakoan ".$e->getPath();
        }

        return $base.$udala.$ordenantzaKodea;

    }
}
