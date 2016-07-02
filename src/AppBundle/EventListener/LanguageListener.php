<?php
/**
 * Created by PhpStorm.
 * User: ikerib
 * Date: 30/06/2016
 * Time: 23:37
 */
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LanguageListener
{
//    private $session;
//
    public function setSession(Session $session)
    {
//        $this->session = $session;
    }

    public function setLocale(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        var_dump("listener =>".$request->getPreferredLanguage());
        if ( $request->getPreferredLanguage()=="eu") {
            dump('es jartzen');
            $request->setLocale('es');
        }else {
            dump('EU jartzen');
            $request->setLocale('eu');
        }

//        $request->setLocale($request->getPreferredLanguage(array('es', 'eu')));

    }
}