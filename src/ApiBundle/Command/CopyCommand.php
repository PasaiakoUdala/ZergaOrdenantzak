<?php

namespace ApiBundle\Command;

use AppBundle\Entity\Atala;
use AppBundle\Entity\Atalaparrafoa;
use AppBundle\Entity\Azpiatala;
use AppBundle\Entity\Azpiatalaparrafoa;
use AppBundle\Entity\Azpiatalaparrafoaondoren;
use AppBundle\Entity\Baldintza;
use AppBundle\Entity\Eremua;
use AppBundle\Entity\Eremumota;
use AppBundle\Entity\Historikoa;
use AppBundle\Entity\Kontzeptua;
use AppBundle\Entity\Kontzeptumota;
use AppBundle\Entity\Ordenantza;
use AppBundle\Entity\Ordenantzaparrafoa;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use AppBundle\Entity\Udala;

class CopyCommand extends ContainerAwareCommand {

  protected function configure()
  {
    $this
      ->setName('app:copy')
      ->setDescription('Udal baten zerga ordenantzak beste udal batean kopiatzen ditu')
      ->addArgument('ori', InputArgument::OPTIONAL, 'Abiapuntu udal kodea:')
      ->addArgument('des', InputArgument::OPTIONAL, 'Helmuga udal kodea:');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $ori = $input->getArgument('ori');
    $des = $input->getArgument('des');
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
    $helper = $this->getHelper('question');

    if ((!$ori) || (!$des))
    {
      $oriquestion = new Question('Abiapuntu udal kodea? => ', false);
      $output->writeln('');
      $desquestion = new Question('Helmuga udal kodea? => ', false);
      $ori         = $helper->ask($input, $output, $oriquestion);
      $des         = $helper->ask($input, $output, $desquestion);

      if (!$ori)
      {
        return;
      }
      if (!$des)
      {
        return;
      }
    }


    $em = $this->getContainer()->get('doctrine')->getManager();
    /** @var Udala $oriUdala */
    $oriUdala = $em->getRepository('AppBundle:Udala')->findOneBy(array('kodea' => $ori,));
    /** @var Udala $desUdala */
    $desUdala = $em->getRepository('AppBundle:Udala')->findOneBy(array('kodea' => $des,));

    $seguruQuestion = new ConfirmationQuestion(
      $oriUdala->getIzenaeu().' udaleko datuak '.$desUdala->getIzenaeu().' udalean kopiatuko dira. Ziur zaude? OHARRA: Helburuko datuak ezabatu egingo dira lehenbizi.t (Y/N): ',
      true
    );
    if (!$helper->ask($input, $output, $seguruQuestion))
    {
      $output->writeln('');
      $output->writeln('');
      $output->writeln('');
      $output->writeln('Agur.');
      $output->writeln('');
      $output->writeln('');

      return;
    }

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** BALDINTZA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko baldintzak ezabatzen...');
    $desBaldintza = $em->getRepository('AppBundle:Baldintza')->findBy(array('udala' => $desUdala->getId()));
    /** @var Baldintza $d */
    foreach ($desBaldintza as $d){
      $em->remove($d);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Baldintzak kopiatzen... ');
    $oriBaldintza = $em->getRepository('AppBundle:Baldintza')->findBy(array('udala' => $oriUdala->getId()));

    /** @var Baldintza $b */
    foreach ($oriBaldintza as $b) {
      $baldintza = new Baldintza();
      $baldintza->setBaldintzaes($b->getBaldintzaes());
      $baldintza->setBaldintzaeu($b->getBaldintzaeu());
      $baldintza->setUdala($desUdala);
      $baldintza->setOrigenid($b->getId());
      $em->persist($baldintza);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** EREMU MOTA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Eremu motak ezabatzen...');
    $desEremuMota = $em->getRepository('AppBundle:Eremumota')->findBy(array('udala' => $desUdala->getId()));
    /** @var Eremumota $d */
    foreach ($desEremuMota as $d){
      $em->remove($d);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Eremu motak kopiatzen... ');
    $oriEremuMota = $em->getRepository('AppBundle:Eremumota')->findBy(array('udala' => $oriUdala->getId()));

    /** @var Eremumota $erm */
    foreach ($oriEremuMota as $erm) {
      $eremuMota = new Eremumota();
      $eremuMota->setOrigenid($erm->getId());
      $eremuMota->setUdala($desUdala);
      $eremuMota->setMotaes($erm->getMotaes());
      $eremuMota->setMotaeu($erm->getMotaeu());
      $em->persist($eremuMota);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** EREMUA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Eremuak ezabatzen...');
    $desEremua = $em->getRepository('AppBundle:Eremua')->findBy(array('udala' => $desUdala->getId()));
    /** @var Eremua $e */
    foreach ($desEremua as $e){
      $em->remove($e);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Eremuak kopiatzen... ');
    $oriEremua = $em->getRepository('AppBundle:Eremua')->findBy(array('udala' => $oriUdala->getId()));

    /** @var Eremua $e */
    foreach ($oriEremua as $e) {
      $eremua = new Eremua();
      $eremua->setUdala($desUdala);
      $eremua->setOrigenid($e->getId());
      /** @var Eremumota $_eremu_mota */
      $_eremu_mota = $em->getRepository('AppBundle:Eremumota')->findOneBy(array('origenid' => $e->getEremumota()->getId()));
      $eremua->setEremumota($_eremu_mota);
      $eremua->setEtiketaes($e->getEtiketaes());
      $eremua->setEtiketaeu($e->getEtiketaeu());
      $eremua->setIzena($e->getIzena());
      $em->persist($eremua);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();




    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** KONTZEPTU MOtA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Kontzeptu motak ezabatzen...');
    $desKontzeptuMota= $em->getRepository('AppBundle:Kontzeptumota')->findBy(array('udala' => $desUdala->getId()));
    /** @var Kontzeptumota $k */
    foreach ($desKontzeptuMota as $d){
      $em->remove($d);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Kontzeptu motak kopiatzen... ');
    $oriKontzeptuMota = $em->getRepository('AppBundle:Kontzeptumota')->findBy(array('udala' => $oriUdala->getId()));

    /** @var Kontzeptumota $km */
    foreach ($oriKontzeptuMota as $km) {
      $kontzeptumota = new Kontzeptumota();
      $kontzeptumota->setOrigenid($km->getId());
      $kontzeptumota->setUdala($desUdala);
      $kontzeptumota->setMotaeu($km->getMotaeu());
      $kontzeptumota->setMotaes($km->getMotaes());
      $em->persist($kontzeptumota);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();




    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ORDENANTZA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Ordenantzak ezabatzen...');
    $desOrdenantza = $em->getRepository('AppBundle:Ordenantza')->findBy(array('udala' => $desUdala->getId()));
    /** @var Ordenantza $k */
    foreach ($desOrdenantza as $o){
      $em->remove($o);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Ordenantzak kopiatzen... ');
    $oriOrdenantza= $em->getRepository('AppBundle:Ordenantza')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Ordenantza $o */
    foreach ($oriOrdenantza as $o) {
      $ordenantza = new Ordenantza();
      $ordenantza->setEzabatu($o->getEzabatu());
      $ordenantza->setIzenburuaes($o->getIzenburuaes());
      $ordenantza->setIzenburuaesProd($o->getIzenburuaesProd());
      $ordenantza->setIzenburuaeu($o->getIzenburuaeu());
      $ordenantza->setIzenburuaeuProd($o->getIzenburuaeuProd());
      $ordenantza->setKodea($o->getKodea());
      $ordenantza->setKodeaProd($o->getKodeaProd());
      $ordenantza->setOrigenid($o->getId());
      $ordenantza->setUdala($desUdala);
      $em->persist($ordenantza);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ORDENANTZA PARRAFOA********************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Ordenantzen parrafoak ezabatzen...');
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Ordenantzaparrafoa','op')->where('op.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    $output->writeln('Ok');
    $output->write('++ Ordenantzen parrafoak kopiatzen...');
    $oriOrdenantzaParrafoa = $em->getRepository('AppBundle:Ordenantzaparrafoa')->findBy(array('udala' => $oriUdala->getId()));

    /** @var Ordenantzaparrafoa $op */
    foreach ($oriOrdenantzaParrafoa as $op) {
      $ordenantzaParrafoa = new Ordenantzaparrafoa();
      $ordenantzaParrafoa->setUdala($desUdala);
      $ordenantzaParrafoa->setOrigenid($op->getId());
      $ordenantzaParrafoa->setEzabatu($op->getEzabatu());
      $ordenantzaParrafoa->setOrdena($op->getOrdena());
      /** @var Ordenantza $_ordenantza */
      $_ordenantza = $em->getRepository('AppBundle:Ordenantza')->findOneBy(
        array(
          'origenid' => $op->getOrdenantza()->getId(),
        )
      );
      $ordenantzaParrafoa->setOrdenantza($_ordenantza);
      $ordenantzaParrafoa->setOrdena($op->getOrdena());
      $ordenantzaParrafoa->setOrdenaProd($op->getOrdenaProd());
      $ordenantzaParrafoa->setTestuaes($op->getTestuaes());
      $ordenantzaParrafoa->setTestuaesProd($op->getTestuaesProd());
      $ordenantzaParrafoa->setTestuaeu($op->getTestuaeu());
      $ordenantzaParrafoa->setTestuaeuProd($op->getTestuaeuProd());
      $em->persist($ordenantzaParrafoa);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ATALA *********************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Atalak ezabatzen...');
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Atala','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    $output->writeln('Ok');
    $output->write('++ Atalak kopiatzen...');
    $oriAtalak = $em->getRepository('AppBundle:Atala')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Atala $a */
    foreach ($oriAtalak as $a) {
      $atala = new Atala();
      /** @var Ordenantza $_ordenantza */
      $_ordenantza = $em->getRepository('AppBundle:Ordenantza')->findOneBy(
        array(
          'origenid' => $a->getOrdenantza()->getId(),
        )
      );
      $atala->setOrdenantza($_ordenantza);
      $atala->setEzabatu($a->getEzabatu());
      $atala->setOrigenid($a->getId());
      $atala->setUdala($desUdala);
      $atala->setKodeaProd($a->getKodeaProd());
      $atala->setKodea($a->getKodea());
      $atala->setIzenburuaeuProd($a->getIzenburuaeuProd());
      $atala->setIzenburuaeu($a->getIzenburuaeu());
      $atala->setIzenburuaesProd($a->getIzenburuaesProd());
      $atala->setIzenburuaes($a->getIzenburuaes());
      $atala->setUtsa($a->getUtsa());
      $atala->setUtsaProd($a->getUtsaProd());
      $em->persist($atala);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ATALA PARRAFOA ************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Atalen parrafoak ezabatzen...');
    $desAtalaParrafoa= $em->getRepository('AppBundle:Atalaparrafoa')->findBy(array('udala' => $desUdala->getId()));
    /** @var Atalaparrafoa $a */
    foreach ($desAtalaParrafoa as $a){
      $em->remove($a);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Atal parrafoak kopiatzen...');
    $oriAtalParrafoa = $em->getRepository('AppBundle:Atalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Atalaparrafoa $ap */
    foreach ($oriAtalParrafoa as $ap) {
      $atalaParrafoa = new Atalaparrafoa();
      $atalaParrafoa->setUdala($desUdala);
      $atalaParrafoa->setOrigenid($ap->getId());
      $atalaParrafoa->setEzabatu($ap->getEzabatu());
      $atalaParrafoa->setTestuaeuProd($ap->getTestuaeuProd());
      $atalaParrafoa->setTestuaeu($ap->getTestuaeu());
      $atalaParrafoa->setTestuaesProd($ap->getTestuaesProd());
      $atalaParrafoa->setTestuaes($ap->getTestuaes());
      $atalaParrafoa->setOrdenaProd($ap->getOrdenaProd());
      $atalaParrafoa->setOrdena($ap->getOrdena());
      /** @var Atala $_atala */
      $_atala = $em->getRepository('AppBundle:Atala')->findOneBy(
        array(
          'origenid' => $ap->getAtala()->getId(),
        )
      );
      $atalaParrafoa->setAtala($_atala);
      $em->persist($atalaParrafoa);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPI ATALA ************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Azpi Atal datuak ezabatzen...');
    $helAzpiatala = $em->getRepository('AppBundle:Azpiatala')->findBy(array('udala' => $desUdala->getId()));
        /** @var Azpiatala $h */
    foreach ($helAzpiatala as $h) {
      $em->remove($h);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Azpi atalak kopiatzen...');
    $oriAzpiAtala = $em->getRepository('AppBundle:Azpiatala')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Azpiatala $aa */
    foreach ($oriAzpiAtala as $aa) {
      $azpiatala = new Azpiatala();
      /** @var Atala $_atala */
      $_atala = $em->getRepository('AppBundle:Atala')->findOneBy(
        array(
          'origenid' => $aa->getAtala()->getId(),
        )
      );
      $azpiatala->setAtala($_atala);
      $azpiatala->setEzabatu($aa->getEzabatu());
      $azpiatala->setOrigenid($aa->getId());
      $azpiatala->setUdala($desUdala);
      $azpiatala->setIzenburuaes($aa->getIzenburuaes());
      $azpiatala->setIzenburuaesProd($aa->getIzenburuaesProd());
      $azpiatala->setIzenburuaeu($aa->getIzenburuaeu());
      $azpiatala->setIzenburuaeuProd($aa->getIzenburuaeuProd());
      $azpiatala->setKodea($aa->getKodea());
      $azpiatala->setKodeaProd($aa->getKodeaProd());
      $em->persist($azpiatala);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPIATALA PARRAFOA  *******************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Azpi Atal parrafoak datuak ezabatzen...');
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Azpiatalaparrafoa','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    $output->writeln('Ok');
    $output->write('++ Azpi atala parrafoak kopiatzen...');
    $oriAzpiAtalaParrafoa = $em->getRepository('AppBundle:Azpiatalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Azpiatalaparrafoa $aap */
    foreach ($oriAzpiAtalaParrafoa as $aap) {
      $azpiAtalaParrafoa = new Azpiatalaparrafoa();
      $azpiAtalaParrafoa->setUdala($desUdala);
      $azpiAtalaParrafoa->setOrigenid($aap->getId());
      $azpiAtalaParrafoa->setEzabatu($aap->getEzabatu());
      $azpiAtalaParrafoa->setOrdena($aap->getOrdena());
      $azpiAtalaParrafoa->setOrdenaProd($aap->getOrdenaProd());
      $azpiAtalaParrafoa->setTestuaes($aap->getTestuaes());
      $azpiAtalaParrafoa->setTestuaesProd($aap->getTestuaesProd());
      $azpiAtalaParrafoa->setTestuaeu($aap->getTestuaeu());
      $azpiAtalaParrafoa->setTestuaeuProd($aap->getTestuaeuProd());
      if ($aap->getAzpiatala()) {
        /** @var Azpiatala $_azpiatala */
        $_azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneBy(
          array(
            'origenid' => $aap->getAzpiatala()->getId(),
          )
        );
        $azpiAtalaParrafoa->setAzpiatala($_azpiatala);
      }

      $em->persist($azpiAtalaParrafoa);

    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPIATALA PARRAFOA ONDOREN ************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Azpi Atal parrafoak (ondoren) datuak ezabatzen...');
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Azpiatalaparrafoaondoren','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    $output->writeln('OK');
    $output->write('++ Azpi atala parrafoak (ondoren) kopiatzen...');
    $oriAzpiAtalaParrafoaOndoren = $em->getRepository('AppBundle:Azpiatalaparrafoaondoren')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Azpiatalaparrafoaondoren $aapo */
    foreach ($oriAzpiAtalaParrafoaOndoren as $aapo) {
      $azpiAtalaParrafoaondoren = new Azpiatalaparrafoaondoren();
      $azpiAtalaParrafoaondoren->setUdala($desUdala);
      if ($aapo->getAzpiatala()) {
        /** @var Azpiatala $_azpiatala */
        $_azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneBy(
          array(
            'origenid' => $aapo->getAzpiatala()->getId(),
          )
        );
        $azpiAtalaParrafoaondoren->setAzpiatala($_azpiatala);
      }
      $azpiAtalaParrafoaondoren->setTestuaeuProd($aapo->getTestuaeuProd());
      $azpiAtalaParrafoaondoren->setTestuaeu($aapo->getTestuaeu());
      $azpiAtalaParrafoaondoren->setTestuaesProd($aapo->getTestuaesProd());
      $azpiAtalaParrafoaondoren->setTestuaes($aapo->getTestuaes());
      $azpiAtalaParrafoaondoren->setOrdenaProd($aapo->getOrdenaProd());
      $azpiAtalaParrafoaondoren->setOrdena($aapo->getOrdena());
      $azpiAtalaParrafoaondoren->setEzabatu($aapo->getEzabatu());
      $azpiAtalaParrafoaondoren->setOrigenid($aapo->getId());

      $em->persist($azpiAtalaParrafoaondoren);

    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** KONTZEPTUA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Kontzeptuk ezabatzen...');
    $desKontzeptua= $em->getRepository('AppBundle:Kontzeptua')->findBy(array('udala' => $desUdala->getId()));
    /** @var Kontzeptua $k */
    foreach ($desKontzeptua as $d){
      $em->remove($d);
      $em->flush();
    }
    $output->writeln('Ok');
    $output->write('++ Kontzeptuak kopiatzen... ');
    $oriKontzeptua = $em->getRepository('AppBundle:Kontzeptua')->findBy(array('udala' => $oriUdala->getId()));
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Kontzeptua','k')->where('k.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    /** @var Kontzeptua $k */
    foreach ($oriKontzeptua as $k) {
      $kontzeptua = new Kontzeptua();
      $kontzeptua->setUdala($desUdala);
      $kontzeptua->setOrigenid($k->getId());
      if ($k->getBaldintza()) {
        /** @var Baldintza $_baldintza */
        $_baldintza = $em->getRepository('AppBundle:Baldintza')->findOneBy(
          array(
            'origenid' => $k->getBaldintza()->getId(),
          )
        );
        $kontzeptua->setBaldintza($_baldintza);
      }
      $kontzeptua->setEzabatu($k->getEzabatu());
      $kontzeptua->setKodea($k->getKodea());
      $kontzeptua->setKodeaProd($k->getKodeaProd());
      $kontzeptua->setKodea($k->getKodea());
      $kontzeptua->setKontzeptuaes($k->getKontzeptuaes());
      $kontzeptua->setKontzeptuaesProd($k->getKontzeptuaesProd());
      $kontzeptua->setKontzeptuaeu($k->getKontzeptuaeu());
      $kontzeptua->setKontzeptuaeuProd($k->getKontzeptuaeuProd());
      if ($k->getKontzeptumota()) {
        /** @var Kontzeptumota $_kontzeptu_mota */
        $_kontzeptu_mota = $em->getRepository('AppBundle:Kontzeptumota')->findOneBy(
          array(
            'origenid' => $k->getKontzeptumota()->getId(),
          )
        );
        $kontzeptua->setKontzeptumota($_kontzeptu_mota);
      }

      if ($k->getAzpiatala()) {
        $_azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneBy(
          array(
            'origenid' => $k->getAzpiatala()->getId(),
            'udala' => $desUdala
          )
        );
        $kontzeptua->setAzpiatala($_azpiatala);
      }
      $kontzeptua->setKopurua($k->getKopurua());
      $kontzeptua->setKopuruaProd($k->getKopuruaProd());
      $kontzeptua->setUnitatea($k->getUnitatea());
      $kontzeptua->setUnitateaProd($k->getUnitateaProd());

      $em->persist($kontzeptua);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** HISTORIKOA  ***************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('-- Helmugako udaleko Historikoa ezabatzen...');
    /** @var QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Historikoa','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
    $output->writeln('Ok');
    $output->write('++ Historikoa kopiatzen...');
    $oriHistorikoa = $em->getRepository('AppBundle:Historikoa')->findBy(array('udala' => $oriUdala->getId()));
    /** @var Historikoa $h */
    foreach ($oriHistorikoa as $h) {
      $his = new Historikoa();
      $his->setOrigenid($h->getId());
      $his->setUdala($desUdala);
      $his->setAldaketakes($h->getAldaketakes());
      $his->setAldaketakeu($h->getAldaketakeu());
      $his->setBogargitaratzedata($h->getBogargitaratzedata());
      $his->setBogargitaratzedatatestua($h->getBogargitaratzedatatestua());
      $his->setBogbehinbetikodata($h->getBogbehinbetikodata());
      $his->setBogestekaes($h->getBogestekaes());
      $his->setBogestekaeu($h->getBogestekaeu());
      $his->setFitxategia($h->getFitxategia());
      $his->setIndarreandata($h->getIndarreandata());
      $his->setOnartzedata($h->getOnartzedata());
      $em->persist($his);
    }
    $output->write('OK.');
    $output->writeln('');
    $output->writeln('');
    $em->flush();


  }
}
