<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use function Symfony\Component\Clock\now;

#[AsEventListener]
final class ActivityListener
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $user = $this->security->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }

        $user->setLastActivity(now());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
