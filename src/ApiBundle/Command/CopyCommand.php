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
    $output->write('Baldintza kopiatzen ');
    $oriBaldintza = $em->getRepository('AppBundle:Baldintza')->findBy(array('udala' => $oriUdala->getId()));

    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Baldintza','b')->where('b.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** EREMU MOTA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Eremu motak kopiatzen ');
    $oriEremuMota = $em->getRepository('AppBundle:Eremumota')->findBy(array('udala' => $oriUdala->getId()));

    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Eremumota','e')->where('e.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** EREMUA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Eremua kopiatzen ');
    $oriEremua = $em->getRepository('AppBundle:Eremua')->findBy(array('udala' => $oriUdala->getId()));

    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Eremua','e')->where('e.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();
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
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** KONTZEPTU MOtA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Kontzeptu motak kopiatzen ');
    $oriKontzeptuMota = $em->getRepository('AppBundle:Kontzeptumota')->findBy(array('udala' => $oriUdala->getId()));

    /** Ez ditugu ezabatzen ze errorea emateu */
//    /** @var \Doctrine\ORM\QueryBuilder $qb */
//    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Kontzeptumota','km')->where('km.udala = :udalaID');
//    $qb->setParameter('udalaID', $desUdala);
//    $qb->getQuery()->execute();
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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** KONTZEPTUA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Kontzeptua kopiatzen ');
    $oriKontzeptua = $em->getRepository('AppBundle:Kontzeptua')->findBy(array('udala' => $oriUdala->getId()));


    /** @var \Doctrine\ORM\QueryBuilder $qb */
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
      // TODO: gehitu azpiatala Kontzeptuetan
      //$kontzeptua->setAzpiatala();
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
      $kontzeptua->setKopurua($k->getKopurua());
      $kontzeptua->setKopuruaProd($k->getKopuruaProd());
      $kontzeptua->setUnitatea($k->getUnitatea());
      $kontzeptua->setUnitateaProd($k->getUnitateaProd());

      $em->persist($kontzeptua);
    }
    $output->write('OK.');
    $output->writeln('');
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ORDENANTZA ******************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Ordenantzak kopiatzen ');
    $oriOrdenantza= $em->getRepository('AppBundle:Ordenantza')->findBy(array('udala' => $oriUdala->getId()));

    // TODO
//    /** @var \Doctrine\ORM\QueryBuilder $qb */
//    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Ordenantza','o')->where('o.udala = :udalaID');
//    $qb->setParameter('udalaID', $desUdala);
//    $qb->getQuery()->execute();

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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ORDENANTZA PARRAFOA********************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Ordenantzen parrafoak kopiatzen ');
    $oriOrdenantzaParrafoa = $em->getRepository('AppBundle:Ordenantzaparrafoa')->findBy(array('udala' => $oriUdala->getId()));


    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Ordenantzaparrafoa','op')->where('op.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();

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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ATALA *********************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Atalak kopiatzen ');
    $oriAtalak = $em->getRepository('AppBundle:Atala')->findBy(array('udala' => $oriUdala->getId()));

//  TODO
//    /** @var \Doctrine\ORM\QueryBuilder $qb */
//    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Atala','a')->where('a.udala = :udalaID');
//    $qb->setParameter('udalaID', $desUdala);
//    $qb->getQuery()->execute();

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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** ATALA PARRAFOA ************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Atal parrafoak kopiatzen ');
    $oriAtalParrafoa = $em->getRepository('AppBundle:Atalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));


    // TODO
//    /** @var \Doctrine\ORM\QueryBuilder $qb */
//    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Atalaparrafoa','a')->where('a.udala = :udalaID');
//    $qb->setParameter('udalaID', $desUdala);
//    $qb->getQuery()->execute();

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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPI ATALA ************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Azpi atal kopiatzen ');
    $oriAzpiAtala = $em->getRepository('AppBundle:Azpiatala')->findBy(array('udala' => $oriUdala->getId()));



    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Azpiatala','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();

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
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPI ATALA PARRAFOA *******************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Azpi atala parrafoak kopiatzen ');
    $oriAzpiAtalaParrafoa = $em->getRepository('AppBundle:Azpiatalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));



    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Azpiatalaparrafoa','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();

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
      /** @var Azpiatala $_azpiatala */
      $_azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneBy(
        array(
          'origenid' => $aap->getAzpiatala()->getId(),
        )
      );
      $azpiAtalaParrafoa->setAzpiatala($_azpiatala);
      $em->persist($azpiAtalaParrafoa);

    }
    $output->write('OK.');
    $output->writeln('');
    $em->flush();

    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** AZPI ATALA PARRAFOA ONDOREN ***********************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Azpi atala parrafoak (ondoren) kopiatzen ');
    $oriAzpiAtalaParrafoaOndoren = $em->getRepository('AppBundle:Azpiatalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));

    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Azpiatalaparrafoa','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();

    /** @var Azpiatalaparrafoaondoren $aapo */
    foreach ($oriAzpiAtalaParrafoaOndoren as $aapo) {
      $azpiAtalaParrafoaondoren = new Azpiatalaparrafoaondoren();
      /** @var Azpiatala $_azpiatala */
      $_azpiatala = $em->getRepository('AppBundle:Azpiatala')->findOneBy(
        array(
          'origenid' => $aapo->getAzpiatala()->getId(),
        )
      );
      $azpiAtalaParrafoaondoren->setAzpiatala($_azpiatala);
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
    $em->flush();


    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*** HISTORIKOA  ***************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    /*******************************************************************************************************************************************************/
    $output->write('Historikoa kopiatzen ');
    $oriHistorikoa = $em->getRepository('AppBundle:Historikoa')->findBy(array('udala' => $oriUdala->getId()));

    /** @var \Doctrine\ORM\QueryBuilder $qb */
    $qb = $em->createQueryBuilder()->delete()->from('AppBundle:Historikoa','a')->where('a.udala = :udalaID');
    $qb->setParameter('udalaID', $desUdala);
    $qb->getQuery()->execute();

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
    $em->flush();
  }
}
