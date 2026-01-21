<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\NotBlank(message: "A client must have a subscription level.")]
    private ?SubscriptionLevel $subscriptionLevel = null;

    public function getSubscriptionLevel(): ?SubscriptionLevel
    {
        return $this->subscriptionLevel;
    }

    public function setSubscriptionLevel(?SubscriptionLevel $subscriptionLevel): static
    {
        $this->subscriptionLevel = $subscriptionLevel;

        return $this;
    }

    public function getRoles(): array
    {
        return array_merge(parent::getRoles(), ['ROLE_CLIENT']);
    }
}
