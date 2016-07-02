<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Atala;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Entity\Azpiatala;
use AppBundle\Entity\Azpiatalaparrafoa;
use AppBundle\Entity\Kontzeptua;
use AppBundle\Entity\Ordenantzaparrafoa;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ordenantza;
use AppBundle\Form\OrdenantzaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     *
     * @Route("/ordenantza", name="homepage")
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
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/admin/exportatu/{id}", name="exportatu")
     * @Method("GET")º
     */
    public function exportatuAction(Ordenantza $ordenantza)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $filename = "zzoo";

        $table1 = $section->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));

        $table1->addRow(3750);
        $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
        $cell1->addText($ordenantza->getKodea() . " " . $ordenantza->getIzenburuaeu());

        $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
        $cell2->addText($ordenantza->getKodea() . " " . $ordenantza->getIzenburuaes());

        foreach ($ordenantza->getParrafoak() as $parrafoa) {
            $table1->addRow(3750);
            $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
            $cell1->addText($parrafoa->getTestuaeu());

            $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
            $cell2->addText($parrafoa->getTestuaes());
        }

        foreach ($ordenantza->getAtalak() as $atala) {
            $table1->addRow(3750);
            $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
            $cell1->addText($atala->getKodea() . " " . $atala->getIzenburuaeu());

            $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
            $cell2->addText($atala->getKodea() . " " . $atala->getIzenburuaes());

            foreach ($atala->getParrafoak() as $atalaparrafoa) {
                $table1->addRow(3750);
                $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                $cell1->addText($atalaparrafoa->getTestuaeu());

                $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                $cell2->addText($atalaparrafoa->getTestuaes());
            }

            foreach ( $atala->getAzpiatalak() as $azpiatala  ) {
                $table1->addRow(3750);
                $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                $cell1->addText($azpiatala->getKodea() . " " . $azpiatala->getIzenburuaeu());

                $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                $cell2->addText($azpiatala->getKodea() . " " . $azpiatala->getIzenburuaes());

                foreach ($azpiatala->getParrafoak() as $azpiatalaparrafoa){
                    $table1->addRow(3750);
                    $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                    $cell1->addText($azpiatalaparrafoa->getTestuaeu());

                    $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                    $cell2->addText($azpiatalaparrafoa->getTestuaeu());
                }

                foreach ($azpiatala->getKontzeptuak() as $kontzeptua) {
                    $table1->addRow(3750);
                    $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                    $cell1->addText($kontzeptua->getKontzeptuaeu());

                    $cell2 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 0, 'borderColor' => 'ffffff'));
                    $cell2->addText($kontzeptua->getKontzeptuaes());

                }

            }

        }







        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Pasaiako Udala');
        $properties->setCompany('Pasaiako Udala');
        $properties->setTitle($filename);
        $properties->setDescription();
        $properties->setCategory('Zerga Ordenantzak');
        $properties->setLastModifiedBy('My name');
        $properties->setKeywords('zerga ordenantzak');

        // Saving the document as ODF file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('doc/' . $filename . '.odt');

        // Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('doc/' . $filename . '.html');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('doc/' . $filename . '.docx');

        // Saving the document as PDF file...
        $domPdfPath = realpath(__DIR__ . '/../../../vendor/tecnickcom/tcpdf');

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('TCPDF');
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('doc/' . $filename . '.docx');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        $xmlWriter->save('doc/' . $filename . '.pdf');


        
        
        
        return new Response("<a href=\"http://zergaordenantzak.dev/doc/helloWorld.odt\">hemen</a>");

    }


    /**
     *
     * @Route("/changelanguage", defaults={"_locale" = "eu"}, name="changelanguage")
     * @Method("GET")
     */
    public function hizkuntzaAction(Request $request) {


        $locale = $request->getLocale();
        if ($locale == "eu") {
            $request->setLocale('es');
            $request->getSession()->set('_locale', 'es');
        } else {
            $request->setLocale('eu');
            $request->getSession()->set('_locale', 'eu');
        }

        return $this->redirect($request->headers->get('referer'));

    }

    function xmlEntities($str)
    {
        $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
        $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
        $str = str_replace($html, $xml, $str);
        $str = str_ireplace($html, $xml, $str);
        return $str;
    }
}
