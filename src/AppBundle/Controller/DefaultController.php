<?php

namespace AppBundle\Controller;


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
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/admin/exportatu/{id}", name="exportatu")
     * @Method("GET")
     */
    public function exportatuAction(Ordenantza $ordenantza)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $html = '<html><body><h1>froga</h1><table><tbody>';

        foreach ($ordenantza->getParrafoak() as $par) {

            $html = $html . '<tr><td>';
            $t = str_replace("<br>", "<br />", $par->getTestuaeu());
            $html = $html . $t . '</td>';
//            dump($html);
//            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
            $html = $html . '<td>';
            $t = str_replace("<br>", "<br />", $par->getTestuaes());
            $html = $html . $t . '</td></tr>';
//            dump($html);
//            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        }
        $html = $html . '</tbody></table></body></html>';

//        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        $filename = "zzoo";

//        $file = file_put_contents('doc/froga.html', $html);

        $reader = IOFactory::createReader('HTML');
        $phpWord = $reader->load("doc/froga.html");

//        $section->addText('By default, when you insert an image, it adds a textbreak after its content.');
//        $section->addText('If we want a simple border around an image, we wrap the image inside a table->row->cell');
//        $section->addText(
//            'On the image with the red border, even if we set the row height to the height of the image, '
//            . 'the textbreak is still there:'
//        );
//        $table1 = $section->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
//        $table1->addRow(3750);
//        $cell1 = $table1->addCell(null, array('valign' => 'top', 'borderSize' => 30, 'borderColor' => 'ff0000'));
//        $cell1->addText($html);
//
//        $section->addTextBreak();
//        $section->addText("But if we set the rowStyle 'exactHeight' to true, the real row height is used, removing the textbreak:");
//        $table2 = $section->addTable(
//            array(
//                'cellMargin'       => 0,
//                'cellMarginRight'  => 0,
//                'cellMarginBottom' => 0,
//                'cellMarginLeft'   => 0,
//            )
//        );
//        $table2->addRow(3750, array('exactHeight' => true));
//        $cell2 = $table2->addCell(null, array('valign' => 'top', 'borderSize' => 30, 'borderColor' => '00ff00'));
////        $cell2->addHtml($html);
//        \PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $html);
//        $section->addTextBreak();
//        $section->addText('In this example, image is 250px height. Rows are calculated in twips, and 1px = 15twips.');
//        $section->addText('So: $' . "table2->addRow(3750, array('exactHeight'=>true));");

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

    function xmlEntities($str)
    {
        $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
        $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
        $str = str_replace($html, $xml, $str);
        $str = str_ireplace($html, $xml, $str);
        return $str;
    }
}
