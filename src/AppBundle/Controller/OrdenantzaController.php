<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Atala;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Entity\Azpiatala;
use AppBundle\Entity\Azpiatalaparrafoa;
use AppBundle\Entity\Azpiatalaparrafoaondoren;
use AppBundle\Entity\Historikoa;
use AppBundle\Entity\Kontzeptua;
use AppBundle\Entity\Ordenantzaparrafoa;
use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use DOMDocument;
use HTMLPurifier;
use InvalidArgumentException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\SimpleType\Jc;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ordenantza;
use AppBundle\Form\OrdenantzaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * Ordenantza controller.
 *
 * @Route("/{_locale}/admin/ordenantza")
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
        /** @var  $ordenantza \AppBundle\Entity\Ordenantza */
        $ordenantza = $em->getRepository('AppBundle:Ordenantza')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');

        $ezabatu = ["<br>", "&lt;br&gt;", "<br \/>", "<br\/>", "&nbsp;", "&amp;nbsp;", "&amp"];
        switch ($name) {
            case "izenburuaeu":
                $testua = str_replace($ezabatu, "", $value);
                $ordenantza->setIzenburuaeu($testua);
                break;
            case "izenburuaes":
                $testua = str_replace($ezabatu, "", $value);
                $ordenantza->setIzenburuaes($testua);
                break;
            case "testuaeu":
                $ordenantza->setTestuaeu($value);
                break;
            case "testuaes":
                $ordenantza->setTestuaes($value);
                break;
            case "kodea":
                $ordenantza->setKodea(str_replace($ezabatu, "", $value));
                break;
        }

        $em->persist($ordenantza);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

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
            case "ordena":
                $ordenantzaparrafoa->setOrdena($value);
        }

        $em->persist($ordenantzaparrafoa);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

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

        $ezabatu = ["<br>", "&lt;br&gt;", "<br \/>", "<br\/>", "&nbsp;", "&amp;nbsp;", "&amp"];

        switch ($name) {
            case "kodea":
                $atala->setKodea($value);
                break;
            case "izenburuaeu":
                $testua = str_replace($ezabatu, "", $value);
                $atala->setIzenburuaeu($testua);
                break;
            case "izenburuaes":
                $testua = str_replace($ezabatu, "", $value);
                $atala->setIzenburuaes($testua);
                break;
        }

        $em->persist($atala);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

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
            case "ordena":
                $atalap->setOrdena($value);
                break;
        }

        $em->persist($atalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

        return $response;
    }

    /**
     * @Route("/eguneratuazpiatala/{id}", name="admin_ordenantza_azpiatala_eguneratu")
     * @Method("POST")
     */
    public function eguneratuazpiatalaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $azpiatala \AppBundle\Entity\Azpiatala */
        $azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');

        $ezabatu = ["<br>", "&lt;br&gt;", "<br \/>", "<br\/>", "&nbsp;", "&amp;nbsp;", "&amp"];

        switch ($name) {
            case "izenburuaeu":
                $testua = str_replace($ezabatu, "", $value);
                $azpiatala->setIzenburuaeu($testua);
                break;
            case "izenburuaes":
                $testua = str_replace($ezabatu, "", $value);
                $azpiatala->setIzenburuaes($testua);
                break;
            case "kodea":
                $azpiatala->setKodea($value);
                break;
        }

        $em->persist($azpiatala);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

        return $response;
    }

    /**
     * @Route("/eguneratuazpiatalaparrafoa/{id}", name="admin_ordenantza_azpiatalaparrafoaondoren_eguneratu")
     * @Method("POST")
     */
    public function eguneratuazpiatalaparrafoaondorenAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $azpiatalap \AppBundle\Entity\Azpiatalaparrafoaondoren * */
        $azpiatalap = $em->getRepository('AppBundle:Azpiatalaparrafoaondoren')->findOneById($id);
        $name = $request->request->get('name');
        $value = $request->request->get('value');


        switch ($name) {
            case "testuaeu":
                $azpiatalap->setTestuaeu($value);
                break;
            case "testuaes":
                $azpiatalap->setTestuaes($value);
                break;
            case "ordena":
                $azpiatalap->setOrdena($value);
                break;
        }

        $em->persist($azpiatalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

        return $response;
    }

    /**
     * @Route("/eguneratuazpiatalaparrafoaondoren/{id}", name="admin_ordenantza_azpiatalaparrafoa_eguneratu")
     * @Method("POST")
     */
    public function eguneratuazpiatalaparrafoaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $azpiatalap \AppBundle\Entity\Azpiatalaparrafoa * */
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
            case "ordena":
                $azpiatalap->setOrdena($value);
                break;
        }

        $em->persist($azpiatalap);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

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
        $response->setData(
            array(
                'resul' => "OK",
            )
        );

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

