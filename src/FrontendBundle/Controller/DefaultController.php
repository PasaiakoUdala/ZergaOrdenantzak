<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordenantzas = $em->getRepository('AppBundle:Ordenantza')->findAll();

        return $this->render('ordenantza/index.html.twig', array(
            'ordenantzas' => $ordenantzas,
        ));
    }
}
