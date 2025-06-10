<?php

namespace App\MessageHandler;

use App\Entity\Notification;
use App\Message\SendAdminNotificationMessage;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendAdminNotificationMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(SendAdminNotificationMessage $message): void
    {
        // Récupérer tous les admins
        $admins = $this->userRepository->findByRole('ROLE_ADMIN');

        foreach ($admins as $admin) {
            $notification = new Notification();
            $notification->setUser($admin);
            $notification->setLabel(sprintf(
                'Nouvel article créé: "%s" par %s',
                $message->getArticleTitle(),
                $message->getAuthorEmail()
            ));

            $this->entityManager->persist($notification);
        }

        $this->entityManager->flush();
    }
}
