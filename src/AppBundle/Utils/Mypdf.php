<?php
    /**
     * User: iibarguren
     * Date: 2/08/16
     * Time: 12:08
     */

    namespace AppBundle\Utils;

    class Mypdf extends \TCPDF
    {
        public $footerTitle = '';

        public function Footer()
        {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, $this->footerTitle, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }