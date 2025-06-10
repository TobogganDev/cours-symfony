<?php

namespace App\EventListener;

use App\Entity\Trait\TimestampableTrait;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
class TimestampableListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        // Vérifier si l'entité utilise le trait TimestampableTrait
        if (in_array(TimestampableTrait::class, class_uses($entity))) {
            $entity->setCreatedAtValue();
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        // Vérifier si l'entité utilise le trait TimestampableTrait
        if (in_array(TimestampableTrait::class, class_uses($entity))) {
            $entity->setUpdatedAtValue();
        }
    }
}
