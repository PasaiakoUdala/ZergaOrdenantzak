<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Atala;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Entity\Azpiatala;
use AppBundle\Entity\Azpiatalaparrafoa;
use AppBundle\Entity\Kontzeptua;
use AppBundle\Entity\Ordenantzaparrafoa;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Historikoa;
use AppBundle\Form\HistorikoaType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Historikoa controller.
 *
 * @Route("/{_locale}/admin/historikoa")
 */
class HistorikoaController extends Controller {

    /**
     * Lists all Historikoa entities.
     *
     * @Route("/", defaults={"page" = 1}, name="admin_historikoa_index")
     * @Route("/page{page}", name="admin_historikoa_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $historikoas = $em->createQuery("SELECT h FROM AppBundle:Historikoa h order by h.id DESC")->getResult();

        $deleteForms = array();

        foreach ($historikoas as $entity)
        {
            $deleteForms[ $entity->getId() ] = $this->createDeleteForm($entity)->createView();
        }

        $adapter = new ArrayAdapter($historikoas);
        $pagerfanta = new Pagerfanta($adapter);

        try
        {
            $entities = $pagerfanta
                ->setMaxPerPage(5)
                ->setCurrentPage($page)
                ->getCurrentPageResults();
        } catch (NotValidCurrentPageException $e)
        {
            throw $this->createNotFoundException("Orria ez da existitzen");
        }


        return $this->render('historikoa/index.html.twig', array(
            'historikoas' => $entities,
            'deleteForms' => $deleteForms,
            'pager'       => $pagerfanta,
        ));
    }

    /**
     * Creates a new Historikoa entity.
     *
     * @Route("/new", name="admin_historikoa_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAllOrderByKodea();

        $historikoa = new Historikoa();
        $form = $this->createForm('AppBundle\Form\HistorikoaType', $historikoa);
        $form->getData()->setUdala($this->getUser()->getUdala());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            /** @var  $ordenantza \AppBundle\Entity\Ordenantza */
            foreach ($ordenantzas as $ordenantza)
            {
                $filename = $this->getFilename($this->getUser()->getUdala()->getKodea(), $ordenantza->getKodea());

                /* Begiratu ezabatze marka duen, baldin badu ezabatu */
                if ($ordenantza->getEzabatu() == 1)
                {
                    $em->remove($ordenantza);
                } else
                {

                    /* Historikora pasa, hau da prod eremuetara */

                    $ordenantza->setIzenburuaesProd($ordenantza->getIzenburuaes());
                    $ordenantza->setIzenburuaeuProd($ordenantza->getIzenburuaeu());
                    $ordenantza->setKodeaProd($ordenantza->getKodea());
                    $em->persist($ordenantza);

                    /** @var Ordenantzaparrafoa $p */
                  foreach ($ordenantza->getParrafoak() as $p)
                    {
                        if ($p->getEzabatu() === 1) {
                          $em->remove($p);
                        } else {
                          /** @var $p \AppBundle\Entity\Ordenantzaparrafoa */
                          $p->setOrdenaProd($p->getOrdena());
                          $p->setTestuaesProd($p->getTestuaes());
                          $p->setTestuaeuProd($p->getTestuaeu());
                        }

                        $em->persist($p);
                    }

                    foreach ($ordenantza->getAtalak() as $atala)
                    {

                        if ($atala->getEzabatu() === 1)
                        {
                            $em->remove($atala);
                            $em->persist($atala);
                        }
                        else
                        {
                            $atala->setIzenburuaeuProd($atala->getIzenburuaeu());
                            $atala->setIzenburuaesProd($atala->getIzenburuaes());
                            $atala->setKodeaProd($atala->getKodea());
                            $atala->setUtsaProd($atala->getUtsa());
                            $em->persist($atala);

                            /** @var  $atalaparrafoa \AppBundle\Entity\Atalaparrafoa */
                            foreach ($atala->getParrafoak() as $atalaparrafoa)
                            {
                                if ($atalaparrafoa->getEzabatu() === 1)
                                {
                                    $em->remove($atalaparrafoa);
                                    $em->persist($atalaparrafoa);
                                } else
                                {
                                    $atalaparrafoa->setOrdenaProd($atalaparrafoa->getOrdena());
                                    $atalaparrafoa->setTestuaesProd($atalaparrafoa->getTestuaes());
                                    $atalaparrafoa->setTestuaeuProd($atalaparrafoa->getTestuaeu());
                                    $em->persist($atalaparrafoa);
                                }
                            }

                            /** @var  $azpiatala \AppBundle\Entity\Azpiatala */
                            foreach ($atala->getAzpiatalak() as $azpiatala)
                            {
                                if ($azpiatala->getEzabatu() === 1)
                                {
                                    $em->remove($azpiatala);
                                    $em->persist($azpiatala);
                                } else
                                {
                                    $azpiatala->setKodeaProd($azpiatala->getKodea());
                                    $azpiatala->setIzenburuaesProd($azpiatala->getIzenburuaes());
                                    $azpiatala->setIzenburuaeuProd($azpiatala->getIzenburuaeu());
                                    $em->persist($azpiatala);

                                    foreach ($azpiatala->getParrafoak() as $azpiatalaparrafoa)
                                    {

                                        if ($azpiatalaparrafoa->getEzabatu() === 1)
                                        {
                                            $em->remove($azpiatalaparrafoa);
                                            $em->persist($azpiatalaparrafoa);
                                        } else
                                        {
                                            $azpiatalaparrafoa->setTestuaesProd($azpiatalaparrafoa->getTestuaes());
                                            $azpiatalaparrafoa->setTestuaeuProd($azpiatalaparrafoa->getTestuaeu());
                                            $azpiatalaparrafoa->setOrdenaProd($azpiatalaparrafoa->getOrdena());
                                            $em->persist($azpiatalaparrafoa);
                                        }
                                    }


                                    foreach ($azpiatala->getKontzeptuak() as $kontzeptua)
                                    {

                                        if ($kontzeptua->getEzabatu() === 1)
                                        {
                                            $em->remove($kontzeptua);
                                            $em->persist($kontzeptua);
                                        } else
                                        {
                                            $kontzeptua->setKodeaProd($kontzeptua->getKodea());
                                            $kontzeptua->setKontzeptuaesProd($kontzeptua->getKontzeptuaes());
                                            $kontzeptua->setKontzeptuaeuProd($kontzeptua->getKontzeptuaeu());
                                            $kontzeptua->setKopuruaProd($kontzeptua->getKopurua());
                                            $kontzeptua->setUnitateaProd($kontzeptua->getUnitatea());
                                            $em->persist($kontzeptua);
                                        }
                                    }

                                    foreach ($azpiatala->getParrafoakondoren() as $azpiatalaparrafoa)
                                    {

                                        if ($azpiatalaparrafoa->getEzabatu() === 1)
                                        {
                                            $em->remove($azpiatalaparrafoa);
                                            $em->persist($azpiatalaparrafoa);
                                        } else
                                        {
                                            $azpiatalaparrafoa->setTestuaesProd($azpiatalaparrafoa->getTestuaes());
                                            $azpiatalaparrafoa->setTestuaeuProd($azpiatalaparrafoa->getTestuaeu());
                                            $azpiatalaparrafoa->setOrdenaProd($azpiatalaparrafoa->getOrdena());
                                            $em->persist($azpiatalaparrafoa);
                                        }
                                    }

                                }
                            }
                        }
                    }
                }

                $em->flush();

            }
          $eguna = date("Y-m-d_His");
            /* PDF Fitxategia sortuko dugu*/
            /** @var \TCPDF $pdf */
//            $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//
//            $pdf->footerTitle = $form["indarreandata"]->getData()->format('Y/m/d');;
//
//
//            $pdf->SetAuthor($this->getUser()->getUdala());
//            $pdf->SetTitle($this->getUser()->getUdala() . "-Zerga Ordenantzak");
//
//            $pdf->setFontSubsetting(true);
//            $pdf->SetFont('helvetica', '', 11, '', true);
//
//            $pdf->setHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
//
//            $pdf->AddPage();
//
//
//            $filename = $this->getFilename($this->getUser()->getUdala()->getKodea(), "ZergaOrdenantzak-" . $eguna);
//
//            $azala = $this->render('ordenantza/azala.html.twig', array('eguna' => date("Y"), 'udala' => $this->getUser()->getUdala()));
//
//            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $azala->getContent(), $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//
//            $pdf->AddPage();
//
//            foreach ($ordenantzas as $ordenantza)
//            {
//                $mihtml = $this->render('ordenantza/pdf.html.twig', array('ordenantza' => $ordenantza));
//                $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $mihtml->getContent(), $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//                $pdf->AddPage();
//            }
//
//
//            $pdf->Output($filename . ".pdf", 'F'); // This will output the PDF as a response directly

