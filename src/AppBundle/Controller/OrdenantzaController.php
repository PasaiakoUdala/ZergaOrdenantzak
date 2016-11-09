<?php

    namespace AppBundle\Controller;

    use AppBundle\Entity\Historikoa;
    use AppBundle\Entity\Kontzeptua;
    use AppBundle\Entity\Ordenantzaparrafoa;
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
        public function eguneratuAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $ordenantza = $em->getRepository( 'AppBundle:Ordenantza' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "izenburuaeu":
                    $ordenantza->setIzenburuaeu( $value );
                    break;
                case "izenburuaes":
                    $ordenantza->setIzenburuaes( $value );
                    break;
                case "testuaeu":
                    $ordenantza->setTestuaeu( $value );
                    break;
                case "testuaes":
                    $ordenantza->setTestuaes( $value );
                    break;
            }

            $em->persist( $ordenantza );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuparrafoa/{id}", name="admin_ordenantza_parrafoak_eguneratu")
         * @Method("POST")
         */
        public function eguneratuparrafoakAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $ordenantzaparrafoa = $em->getRepository( 'AppBundle:Ordenantzaparrafoa' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "testuaeu":
                    $ordenantzaparrafoa->setTestuaeu( $value );
                    break;
                case "testuaes":
                    $ordenantzaparrafoa->setTestuaes( $value );
                    break;
            }

            $em->persist( $ordenantzaparrafoa );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuatala/{id}", name="admin_ordenantza_atala_eguneratu")
         * @Method("POST")
         */
        public function eguneratuatalaAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $atala = $em->getRepository( 'AppBundle:Atala' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "kodea":
                    $atala->setKodea( $value );
                    break;
                case "izenburuaeu":
                    $atala->setIzenburuaeu( $value );
                    break;
                case "izenburuaes":
                    $atala->setIzenburuaes( $value );
                    break;
            }

            $em->persist( $atala );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuatalaparrafoa/{id}", name="admin_ordenantza_atalaparrafoa_eguneratu")
         * @Method("POST")
         */
        public function eguneratuatalaparrafoaAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $atalap = $em->getRepository( 'AppBundle:Atalaparrafoa' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "testuaeu":
                    $atalap->setTestuaeu( $value );
                    break;
                case "testuaes":
                    $atalap->setTestuaes( $value );
                    break;
            }

            $em->persist( $atalap );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuazpiatala/{id}", name="admin_ordenantza_azpiatala_eguneratu")
         * @Method("POST")
         */
        public function eguneratuazpiatalaAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $azpiatala = $em->getRepository( 'AppBundle:Azpiatala' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "izenburuaeu":
                    $azpiatala->setIzenburuaeu( $value );
                    break;
                case "izenburuaes":
                    $azpiatala->setIzenburuaes( $value );
                    break;
            }

            $em->persist( $azpiatala );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuazpiatalaparrafoa/{id}", name="admin_ordenantza_azpiatalaparrafoa_eguneratu")
         * @Method("POST")
         */
        public function eguneratuazpiatalaparrafoaAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $azpiatalap = $em->getRepository( 'AppBundle:Azpiatalaparrafoa' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "testuaeu":
                    $azpiatalap->setTestuaeu( $value );
                    break;
                case "testuaes":
                    $azpiatalap->setTestuaes( $value );
                    break;
            }

            $em->persist( $azpiatalap );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
                    'resul' => "OK",
                )
            );

            return $response;
        }

        /**
         * @Route("/eguneratuazpiatalakontzeptuoa/{id}", name="admin_ordenantza_azpiatalakontzeptua_eguneratu")
         * @Method("POST")
         */
        public function eguneratuazpiatalakontzeptuaAction ( Request $request, $id )
        {
            $em = $this->getDoctrine()->getManager();
            $azpiatalap = $em->getRepository( 'AppBundle:Kontzeptua' )->findOneById( $id );
            $name = $request->request->get( 'name' );
            $value = $request->request->get( 'value' );


            switch ( $name ) {
                case "kontzeptuaeu":
                    $azpiatalap->setKontzeptuaeu( $value );
                    break;
                case "kontzeptuaes":
                    $azpiatalap->setKontzeptuaes( $value );
                    break;
                case "kopurua":
                    $azpiatalap->setKopurua( $value );
                    break;
                case "kontzeptuaes":
                    $azpiatalap->setUnitatea( $value );
                    break;

            }

            $em->persist( $azpiatalap );
            $em->flush();
            $response = new JsonResponse();
            $response->setData(
                array (
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
        public function indexAction ()
        {
            $em = $this->getDoctrine()->getManager();

            $ordenantzas = $em->getRepository( 'AppBundle:Ordenantza' )->findAll();

            return $this->render(
                'ordenantza/index.html.twig',
                array (
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
        public function newAction ( Request $request )
        {
            $ordenantza = new Ordenantza();
            $form = $this->createForm( 'AppBundle\Form\OrdenantzaType', $ordenantza );
            $form->getData()->setUdala( $this->getUser()->getUdala() );
            $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
                $em = $this->getDoctrine()->getManager();
                $em->persist( $ordenantza );
                $em->flush();

                return $this->redirectToRoute( 'admin_ordenantza_show', array ( 'id' => $ordenantza->getId() ) );
            }

            return $this->render(
                'ordenantza/new.html.twig',
                array (
                    'ordenantza' => $ordenantza,
                    'form'       => $form->createView(),
                )
            );
        }

        /**
         * Finds and displays a Ordenantza entity.
         *
         * @Route("/{id}/erakutsi", name="admin_ordenantza_show")
         * @Method("GET")
         */
        public function showAction ( Ordenantza $ordenantza )
        {
            $deleteForm = $this->createDeleteForm( $ordenantza );
            $deleteForms = array ();
            foreach ( $ordenantza->getParrafoak() as $p ) {
                $deleteForms[ $p->getId() ] = $this->createFormBuilder()
                    ->setAction(
                        $this->generateUrl( 'admin_ordenantzaparrafoa_delete', array ( 'id' => $p->getId() ) )
                    )
                    ->setMethod( 'DELETE' )
                    ->getForm()->createView();
            }

            return $this->render(
                'ordenantza/show.html.twig',
                array (
                    'ordenantza'  => $ordenantza,
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
        public function showpdfAction ( Ordenantza $ordenantza )
        {

            $mihtml = $this->render( 'ordenantza/pdf.html.twig', array ( 'ordenantza' => $ordenantza ) );


            $pdf = $this->get( "white_october.tcpdf" )->create(
                'vertical',
                PDF_UNIT,
                PDF_PAGE_FORMAT,
                true,
                'UTF-8',
                false
            );
            $pdf->SetAuthor( $this->getUser()->getUdala() );
            $pdf->SetTitle( ($ordenantza->getIzenburuaeu()) );
            $pdf->setFontSubsetting( true );
            $pdf->SetFont( 'helvetica', '', 11, '', true );

            $pdf->AddPage();
            $path = $this->get( 'kernel' )->getRootDir().'/../web/doc/';
            $filename = $this->getFilename( $this->getUser()->getUdala()->getKodea(), $ordenantza->getKodea() );
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
            $pdf->Output( $filename.".pdf", 'I' ); // This will output the PDF as a response directly
        }

        /**
         * Finds and displays a Ordenantza entity.
         *
         * @Route("/pdf/export/", name="admin_ordenantza_export_pdf")
         * @Method("GET")
         */
        public function exportpdfAction ()
        {
            $em = $this->getDoctrine()->getManager();
            $ordenantzas = $em->getRepository( 'AppBundle:Ordenantza' )->findAll();

            $pdf = $this->get( "white_october.tcpdf" )->create(
                'vertical',
                PDF_UNIT,
                PDF_PAGE_FORMAT,
                true,
                'UTF-8',
                false
            );
            $pdf->SetAuthor( $this->getUser()->getUdala() );
            $pdf->SetTitle( $this->getUser()->getUdala()."-Zerga Ordenantzak" );

            $pdf->setFontSubsetting( true );
            $pdf->SetFont( 'helvetica', '', 11, '', true );

            $pdf->setHeaderData( '', 0, '', '', array ( 0, 0, 0 ), array ( 255, 255, 255 ) );

            $pdf->AddPage();

            $eguna = date( "Y-m-d_His" );
            $filename = $this->getFilename( $this->getUser()->getUdala()->getKodea(), "ZergaOrdenantzak-".$eguna );
            $azala = $this->render(
                'ordenantza/azala.html.twig',
                array ( 'eguna' => date( "Y" ), 'udala' => $this->getUser()->getUdala() )
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

            foreach ( $ordenantzas as $ordenantza ) {
                $mihtml = $this->render( 'ordenantza/pdf.html.twig', array ( 'ordenantza' => $ordenantza ) );
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

            $pdf->Output( $filename.".pdf", 'F' ); // This will output the PDF as a response directly

            $em = $this->getDoctrine()->getManager();
            $historikoa = New Historikoa();
            $historikoa->setCreatedAt( New \DateTime() );
            $historikoa->setUpdatedAt( New \DateTime() );
            $historikoa->setUdala( $this->getUser()->getUdala() );
            $historikoa->setFitxategia( "ZergaOrdenantzak-".$eguna.".pdf" );

            $em->persist( $historikoa );
            $em->flush();

            return $this->redirectToRoute(
                'admin_historikoa_edit',
                array (
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
        public function editAction ( Request $request, Ordenantza $ordenantza )
        {
            $deleteForm = $this->createDeleteForm( $ordenantza );
            $deleteForms = array ();

            foreach ( $ordenantza->getParrafoak() as $p ) {
                $deleteForms[ $p->getId() ] = $this->createFormBuilder()
                    ->setAction(
                        $this->generateUrl( 'admin_ordenantzaparrafoa_delete', array ( 'id' => $p->getId() ) )
                    )
                    ->setMethod( 'DELETE' )
                    ->getForm()->createView();
            }

            return $this->render(
                'ordenantza/edit.html.twig',
                array (
                    'ordenantza'  => $ordenantza,
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
        public function deleteAction ( Request $request, Ordenantza $ordenantza )
        {
            $form = $this->createDeleteForm( $ordenantza );
            $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
                $em = $this->getDoctrine()->getManager();
                $em->remove( $ordenantza );
                $em->flush();
            } else {

                $string = (string)$form->getErrors( true, false );
                dump( $form->getErrors( true, false ) );
            }

            return $this->redirectToRoute( 'admin_ordenantza_index' );
        }

        /**
         * Creates a form to delete a Ordenantza entity.
         *
         * @param Ordenantza $ordenantza The Ordenantza entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm ( Ordenantza $ordenantza )
        {
            return $this->createFormBuilder()
                ->setAction( $this->generateUrl( 'admin_ordenantza_delete', array ( 'id' => $ordenantza->getId() ) ) )
                ->setMethod( 'DELETE' )
                ->getForm();
        }

        private function getFilename ( $udala, $ordenantzaKodea )
        {
            $fs = new Filesystem();

            $base = $this->get( 'kernel' )->getRootDir().'/../web/doc/';

            try {
                if ( $fs->exists( $base.$udala ) == false ) {
                    $fs->mkdir( $udala, 0755 );
                }
            } catch ( IOExceptionInterface $e ) {
                echo "Arazoa bat egon da karpeta sortzerakoan ".$e->getPath();
            }

            return $base.$udala."/".$ordenantzaKodea;

        }

        /**
         * @Route("/ezeztatu/{id}", options = { "expose" = true }, name="admin_ordenantza_ezeztatu")
         * @Method("GET")
         */
        public function ezeztatuAction ( Request $request, Ordenantza $ordenantza )
        {
            $em = $this->getDoctrine()->getManager();
            if ( strlen( $ordenantza->getIzenburuaesProd() ) > 0 ) {
                $ordenantza->setIzenburuaes( $ordenantza->getIzenburuaesProd() );
            }
            if ( strlen( $ordenantza->getIzenburuaeuProd() ) > 0 ) {
                $ordenantza->setIzenburuaeu( $ordenantza->getIzenburuaeuProd() );
            }

            /* @var $parrafoa \AppBundle\Entity\Atalaparrafoa */
            foreach ( $ordenantza->getParrafoak() as $parrafoa ) {
                if ( strlen( $parrafoa->getTestuaesProd() ) > 0 ) {
                    $parrafoa->setTestuaes( $parrafoa->getTestuaesProd() );
                }
                if ( strlen( $parrafoa->getTestuaeuProd() ) > 0 ) {
                    $parrafoa->setTestuaeu( $parrafoa->getTestuaeuProd() );
                }
            }

            /* @var $atala \AppBundle\Entity\Atala */
            foreach ( $ordenantza->getAtalak() as $atala ) {

                if ( $atala->getEzabatu() == 1 ) {
                    $em->remove( $atala );
                } else {
                    if ( strlen( $atala->getIzenburuaeuProd() ) > 0 ) {
                        $atala->setIzenburuaeu( $atala->getIzenburuaeuProd() );
                    }
                    if ( strlen( $atala->getIzenburuaesProd() ) > 0 ) {
                        $atala->setIzenburuaes( $atala->getIzenburuaesProd() );
                    }
                    if ( strlen( $atala->getKodeaProd() ) > 0 ) {
                        $atala->setKodea( $atala->getKodeaProd() );
                    }
                    if ( strlen( $atala->getUtsaProd() ) > 0 ) {
                        $atala->setUtsa( $atala->getUtsaProd() );
                    }

                    /* @var $atalaparrafoa \AppBundle\Entity\Atalaparrafoa */
                    foreach ( $atala->getParrafoak() as $atalaparrafoa ) {
                        if ( $atalaparrafoa->getEzabatu() == 1 ) {
                            $em->remove( $atalaparrafoa );
                        } else {
                            if ( strlen( $atalaparrafoa->getTestuaesProd() ) > 0 ) {
                                $atalaparrafoa->setTestuaes( $atalaparrafoa->getTestuaesProd() );
                            }
                            if ( strlen( $atalaparrafoa->getTestuaeuProd() ) > 0 ) {
                                $atalaparrafoa->setTestuaeu( $atalaparrafoa->getTestuaeuProd() );
                            }
                        }
                    }

                    /* @var $azpiatala \AppBundle\Entity\Azpiatala */
                    foreach ( $atala->getAzpiatalak() as $azpiatala ) {
                        if ( $azpiatala->getEzabatu() == 1 ) {
                            $em->remove( $azpiatala );
                        } else {
                            if ( strlen( $azpiatala->getKodeaProd() ) > 0 ) {
                                $azpiatala->setKodea( $azpiatala->getKodeaProd() );
                            }
                            if ( strlen( $azpiatala->getIzenburuaesProd() ) > 0 ) {
                                $azpiatala->setIzenburuaes( $azpiatala->getIzenburuaesProd() );
                            }
                            if ( strlen( $azpiatala->getIzenburuaeuProd() ) > 0 ) {
                                $azpiatala->setIzenburuaeu( $azpiatala->getIzenburuaeuProd() );
                            }

                            /* @var $azpiatalaparrafoa \AppBundle\Entity\Azpiatalaparrafoa */
                            foreach ( $azpiatala->getParrafoak() as $azpiatalaparrafoa ) {
                                if ( $azpiatalaparrafoa->getEzabatu() == 1 ) {
                                    $em->remove( $azpiatalaparrafoa );
                                } else {
                                    if ( strlen( $azpiatalaparrafoa->getTestuaesProd() ) > 0 ) {
                                        $azpiatalaparrafoa->setTestuaes( $azpiatalaparrafoa->getTestuaesProd() );
                                    }
                                    if ( strlen( $azpiatalaparrafoa->getTestuaeuProd() ) > 0 ) {
                                        $azpiatalaparrafoa->setTestuaeu( $azpiatalaparrafoa->getTestuaeuProd() );
                                    }
                                }
                            }

                            /* @var $kontzeptua \AppBundle\Entity\Kontzeptua */
                            foreach ( $azpiatala->getKontzeptuak() as $kontzeptua ) {

                                if ( $kontzeptua->getEzabatu() == 1 ) {
                                    $em->remove( $kontzeptua );
                                } else {

                                    if (strlen($kontzeptua->getKodeaProd())>0){
                                        $kontzeptua->setKodea( $kontzeptua->getKodeaProd() );
                                    }

                                    if (strlen($kontzeptua->getKontzeptuaesProd())>0){
                                        $kontzeptua->setKontzeptuaes( $kontzeptua->getKontzeptuaesProd() );
                                    }
                                    if (strlen($kontzeptua->getKontzeptuaeuProd())>0){
                                        $kontzeptua->setKontzeptuaeu( $kontzeptua->getKontzeptuaeuProd() );
                                    }
                                    if (strlen($kontzeptua->getKontzeptuaeuProd())>0){
                                        $kontzeptua->setKontzeptuaeu( $kontzeptua->getKontzeptuaeuProd() );
                                    }
                                    if (strlen($kontzeptua->getKopuruaProd())>0){
                                        $kontzeptua->setKopurua( $kontzeptua->getKopuruaProd() );
                                    }
                                    if (strlen($kontzeptua->getUnitateaProd())>0){
                                        $kontzeptua->setUnitatea( $kontzeptua->getUnitateaProd() );
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $em->persist( $ordenantza );
            $em->flush();


//        return $this->redirectToRoute( 'admin_ordenantza_edit', array ('id' => $ordenantza->getId()));
            return $this->redirect( $request->headers->get( 'referer' ) );
        }

        /**
         * @Route("/html", name="admin_ordenantza_html")
         * @Method("GET")
         */
        public function htmlAction ()
        {
            $em = $this->getDoctrine()->getManager();
            $ordenantzas = $em->getRepository( 'AppBundle:Ordenantza' )->findAll();

            $nireordenantza = $this->render(
                'ordenantza/web.html.twig',
                array (
                    'ordenantzas' => $ordenantzas,
                )
            );

            $filename = "doc/export_".date( "Y_m_d_His" ).".odt";

            file_put_contents( $filename, $nireordenantza->getContent() );

            // Generate response
            $response = new Response();

            // Set headers
            $response->headers->set( 'Cache-Control', 'private' );
            $response->headers->set( 'Content-type', mime_content_type( $filename ) );
            $response->headers->set( 'Content-Disposition', 'attachment; filename="'.basename( $filename ).'";' );
            $response->headers->set( 'Content-length', filesize( $filename ) );

            // Send headers before outputting anything
            $response->sendHeaders();

            $response->setContent( file_get_contents( $filename ) );

            return $response;

        }

        /**
         * @Route("/ezabatu/{id}", options = { "expose" = true }, name="admin_ordenantza_ezabatu")
         * @Method("GET")
         */
        public function ezabatuAction ( Ordenantza $ordenantza )
        {

            $deleteForm = $this->createDeleteForm( $ordenantza );

            return $this->render(
                'ordenantza/_ordenantza_delete_form.html.twig',
                array (
                    'delete_form' => $deleteForm->createView(),
                    'id'          => $ordenantza->getId(),
                )
            );
        }

    }
