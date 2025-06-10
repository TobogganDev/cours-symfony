<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Message\SendAdminNotificationMessage;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Article::class)]
class ArticleListener
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function postPersist(Article $article, PostPersistEventArgs $event): void
    {
        // Envoyer un message pour notifier les admins
        $this->messageBus->dispatch(new SendAdminNotificationMessage(
            $article->getId(),
            $article->getTitle(),
            $article->getUser()->getEmail()
        ));
    }
}
