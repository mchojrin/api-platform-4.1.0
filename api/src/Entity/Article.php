<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true, security: "is_granted('ROLE_USER')")]
#[Get]
#[GetCollection]
#[Post(security: "is_granted('ROLE_WRITER')")]
#[Get(security: "object.getAuthor() == user or object.getClient() == user")]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToOne(inversedBy: 'assignment', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Assignment $assignement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAssignement(): ?Assignment
    {
        return $this->assignement;
    }

    public function setAssignement(Assignment $assignement): static
    {
        $this->assignement = $assignement;

        return $this;
    }

    public function getAuthor(): Writer
    {
        return $this->getAssignement()->getWriter();
    }

    public function getClient() : Client
    {
        return $this->getAssignement()->getClient();
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
