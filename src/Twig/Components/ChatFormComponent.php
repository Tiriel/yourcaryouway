<?php

namespace App\Twig\Components;

use App\Entity\Channel;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use function Symfony\Component\Clock\now;

#[AsLiveComponent]
final class ChatFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Channel $channel = null;

    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly HubInterface $hub,
    ) {
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();
        /** @var Message $message */
        $message = $this->getForm()->getData();
        $message
            ->setSentBy($this->getUser())
            ->setCreatedAt(now())
            ->setChannel($this->channel);
        $this->manager->persist($message);
        $this->manager->flush();

        $this->resetForm();
    }


    public function instantiateForm(): FormInterface
    {
        return $this->createForm(MessageType::class, new Message());
    }
}
