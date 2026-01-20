<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
class Assignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'assignment', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AssignmentRequest $request = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Writer $writer = null;

    #[ORM\OneToOne(mappedBy: 'assignement', cascade: ['persist', 'remove'])]
    private ?Article $assignment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequest(): ?AssignmentRequest
    {
        return $this->request;
    }

    public function setRequest(AssignmentRequest $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getWriter(): ?Writer
    {
        return $this->writer;
    }

    public function setWriter(?Writer $writer): static
    {
        $this->writer = $writer;

        return $this;
    }

    public function getAssignment(): ?Article
    {
        return $this->assignment;
    }

    public function setAssignment(Article $assignment): static
    {
        // set the owning side of the relation if necessary
        if ($assignment->getAssignement() !== $this) {
            $assignment->setAssignement($this);
        }

        $this->assignment = $assignment;

        return $this;
    }
}
