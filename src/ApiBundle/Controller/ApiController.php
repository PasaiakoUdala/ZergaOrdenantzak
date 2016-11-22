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
     * Ordenantza guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Ordenantza guztien zerrenda eskuratu",
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
    public function getOrdenantzakAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $ordenantzak = $em->getRepository('AppBundle:Ordenantza')->findAll();
        $view = View::create();
        $view->setData($ordenantzak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_ordenantzak"            [GET] /ordenantzak

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Ordenantza baten informazioa eskuratu"
     * )
     *
     * @Annotations\View()
     */
    public function getOrdenantzaAction($id){
        $em         = $this->getDoctrine()->getManager();
        $ordenantza = $em->getRepository('AppBundle:Ordenantza')->findById($id);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $ordenantza;
    }// "get_ordenantza"            [GET] /ordenantza/{id}

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
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
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
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $atala;
    }// "get_atala"            [GET] /atala/{id}

    /**
     * Udal baten Azpiatal zerrenda.
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
    public function getAzpiatalakAction($udalaid)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery('SELECT p.id, p.kodea, p.izenburuaeu FROM AppBundle:Azpiatala p WHERE p.udala=:udalaid');
        $query->setParameter( 'udalaid', $udalaid );
        $azpiatalak = $query->getResult();

        $view = View::create();
        $view->setData($azpiatalak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_azpiatalak"            [GET] /azpiatalak/{udalaid}

    /**
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
    public function getAzpiatalaAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $azpiatalak = $em->getRepository( 'AppBundle:Azpiatala' )->findOneById( $id );

        $view = View::create();
        $view->setData($azpiatalak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_azpiatala"            [GET] /azpiatala/{id}

}