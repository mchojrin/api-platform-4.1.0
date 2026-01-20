<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SubscriptionLevelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: SubscriptionLevelRepository::class)]
class SubscriptionLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $minWaitDays = null;

    #[ORM\Column]
    private ?int $maxWaitDays = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMinWaitDays(): ?int
    {
        return $this->minWaitDays;
    }

    public function setMinWaitDays(int $minWaitDays): static
    {
        $this->minWaitDays = $minWaitDays;

        return $this;
    }

    public function getMaxWaitDays(): ?int
    {
        return $this->maxWaitDays;
    }

    public function setMaxWaitDays(int $maxWaitDays): static
    {
        $this->maxWaitDays = $maxWaitDays;

        return $this;
    }

    public function __tostring(): string
    {
        return $this->name;
    }
}
