<?php

namespace App\EventSubscriber;

use App\Service\DatabaseTranslator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscriber pour charger les traductions en base de données à chaque requête principale.
 */
class TranslationSubscriber implements EventSubscriberInterface
{
    // Service personnalisé de traduction depuis la base de données
    private $databaseTranslator;

    /**
     * Injection du service DatabaseTranslator.
     */
    public function __construct(DatabaseTranslator $databaseTranslator)
    {
        $this->databaseTranslator = $databaseTranslator;
    }

    /**
     * Définit les événements auxquels ce subscriber réagit.
     * Ici, on réagit à l’événement KernelEvents::REQUEST avec une priorité de 20.
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 20],
        ];
    }

    /**
     * Méthode appelée lors de chaque requête HTTP.
     * Charge les traductions depuis la base de données uniquement pour la requête principale (pas les sous-requêtes).
     */
    public function onKernelRequest(RequestEvent $event)
    {
        // Ne charge les traductions que sur la requête principale (évite les doublons sur les sous-requêtes)
        if (!$event->isMainRequest()) {
            return;
        }

        // Charge les traductions depuis la base
        $this->databaseTranslator->loadTranslations();
    }
}