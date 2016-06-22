<?php
/**
 * User: iibarguren
 * Date: 31/05/16
 * Time: 10:09
 */

namespace ApiBundle\Controller;

use AppBundle\Form\AtalaType;
use AppBundle\Entity\Atala;


use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends FOSRestController
{
    /**
     * Atal guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Atal guztien zerrenda eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     */
    public function getAtalakAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $atalak = $em->getRepository('AppBundle:Atala')->findAll();
        $view = View::create();
        $view->setData($atalak);
        return $view;

    }// "get_atalak"            [GET] /atalak


    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Atal baten informazioa eskuratu"
     * )
     *
     * @Annotations\View()
     */
    public function getAtalaAction($id){
        $em         = $this->getDoctrine()->getManager();
        $atala = $em->getRepository('AppBundle:Atala')->findById($id);
        return $atala;
    }// "get_atala"            [GET] /atala/{id}


    /**
     * Azpiatal guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Azpiatal guztien zerrenda eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     */
    public function getAzpiatalakAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $azpiatalak = $em->getRepository('AppBundle:Azpiatala')->findAll();
        $view = View::create();
        $view->setData($azpiatalak);
        return $view;

    }// "get_azpiatalak"            [GET] /azpiatalak


}