<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
//        return $this->render('FrontendBundle:Default:index.html.twig');
        return $this->redirectToRoute('admin_ordenantza_index',array(),301);
    }
}