//            $ordenantzas = $em->getRepository( 'AppBundle:Ordenantza' )->findBy( array (), array ( 'kodea' => 'ASC' ) );
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->getGuztiak();

        return $this->render(
            'ordenantza/index.html.twig',
            array(
                'ordenantzas' => $ordenantzas,
            )
        );
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

        return $this->render(
            'ordenantza/new.html.twig',
            array(
                'ordenantza' => $ordenantza,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/{id}/erakutsi", name="admin_ordenantza_show")
     * @Method("GET")
     * @param Ordenantza $ordenantza
     *
     * @return Response
     */
    public function showAction(Ordenantza $ordenantza)
    {
        $deleteForm = $this->createDeleteForm($ordenantza);
        $deleteForms = array();
        foreach ($ordenantza->getParrafoak() as $p) {
            $deleteForms[$p->getId()] = $this->createFormBuilder()
                ->setAction(
                    $this->generateUrl('admin_ordenantzaparrafoa_delete', array('id' => $p->getId()))
                )
                ->setMethod('DELETE')
                ->getForm()->createView();
        }

        return $this->render(
            'ordenantza/show.html.twig',
            array(
                'ordenantza' => $ordenantza,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/pdf/show/{id}", name="admin_ordenantza_show_pdf")
     * @Method("GET")
     */
    public function showpdfAction(Ordenantza $ordenantza)
    {

        $mihtml = $this->render('ordenantza/pdf.html.twig', array('ordenantza' => $ordenantza));


        $pdf = $this->get("white_october.tcpdf")->create(
            'vertical',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor($this->getUser()->getUdala());
        $pdf->SetTitle(($ordenantza->getIzenburuaeu()));
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->AddPage();
        $path = $this->get('kernel')->getRootDir() . '/../web/doc/';
        $filename = $this->getFilename($this->getUser()->getUdala()->getKodea(), $ordenantza->getKodea());
        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $mihtml->getContent(),
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );
        $pdf->Output($filename . ".pdf", 'I'); // This will output the PDF as a response directly
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/pdf/export/", name="admin_ordenantza_export_pdf")
     * @Method("GET")
     */
    public function exportpdfAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAll();

        $pdf = $this->get("white_october.tcpdf")->create(
            'vertical',
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        $pdf->SetAuthor($this->getUser()->getUdala());
        $pdf->SetTitle($this->getUser()->getUdala() . "-Zerga Ordenantzak");

        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->setHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

        $pdf->AddPage();

        $eguna = date("Y-m-d_His");
        $filename = $this->getFilename($this->getUser()->getUdala()->getKodea(), "ZergaOrdenantzak-" . $eguna);
        $azala = $this->render(
            'ordenantza/azala.html.twig',
            array('eguna' => date("Y"), 'udala' => $this->getUser()->getUdala())
        );
        $pdf->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $azala->getContent(),
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = '',
            $autopadding = true
        );
        $pdf->AddPage();

        foreach ($ordenantzas as $ordenantza) {
            $mihtml = $this->render('ordenantza/pdf.html.twig', array('ordenantza' => $ordenantza));
            $pdf->writeHTMLCell(
                $w = 0,
                $h = 0,
                $x = '',
                $y = '',
                $mihtml->getContent(),
                $border = 0,
                $ln = 1,
                $fill = 0,
                $reseth = true,
                $align = '',
                $autopadding = true
            );
            $pdf->AddPage();
        }

        $pdf->Output($filename . ".pdf", 'F'); // This will output the PDF as a response directly

        $em = $this->getDoctrine()->getManager();
        $historikoa = new Historikoa();
        $historikoa->setCreatedAt(new \DateTime());
        $historikoa->setUpdatedAt(new \DateTime());
        $historikoa->setUdala($this->getUser()->getUdala());
        $historikoa->setFitxategia("ZergaOrdenantzak-" . $eguna . ".pdf");

        $em->persist($historikoa);
        $em->flush();

        return $this->redirectToRoute(
            'admin_historikoa_edit',
            array(
                'id' => $historikoa->getId(),
            )
        );
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
        $deleteForms = array();

        foreach ($ordenantza->getParrafoak() as $p) {
            $deleteForms[$p->getId()] = $this->createFormBuilder()
                ->setAction(
                    $this->generateUrl('admin_ordenantzaparrafoa_delete', array('id' => $p->getId()))
                )
                ->setMethod('DELETE')
                ->getForm()->createView();
        }

        return $this->render(
            'ordenantza/edit.html.twig',
            array(
                'ordenantza' => $ordenantza,
                'delete_form' => $deleteForm->createView(),
            )
        );
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

            $string = (string)$form->getErrors(true, false);
            //dump( $form->getErrors( true, false ) );
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
            ->getForm();
    }

    private function getFilename($udala, $ordenantzaKodea)
    {
        $fs = new Filesystem();

        $base = $this->get('kernel')->getRootDir() . '/../web/doc/';

        try {
            if ($fs->exists($base . $udala) == false) {
                $fs->mkdir($udala, 0755);
            }
        } catch (IOExceptionInterface $e) {
            echo "Arazoa bat egon da karpeta sortzerakoan " . $e->getPath();
        }

        return $base . $udala . "/" . $ordenantzaKodea;

    }

    /**
     * @Route("/html", name="admin_ordenantza_html")
     * @Method("GET")
     */
    public function htmlAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAllOrderByKodea();

        $nireordenantza = $this->render(
            'ordenantza/web.html.twig',
            array(
                'ordenantzas' => $ordenantzas,
                'eguna' => date("Y"),
                'udala' => $this->getUser()->getUdala(),
            )
        );

        $filename = "doc/ZergaOrdentza-bi" . date("Y_m_d_His") . ".odt";

        file_put_contents($filename, $nireordenantza->getContent());

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;

    }

    /**
     * @Route("/htmles", name="admin_ordenantza_html_es")
     * @Method("GET")
     */
    public function htmlActionEs()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAllOrderByKodea();

//        $nireordenantza = $this->render(
        return $this->render(
            'ordenantza/webes.html.twig',
            array(
                'ordenantzas' => $ordenantzas,
                'eguna' => date("Y"),
                'udala' => $this->getUser()->getUdala(),
            )
        );

        $filename = "doc/ZergaOrdentza-es_" . date("Y_m_d_His") . ".odt";

        file_put_contents($filename, $nireordenantza->getContent());

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;

    }

    /**
     * @Route("/htmleu", name="admin_ordenantza_html_eu")
     * @Method("GET")
     */
    public function htmlActionEu()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAllOrderByKodea();

        $nireordenantza = $this->render(
//        return $this->render(
            'ordenantza/webeu.html.twig',
            array(
                'ordenantzas' => $ordenantzas,
                'eguna' => date("Y"),
                'udala' => $this->getUser()->getUdala(),
            )
        );

        $filename = "doc/ZergaOrdentza-eu_" . date("Y_m_d_His") . ".odt";


        file_put_contents($filename, $nireordenantza->getContent());

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;

    }

    private function baseDoc($lang='eu', $prod=0)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAllOrderByKodea();
        /** @var User $user */
        $user = $this->getUser();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

        $phpWordConfig = $phpWord->getDocInfo();
        $phpWordConfig->setCreator($user->getUsername());
        $phpWordConfig->setCompany($user->getUdala());
        $phpWordConfig->setTitle($user->getUdala() . ": Zerga Ordenantzak." );
        $phpWordConfig->setLastModifiedBy($user->getUsername());
        $phpWordConfig->setCreated(time());
        $phpWordConfig->setModified(time());
        $phpWordConfig->setSubject("Zerga Ordenantzak");
        $phpWordConfig->setKeywords("zerga ordenantzak, ordenanzas fiscales");

        $languageEs = new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::ES_ES);
        $phpWord->getSettings()->setThemeFontLang($languageEs);

        $phpWord->addTitleStyle(1, ['bold' => true], ['spaceAfter' => 240]);
        $phpWord->addTitleStyle(2, ['bold' => true], ['spaceAfter' => 180]);
        $phpWord->addTitleStyle(3, ['bold' => true], ['spaceAfter' => 140]);
        $phpWord->addTitleStyle(4, ['bold' => true], ['spaceAfter' => 140, 'spaceBefore' => 140]);

        foreach ($ordenantzas as $ordenantza) {
            $section = $phpWord->addSection();
            if ($lang === "es") {
                if ($prod === 1) {
                    $titulua =  $ordenantza->getKodeaProd() . " " . $ordenantza->getIzenburuaesProd();
                } else {
                    $titulua =  $ordenantza->getKodea() . " " . $ordenantza->getIzenburuaes();
                }
            } else {
                if ($prod === 1) {
                    $titulua =  $ordenantza->getKodeaProd() . " " . $ordenantza->getIzenburuaeuProd();
                } else {
                    $titulua =  $ordenantza->getKodea() . " " . $ordenantza->getIzenburuaeu();
                }
            }
            $section->addTitle($titulua, 2);

            $debugCounterp = -1;
            /** @var Ordenantzaparrafoa $parrafoa */
            foreach ($ordenantza->getParrafoak() as $parrafoa) {
                $debugCounterp++;
//                if ($debugCounterp > 5) { continue; }
                if ( (int)$ordenantza->getId() > 0) {
                    if ( $parrafoa->getEzabatu() !== true ) {
                        if ($lang === "es") {
                            if ($prod === 1) {
                                $cleanHTML = $this->getCleanHTML($parrafoa->getTestuaesProd());
                            } else {
                                $cleanHTML = $this->getCleanHTML($parrafoa->getTestuaes());
                            }
                        } else {
                            if ($prod===1) {
                                $cleanHTML = $this->getCleanHTML($parrafoa->getTestuaeuProd());
                            } else {
                                $cleanHTML = $this->getCleanHTML($parrafoa->getTestuaeu());
                            }
                        }

                        /**********************************************************************************/
                        Html::addHtml($section, $cleanHTML);
                        $section->addTextBreak(1);
                        /**********************************************************************************/
                    }
                }

            }
            $debugCounter = 0;
            $debugCounterA = -1;
            /** @var Atala $atala */
            foreach ($ordenantza->getAtalak() as $atala) {
                $debugCounterA++;
                if ($debugCounterA > 0 ) { continue; }
                // DEBUG if ( (int)$atala->getId() === 2064) {
                    if ($atala->getEzabatu() !== true) {
                        if ($atala->getUtsa() !== true) {
                            if ($lang === "es") {
                                if ($prod === 1) {
                                    if ($atala->getIzenburuaesProd() !== "") {
                                        $html = "<h3>" . $atala->getOrdenantza()->getKodeaProd() . '.' . $atala->getKodeaProd() . '.-' . $atala->getIzenburuaesProd() . "</h3>";
                                        /**********************************************************************************/
                                        $cleanHTML = $this->getCleanHTML($html);
                                        Html::addHtml($section, $html);
                                        /**********************************************************************************/
                                    }
                                } else {
                                    if ($atala->getIzenburuaes() !== "") {
                                        $html = "<h3>" . $atala->getOrdenantza()->getKodea() . '.' . $atala->getKodea() . '.-' . $atala->getIzenburuaes() . "</h3>";
                                        /**********************************************************************************/
                                        $cleanHTML = $this->getCleanHTML($html);
                                        Html::addHtml($section, $cleanHTML);
                                        /**********************************************************************************/
                                    }
                                }
                            }
                            if ($lang === "eu") {
                                if ($prod === 1) {
                                    if ($atala->getIzenburuaeuProd() !== "") {
                                        $html = "<h3>" . $atala->getOrdenantza()->getKodea() . '.' . $atala->getKodea() . '.-' . $atala->getIzenburuaeu() . "</h3>";
                                        /**********************************************************************************/
                                        $cleanHTML = $this->getCleanHTML($html);
                                        Html::addHtml($section, $cleanHTML);
                                        /**********************************************************************************/
                                    }
                                } else {
                                    if ($atala->getIzenburuaeu() !== "") {
                                        $html = "<h3>" . $atala->getOrdenantza()->getKodea() . '.' . $atala->getKodea() . '.-' . $atala->getIzenburuaeu() . "</h3>";
                                        /**********************************************************************************/
                                        $cleanHTML = $this->getCleanHTML($html);
                                        Html::addHtml($section, $cleanHTML);
                                        /**********************************************************************************/
                                    }
                                }
                            }

                            /** @var Atalaparrafoa $atalaparraofoa */
                            foreach ($atala->getParrafoak() as $atalaparraofoa) {
                                if ($atalaparraofoa->getEzabatu() !== true) {
                                    if ($lang === "es") {
                                        if ($prod === 1) {
                                            $html = $atalaparraofoa->getTestuaesProd();
                                            $html = $this->getCleanHTML($html);
                                        } else {
                                            $html = $atalaparraofoa->getTestuaes();
                                            $html = $this->getCleanHTML($html);
                                        }
                                    } else {
                                        if ($prod === 1) {
                                            $html = $atalaparraofoa->getTestuaeuProd();
                                            $html = $this->getCleanHTML($html);
                                        } else {
                                            $html = $atalaparraofoa->getTestuaeu();
                                            $html = $this->getCleanHTML($html);
                                        }
                                    }
                                    /**********************************************************************************/
                                    $cleanHTML = $this->getCleanHTML($html);
                                    Html::addHtml($section, $cleanHTML);
                                    /**********************************************************************************/
                                }
                            }
                        }
                    }

                    /** @var Azpiatala $azpiatala */
                    foreach ($atala->getAzpiatalak() as $azpiatala) {
                        // DEBUG if ( (int)$azpiatala->getId() === 3534) { // if debug
                            if ($azpiatala->getEzabatu() !== true) {
                                if ($lang === "es") {
                                    if ($prod === 1) {
                                        $html = $azpiatala->getKodeaProd() . '. ' . $azpiatala->getIzenburuaesProd();
                                    } else {
                                        $html = $azpiatala->getKodea() . '. ' . $azpiatala->getIzenburuaes();
                                    }
                                } else if ($prod === 1) {
                                    $html = $azpiatala->getKodeaProd() . '. ' . $azpiatala->getIzenburuaeuProd();
                                } else {
                                    $html = $azpiatala->getKodea() . '. ' . $azpiatala->getIzenburuaeu();
                                }

                                $cleanHTML = $this->getCleanHTML($html);
                                $cleanHTML = str_replace('<br />', '', $cleanHTML);
                                /**********************************************************************************/
                                $section->addTitle($cleanHTML, 4);
                                /**********************************************************************************/

                                if ($azpiatala->getId() === "352") { // debug
                                    /** @var Azpiatalaparrafoa $azpiatalaparrafoa */
                                    foreach ($azpiatala->getParrafoak() as $azpiatalaparrafoa) {
                                        if ($azpiatalaparrafoa->getEzabatu() !== true) {
                                            if ($lang === "es") {
                                                if ($prod === 1) {
                                                    $html = $azpiatalaparrafoa->getTestuaesProd();
                                                } else {
                                                    $html = $azpiatalaparrafoa->getTestuaes();
                                                }
                                            } else {
                                                if ($prod === 1) {
                                                    $html = $azpiatalaparrafoa->getTestuaeuProd();
                                                } else {
                                                    $html = $azpiatalaparrafoa->getTestuaeu();
                                                }
                                            }
                                            /**********************************************************************************/
                                            $cleanHTML = $this->getCleanHTML($html);
                                            Html::addHtml($section, $cleanHTML);
                                            /**********************************************************************************/
                                        }
                                    }
                                } // debug


                                $html = '<table style="border: 1px solid black;border-collapse: collapse;">';

                                $loopindex = 0;
                                $oldUnitatea = '';

                                /** @var Kontzeptua $k */
                                foreach ($azpiatala->getKontzeptuak() as $k) {
                                    if ($k->getEzabatu() !== true) {
                                        if ($loopindex === 0) {
                                            $html .= "<tr>";
                                            $html .= '<td></td>';
                                            $html .= '<td style="padding: 0 0.2cm 0.2cm;">';
                                            $html .= '<p style="text-align: right;">' . htmlspecialchars($k->getUnitatea()) . '</p>';
                                            $html .= '</td>';
                                            $html .= '</tr>';
                                            $oldUnitatea = $k->getUnitatea();
                                        } elseif ($k->getUnitatea() !== $oldUnitatea) {
                                            $html .= "<tr>";
                                            $html .= '<td></td>';
                                            $html .= '<td style="padding: 0 0.2cm 0.2cm;">';
                                            $html .= '<p style="text-align: right;">' . htmlspecialchars($k->getUnitatea()) . '</p>';
                                            $html .= '</td>';
                                            $html .= '</tr>';
                                            $oldUnitatea = $k->getUnitatea();
                                        }
                                        ++$loopindex;

                                        $html .= '<tr>';
                                        $html .= '<td style="padding: 0 0.2cm 0.2cm;">';
                                        if ($lang === "es") {
                                            $html .= '<p style="text-align: left;">' . htmlspecialchars($k->getKontzeptuaes());
                                            if (!empty($k->getBaldintza())) {
                                                $baldintzaes = str_replace(['<br>', '<span>', '</span>', '&nbsp;'], ['', '', '', ' '], $k->getBaldintza()->getBaldintzaes());
                                                $html .= ' (' . htmlspecialchars($baldintzaes) . ')';
                                            }
                                        } else {
                                            $html .= '<p style="text-align: left;">' . htmlspecialchars($k->getKontzeptuaeu());
                                            if (!empty($k->getBaldintza())) {
                                                $baldintzaeu = str_replace(['<br>', '<span>', '</span>', '&nbsp;'], ['', '', '', ' '], $k->getBaldintza()->getBaldintzaeu());
                                                $html .= ' (' . htmlspecialchars($baldintzaeu) . ')';
                                            }
                                        }
                                        $html .= '</p></td>';
                                        $html .= '<td style="padding: 0 0.2cm 0.2cm;">';
                                        $html .= '<p style="text-align: right">' . htmlspecialchars($k->getKopurua()) . '</p>';
                                        $html .= '</td></tr>';
                                    }
                                }
                                $html .= '</table>';

                                /**********************************************************************************/
                                Html::addHtml($section, $html);
                                $section->addTextBreak(2);
                                /**********************************************************************************/


                                /** @var Azpiatalaparrafoaondoren $azpiatalaparrafoaondoren */
                                foreach ($azpiatala->getParrafoakondoren() as $azpiatalaparrafoaondoren) {
                                    if ($azpiatalaparrafoaondoren->getEzabatu() !== true) {
                                        if ($lang === "es") {
                                            if ($prod === 1) {
                                                $html = $azpiatalaparrafoaondoren->getTestuaesProd();
                                            } else {
                                                $html = $azpiatalaparrafoaondoren->getTestuaes();
                                            }
                                        } else {
                                            if ($prod === 1) {
                                                $html = $azpiatalaparrafoaondoren->getTestuaeuProd();
                                            } else {
                                                $html = $azpiatalaparrafoaondoren->getTestuaeu();
                                            }
                                        }
                                        /**********************************************************************************/
                                        $cleanHTML = $this->getCleanHTML($html);
                                        Html::addHtml($section, $cleanHTML);
                                        /**********************************************************************************/
                                    }
                                }
                            }
                        // } // if debug
                    }
//                } //if debug
            }
        }

        $this->get('logger')->warn('--------------------------');
        $this->get('logger')->warn('phpWord Ordenantza sortua.');
        $this->get('logger')->warn('--------------------------');
        return $phpWord;
    }

    /**
     * @Route("/fitxategia/{lang}/{prod}/{type}", name="admin_fitxategia")
     * @Method("GET")
     * @throws Exception
     */
    public function fitxategiaAction($lang = 'eu', $prod = "0", $type = 'odt' )
    {
        $allowedLangs = ['es', 'eu'];
        if (!in_array($lang, $allowedLangs, true)) {
            throw new InvalidArgumentException("$lang ez da baliozko hizkuntza. Soilik 'es' eta 'eu' onartzen dira.");
        }

        $allowedTypes = ['odt', 'docx'];
        if (!in_array($type, $allowedTypes, true)) {
            throw new InvalidArgumentException("$type ez da onartutako formatua. Soilik 'odt' eta 'docx' onartzen dira.");
        }

        $phpWord = $this->baseDoc($lang, $prod);

        if ($prod === "1") {
            $filename = "ZergaOrdentza-" . $lang .'-prod-' . date("Y_m_d_His") . '.' . $type;
        } else {
            $filename = "ZergaOrdentza-" . $lang .'-' . date("Y_m_d_His") . '.' . $type;
        }

        // Zerbitzarian gorde
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        // $objWriter->save("doc/".$filename);

        // DOWNLOAD
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        if ($type === 'odt') {
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        } else {
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        }
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/odteu", name="admin_ordenantza_odt_eu")
     * @Method("GET")
     * @throws Exception
     */
    public function odtActionEu()
    {
        $phpWord = $this->baseDoc('eu', 0);
        $filename = "ZergaOrdentza-eu_" . date("Y_m_d_His") . ".odt";

        // Zerbitzarian gorde
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        // $objWriter->save("doc/".$filename);

        // DOWNLOAD
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/odteuprod", name="admin_ordenantza_odt_eu_prod")
     * @Method("GET")
     * @throws Exception
     */
    public function odtActionEuProd()
    {
        $phpWord = $this->baseDoc('eu', 1);
        $filename = "ZergaOrdentza-eu_prod_" . date("Y_m_d_His") . ".odt";

        // Saving the document as ODF file...
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        // $objWriter->save("doc/".$filename);

        // DOWNLOAD
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/docxeu", name="admin_ordenantza_docx_eu")
     * @Method("GET")
     * @throws Exception
     */
    public function docxActionEu()
    {
        $phpWord = $this->baseDoc('eu', 0);
        $filename = "ZergaOrdentza-eu_" . date("Y_m_d_His") . ".docx";

        // Zerbitzarian gorde
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save("doc/".$filename);

        // DOWNLOAD
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/odteuprod", name="admin_ordenantza_docx_eu_prod")
     * @Method("GET")
     * @throws Exception
     */
    public function docxActionEuProd()
    {
        $phpWord = $this->baseDoc('eu', 1);
        $filename = "ZergaOrdentza-eu_prod_" . date("Y_m_d_His") . ".docx";

        // Zerbitzarian gorde
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save("doc/".$filename);

        // DOWNLOAD
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/esportatu/{id}", name="admin_ordenantza_esportatu")
     * @Method("GET")
     */
    public function esportatuAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantza = $em->getRepository('AppBundle:Ordenantza')->find($id);

        $nireordenantza = $this->render(
            'ordenantza/esportatu.html.twig',
            array(
                'ordenantza' => $ordenantza,
            )
        );

        $filename = "doc/export_" . date("Y_m_d_His") . ".odt";

        file_put_contents($filename, $nireordenantza->getContent());

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;

    }

    /**
     * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_ordenantza_ezabatu")
     * @Method("GET")
     */
    public function ezabatuAction(Ordenantza $ordenantza)
    {

        $deleteForm = $this->createDeleteForm($ordenantza);

        return $this->render(
            'ordenantza/_ordenantza_delete_form.html.twig',
            array(
                'delete_form' => $deleteForm->createView(),
                'id' => $ordenantza->getId(),
            )
        );
    }

    /**
     * @param $cleanHTML
     * @return string
     */
    public function getCleanHTML($cleanHTML)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
        $purifier = new HTMLPurifier($config);
        $cleanHTML = $purifier->purify($cleanHTML);

        $cleanHTML = str_replace("\t", "", $cleanHTML);
        $cleanHTML = str_replace("<a></a>", "", $cleanHTML);

        /******* BERRIA ******/
        $cleanHTML = str_replace(["\r\n", "\n", "\r"], '', $cleanHTML);
        $cleanHTML = preg_replace('/(<li.*?>.*?)(<ul>.*?<\/ul>)\s?(<\/li>)/i', '$1$3$2', $cleanHTML);

        $cleanHTML = str_replace("<br><br>", "<br/>", $cleanHTML);
        //$cleanHTML = str_replace("&lt;", "<", $cleanHTML);
        // $cleanHTML = str_replace("&nbsp;", "", $cleanHTML);
        $allowed_tags = '<a><b><i><u><em><strong><p><br><ul><ol><li>';
        $cleanHTML = strip_tags($cleanHTML, $allowed_tags);
        $cleanHTML = str_replace("<br>", "<br/>", $cleanHTML);
        //$cleanHTML = str_replace("&", "&amp;", $cleanHTML);

        // a etiketak ez badute href, kendu
        $pattern = '/<a(?!\s*href).*?>.*?<\/a>/i';
        $cleanHTML = preg_replace($pattern, '', $cleanHTML);

        return $cleanHTML;
    }

    private function getStringFromHtml($html)
    {
        // Crea una nueva instancia de DOMDocument
        $dom = new \DOMDocument();

        // Suprime los errores al cargar HTML mal formado
        libxml_use_internal_errors(true);

        // Carga el HTML en el objeto DOMDocument
        $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);

        // Limpia los errores de libxml
        libxml_clear_errors();

        // Obtiene el texto de todos los nodos del documento
        $text = $dom->textContent;

        // Elimina espacios en blanco redundantes y retorna el texto limpio
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    private function formatTitulo($titulo) {
        $titulo = mb_strtolower($titulo, 'UTF-8');
        $frases = explode('. ', $titulo);
        foreach ($frases as &$frase) {
            $frase = preg_replace_callback('/(^[\d\W]*)(\w)(.*)/u', function($matches) {
                return $matches[1] . mb_strtoupper($matches[2], 'UTF-8') . $matches[3];
            }, $frase);
        }
        return implode('. ', $frases);
    }

}
