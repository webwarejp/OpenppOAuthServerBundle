<?php

namespace Openpp\OAuthServerBundle\EventListener;

use FOS\OAuthServerBundle\Event\OAuthEvent;
use Doctrine\ORM\EntityManager;
use Openpp\OAuthServerBundle\Entity\Client;

/**
 * Class OAuthEventListener
 * @package Openpp\OAuthServerBundle\EventListener
 */
class OAuthEventListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * called fos_oauth_server.pre_authorization_process
     *
     * client が isPrivate trueのとき認可する。
     *
     * @param OAuthEvent $event
     */
    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        /* @var $client Client */
        if(null !== $client = $event->getClient())
        {
            if ($client->isPrivate())
            {
                $event->setAuthorizedClient(true);
            }
        }
    }
}