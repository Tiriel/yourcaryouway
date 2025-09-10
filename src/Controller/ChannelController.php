<?php

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Lazy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ChannelController extends AbstractController
{
    public function __construct(
        #[Lazy] private EntityManagerInterface $manager,
    ) {
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/chat', name: 'app_channel_chat', methods: ['GET'])]
    public function chat(#[CurrentUser] User $user, ChannelRepository $channelRepository, MessageRepository $messageRepository): Response
    {
        $channel = $channelRepository->findForUser($user);

        if (null === $channel) {
            $support = $this->manager->getRepository(User::class)->findOneBy(['online' => true]);
            $channel = new Channel()
                ->addUser($support)
                ->addUser($user)
            ;

            $this->manager->persist($channel);
            $this->manager->flush();
        }

        $messages = $messageRepository->findBy(['channel' => $channel], ['createdAt' => 'ASC']);

        return $this->render('channel/chat.html.twig', [
            'channel' => $channel,
            'messages' => $messages,
        ]);
    }
}
