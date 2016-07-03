<?php
/**
 * Created by PhpStorm.
 * User: ikerib
 * Date: 30/06/2016
 * Time: 23:37
 */
namespace AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LanguageListener
{
    private $token_storage;

    private $container;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
        $this->token_storage = $this->container->get('security.token_storage');;

    }

    public function setLocale(GetResponseEvent $event)
    {

        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        //Get default language code from current user
        $userLocale = $this->token_storage->getToken()->getUser()
            ->getHizkuntza();

        //if default lamguage is set - change locale
        if ($userLocale) {
            $request = $event->getRequest();
            $request->setLocale($userLocale);
            $translator = $this->container->get('translator');
            $translator->setLocale($userLocale);
        }


    }
}