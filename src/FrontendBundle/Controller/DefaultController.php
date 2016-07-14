<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Ordenantza;

class DefaultController extends Controller
{
//    /**
//     * @Route("/")
//     */
//    public function indexAction()
//    {
////        return $this->render('FrontendBundle:Default:index.html.twig');
//        return $this->redirectToRoute('admin_ordenantza_index',array(),301);
//    }


    /**
     * @Route("/{udala}/{_locale}/", name="frontend_ordenantza_index",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *     }
     * )
     */
    public function indexAction($udala)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
          SELECT o FROM AppBundle:Ordenantza o LEFT JOIN AppBundle:Udala u  WITH o.udala=u.id
            WHERE u.kodea = :udala
            ORDER BY o.kodea ASC
        ');
        $query->setParameter('udala', $udala);
        $ordenantzak = $query->getResult();

        return $this->render('frontend\index.html.twig', array(
            'ordenantzas' => $ordenantzak,
            'udala'=>$udala,
        ));        
        
    }

    /**
     * Finds and displays a Ordenantza entity.
     *
     * @Route("/{udala}/{_locale}/{id}", name="frontend_ordenantza_show",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *          }
     * )
     * @Method("GET")
     */
    public function showAction(Ordenantza $ordenantza,$udala)
    {
//        $deleteForm = $this->createDeleteForm($ordenantza);
//        $deleteForms = array();

//        foreach ($ordenantza->getParrafoak() as $p) {
//            $deleteForms[$p->getId()] = $this->createFormBuilder()
//                ->setAction($this->generateUrl('admin_ordenantzaparrafoa_delete', array('id' => $p->getId())))
//                ->setMethod('DELETE')
//                ->getForm()->createView();
//        }

        return $this->render('frontend/show.html.twig', array(
            'ordenantza' => $ordenantza,
            'udala'=>$udala
//            'delete_form' => $deleteForm->createView(),
        ));
    }

}