            $historikoa->setFitxategia("ZergaOrdenantzak-" . $eguna . ".pdf");
            $em->persist($historikoa);
            $em->flush();

            return $this->redirectToRoute('admin_historikoa_index');
        }

        return $this->render('historikoa/new.html.twig', array(
            'historikoa' => $historikoa,
            'form'       => $form->createView(),
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
            'historikoa'  => $historikoa,
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

        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($historikoa);
            $em->flush();

            return $this->redirectToRoute('admin_historikoa_edit', array('id' => $historikoa->getId()));
        }

        return $this->render('historikoa/edit.html.twig', array(
            'historikoa'  => $historikoa,
            'edit_form'   => $editForm->createView(),
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

        if ($form->isSubmitted() && $form->isValid())
        {
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
            ->getForm();
    }

    private function getFilename($udala, $ordenantzaKodea)
    {
        $fs = new Filesystem();

        $base = $this->get('kernel')->getRootDir() . '/../web/doc/';

        try
        {
            if ($fs->exists($base . $udala) == false)
            {
                $fs->mkdir($base . $udala);
            }
        } catch (IOExceptionInterface $e)
        {
            echo "Arazoa bat egon da karpeta sortzerakoan " . $e->getPath();
        }

        return $base . $udala . "/" . $ordenantzaKodea;

    }
}
